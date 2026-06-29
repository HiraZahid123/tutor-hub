<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentRequestController;
use App\Http\Controllers\TutorRegistrationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Tutor\AvailabilityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TutorReviewController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\JazzCashController;
use App\Http\Middleware\AdminMiddleware;

// Public Pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/for-students', [PageController::class, 'forStudents'])->name('for-students');
Route::get('/tutor-policy', [PageController::class, 'tutorPolicy'])->name('tutor-policy');
Route::get('/tutoring-process', [PageController::class, 'tutoringFlow'])->name('tutoring-process');
Route::get('/tutors/{id}', [PageController::class, 'tutorProfile'])->name('tutors.show');

// Student Request (Find a Tutor)
Route::get('/find-a-tutor', [StudentRequestController::class, 'create'])->name('find-a-tutor');
Route::post('/find-a-tutor', [StudentRequestController::class, 'store'])->name('find-a-tutor.store');

// Tutor Registration moved further down to auth middleware group

// Contact Form
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit')->middleware('guest');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Portals
Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/learning-requests', [StudentController::class, 'learningRequests'])->name('student.learning-requests');
    Route::post('/tutor-reviews', [TutorReviewController::class, 'store'])->name('tutor-reviews.store');
    Route::get('/student/profile', [StudentController::class, 'editProfile'])->name('student.profile');
    Route::post('/student/profile', [StudentController::class, 'updateProfile'])->name('student.profile.update');
    Route::get('/student/sent-requests', [StudentController::class, 'sentRequests'])->name('student.sent-requests');
    Route::get('/student/book/{tutor}', [StudentController::class, 'showBooking'])->name('student.book');

    Route::get('/tutor/dashboard', [TutorController::class, 'dashboard'])->name('tutor.dashboard');
    Route::get('/tutor/profile', [TutorController::class, 'editProfile'])->name('tutor.profile');
    Route::put('/tutor/profile', [TutorController::class, 'updateProfile'])->name('tutor.profile.update');
    Route::get('/tutor/availability', [AvailabilityController::class, 'index'])->name('tutor.availability');
    Route::post('/tutor/availability', [AvailabilityController::class, 'store'])->name('tutor.availability.store');
    // Chat System (Pusher Real-Time)
    Route::get('/messages', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/messages/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/messages', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/api/messages/{conversation}', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
    Route::post('/api/messages/{conversation}', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/api/messages/{conversation}/read', [ChatController::class, 'markAsRead'])->name('chat.read');
    Route::get('/api/unread-count', [ChatController::class, 'unreadCount'])->name('chat.unread-count');
    Route::get('/api/pending-inquiries-count', [InquiryController::class, 'pendingCount'])->name('tutor.inquiries.count');
    Route::get('/tutor/appointments', [TutorController::class, 'appointments'])->name('tutor.appointments');
    Route::get('/tutor/payments', [TutorController::class, 'payments'])->name('tutor.payments');
    Route::get('/tutor/inquiries', [TutorController::class, 'inquiries'])->name('tutor.inquiries');
    Route::patch('/tutor/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('tutor.inquiries.update');
    // Route::post('/tutor/inquiries/{inquiry}/finalize', [InquiryController::class, 'finalizeHire'])->name('tutor.inquiries.finalize');

    // Tutor Application (New Multi-step)
    Route::get('/register-tutor', [TutorRegistrationController::class, 'create'])->name('register-tutor');
    Route::post('/register-tutor', [TutorRegistrationController::class, 'store'])->name('register-tutor.store');

    // Direct Tutor Inquiry/Hire
    Route::post('/tutor/inquiry', [InquiryController::class, 'store'])->name('tutor.inquiry.store');

    // JazzCash Payment Routes
    Route::get('/payment/jazzcash/checkout/{id}', [JazzCashController::class, 'checkout'])->name('payment.jazzcash.checkout');
    Route::get('/payment/jazzcash/mock-success/{id}', [JazzCashController::class, 'mockSuccess'])->name('payment.jazzcash.mock-success');
});

// JazzCash Callback (Public)
Route::post('/payment/jazzcash/callback', [JazzCashController::class, 'callback'])->name('payment.jazzcash.callback');

// Scheduling API (Public/Student)
Route::get('/api/tutors/{tutor_id}/slots', [BookingController::class, 'availableSlots']);
Route::post('/api/bookings', [BookingController::class, 'book']);
Route::patch('/api/bookings/{id}/status', [BookingController::class, 'updateStatus'])->middleware('auth');

// Admin Routes
Route::redirect('/admin/login', '/login')->name('admin.login');

Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::post('/students/{id}/assign', [AdminController::class, 'assignTutor'])->name('admin.students.assign');
    Route::get('/tutors', [AdminController::class, 'tutors'])->name('admin.tutors');
    Route::get('/interviews', [AdminController::class, 'interviews'])->name('admin.interviews');
    Route::get('/tutors/{id}/edit', [AdminController::class, 'editTutor'])->name('admin.tutors.edit');
    Route::get('/inquiries', [AdminController::class, 'inquiries'])->name('admin.inquiries');
    Route::get('/tutor-inquiries', [AdminController::class, 'tutorInquiries'])->name('admin.tutor-inquiries');
    Route::get('/matches', [AdminController::class, 'matches'])->name('admin.matches');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::get('/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::post('/tutors/{id}/approve', [AdminController::class, 'approveTutor'])->name('admin.tutors.approve');
    Route::patch('/students/{id}/status', [AdminController::class, 'updateStudentStatus'])->name('admin.students.status');
    Route::delete('/tutors/{id}', [AdminController::class, 'destroyTutor'])->name('admin.tutors.destroy');
    Route::delete('/students/{id}', [AdminController::class, 'destroyStudent'])->name('admin.students.destroy');
    Route::delete('/inquiries/{id}', [AdminController::class, 'destroyInquiry'])->name('admin.inquiries.destroy');
    Route::delete('/tutor-inquiries/{id}', [AdminController::class, 'destroyTutorInquiry'])->name('admin.tutor-inquiries.destroy');
    Route::delete('/bookings/{id}', [AdminController::class, 'destroyBooking'])->name('admin.bookings.destroy');
    Route::resource('/subjects', SubjectController::class)->names('admin.subjects');
    Route::post('/categories', [SubjectController::class, 'storeCategory'])->name('admin.categories.store');
    Route::delete('/categories/{category}', [SubjectController::class, 'destroyCategory'])->name('admin.categories.destroy');
    Route::get('/api/counts', [AdminController::class, 'apiCounts'])->name('admin.api.counts');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
