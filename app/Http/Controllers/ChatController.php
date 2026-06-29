<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Events\MessagesRead;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\StudentRequest;
use App\Models\TutorInquiry;
use App\Models\TutorRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show the messages page with conversation list.
     */
    public function index()
    {
        $user = Auth::user();

        $conversations = Conversation::forUser($user->id)
            ->with(['userOne', 'userTwo', 'latestMessage'])
            ->get()
            ->sortByDesc(fn($c) => $c->latestMessage?->created_at ?? $c->created_at)
            ->values();

        // Get contacts this user is allowed to message
        $contacts = $this->getAvailableContacts($user);

        if ($user->isAdmin()) {
            return view('admin.messages', compact('conversations', 'contacts'));
        }

        return view('chat.index', compact('conversations', 'contacts'));
    }

    /**
     * Show a specific conversation.
     */
    public function show($conversationId)
    {
        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);

        // Verify this user is a participant
        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            abort(403);
        }

        // Mark messages as read
        $updatedRows = Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($updatedRows > 0) {
            broadcast(new MessagesRead($conversationId, $user->id))->toOthers();
        }

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        $conversations = Conversation::forUser($user->id)
            ->with(['userOne', 'userTwo', 'latestMessage'])
            ->get()
            ->sortByDesc(fn($c) => $c->latestMessage?->created_at ?? $c->created_at)
            ->values();

        $contacts = $this->getAvailableContacts($user);
        $otherUser = $conversation->getOtherUser($user->id);

        if ($user->isAdmin()) {
            return view('admin.messages', compact('conversations', 'contacts', 'conversation', 'messages', 'otherUser'));
        }

        return view('chat.index', compact('conversations', 'contacts', 'conversation', 'messages', 'otherUser'));
    }

    /**
     * Start a new conversation with a user.
     */
    public function store(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        $user = Auth::user();
        $targetUserId = $request->user_id;

        if ($user->id == $targetUserId) {
            return back()->with('error', 'You cannot message yourself.');
        }

        // Verify permission
        if (!$this->canMessage($user, $targetUserId)) {
            return back()->with('error', 'You are not authorized to message this user.');
        }

        $conversation = Conversation::findOrCreateBetween($user->id, $targetUserId);

        return redirect()->route('chat.show', $conversation->id);
    }

    /**
     * Send a message via AJAX.
     */
    public function sendMessage(Request $request, $conversationId)
    {
        $request->validate(['body' => 'required|string|max:5000']);

        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => $user->id,
            'body' => $request->body,
        ]);

        $message->load('sender');

        // Broadcast the event
        broadcast(new NewChatMessage($message))->toOthers();

        return response()->json([
            'id' => $message->id,
            'conversation_id' => $message->conversation_id,
            'sender_id' => $message->sender_id,
            'sender_name' => $message->sender->name,
            'body' => $message->body,
            'created_at' => $message->created_at->toDateTimeString(),
            'time_ago' => $message->created_at->diffForHumans(),
        ]);
    }

    /**
     * Fetch messages for a conversation (AJAX).
     */
    public function fetchMessages($conversationId)
    {
        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Mark as read
        $updatedRows = Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($updatedRows > 0) {
            broadcast(new MessagesRead($conversationId, $user->id))->toOthers();
        }

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'sender_id' => $m->sender_id,
                'sender_name' => $m->sender->name,
                'body' => $m->body,
                'created_at' => $m->created_at->toDateTimeString(),
                'time_ago' => $m->created_at->diffForHumans(),
            ]);

        return response()->json($messages);
    }

    /**
     * Mark pending messages as read.
     */
    public function markAsRead($conversationId)
    {
        $user = Auth::user();
        $updatedRows = Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($updatedRows > 0) {
            broadcast(new MessagesRead($conversationId, $user->id))->toOthers();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Return unread count for badge polling.
     */
    public function unreadCount()
    {
        return response()->json([
            'count' => Auth::user()->unreadMessagesCount(),
        ]);
    }

    /**
     * Check if a user is allowed to message another user.
     */
    private function canMessage(User $user, int $targetUserId): bool
    {
        $target = User::findOrFail($targetUserId);

        // Admin can message anyone
        if ($user->isAdmin()) {
            return true;
        }

        // Tutors can message an admin, but students cannot
        if ($target->isAdmin() && !$user->isStudent()) {
            return true;
        }

        // Student can message tutors who accepted their hire inquiry or were matched
        if ($user->isStudent()) {
            $tutorReg = TutorRegistration::where('user_id', $targetUserId)->first();
            if ($tutorReg) {
                $hasInquiry = TutorInquiry::where('student_id', $user->id)
                    ->where('tutor_id', $tutorReg->id)
                    ->where('status', 'hired')
                    ->exists();

                $hasMatch = StudentRequest::where('user_id', $user->id)
                    ->where('assigned_tutor_id', $tutorReg->id)
                    ->where('status', 'matched')
                    ->exists();

                return $hasInquiry || $hasMatch;
            }
            return false;
        }

        // Tutor can message students who hired them or were matched
        if ($user->isTutor()) {
            $tutorReg = TutorRegistration::where('user_id', $user->id)->first();
            if ($tutorReg) {
                $hasInquiry = TutorInquiry::where('tutor_id', $tutorReg->id)
                    ->where('student_id', $targetUserId)
                    ->where('status', 'hired')
                    ->exists();

                $hasMatch = StudentRequest::where('assigned_tutor_id', $tutorReg->id)
                    ->where('user_id', $targetUserId)
                    ->where('status', 'matched')
                    ->exists();

                return $hasInquiry || $hasMatch;
            }
            return false;
        }

        return false;
    }

    /**
     * Get the list of users this person is allowed to start a conversation with.
     */
    private function getAvailableContacts(User $user): \Illuminate\Support\Collection
    {
        if ($user->isAdmin()) {
            // Admin can talk to all students and tutors
            return User::where('id', '!=', $user->id)
                ->whereIn('role', ['student', 'tutor'])
                ->orderBy('name')
                ->get();
        }

        $contactIds = collect();

        // Tutors can see admins in their contact list, students cannot
        if ($user->isTutor()) {
            $adminIds = User::where('role', 'admin')->pluck('id');
            $contactIds = $contactIds->merge($adminIds);
        }

        if ($user->isStudent()) {
            $hiredTutorRegIds = TutorInquiry::where('student_id', $user->id)
                ->where('status', 'hired')
                ->pluck('tutor_id')
                ->toArray();

            $matchedTutorRegIds = StudentRequest::where('user_id', $user->id)
                ->where('status', 'matched')
                ->pluck('assigned_tutor_id')
                ->toArray();

            $allTutorRegIds = array_unique(array_merge($hiredTutorRegIds, $matchedTutorRegIds));
            $tutorUserIds = TutorRegistration::whereIn('id', $allTutorRegIds)->pluck('user_id');
            $contactIds = $contactIds->merge($tutorUserIds);
        }

        if ($user->isTutor()) {
            $tutorReg = TutorRegistration::where('user_id', $user->id)->first();
            if ($tutorReg) {
                $studentIdsFromInquiries = TutorInquiry::where('tutor_id', $tutorReg->id)
                    ->where('status', 'hired')
                    ->pluck('student_id')
                    ->toArray();

                $studentIdsFromRequests = StudentRequest::where('assigned_tutor_id', $tutorReg->id)
                    ->where('status', 'matched')
                    ->pluck('user_id')
                    ->toArray();

                $contactIds = $contactIds->merge($studentIdsFromInquiries)->merge($studentIdsFromRequests);
            }
        }

        // Remove self and fetch user models
        $contactIds = $contactIds->unique()->reject(fn($id) => $id == $user->id);

        // Filter out contacts who already have a conversation with this user
        $existingConvUserIds = Conversation::forUser($user->id)
            ->get()
            ->map(fn($c) => $c->user_one_id == $user->id ? $c->user_two_id : $c->user_one_id);

        $newContactIds = $contactIds->diff($existingConvUserIds);

        return User::whereIn('id', $newContactIds)->orderBy('name')->get();
    }
}
