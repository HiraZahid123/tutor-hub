<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function checkout($id)
    {
        $booking = Booking::findOrFail($id);

        // Ensure the student owns this booking
        if ($booking->student_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->payment_status === Booking::STATUS_PAID) {
            return redirect()->route('student.dashboard')->with('info', 'This session is already paid.');
        }

        return view('payment.checkout', compact('booking'));
    }

    public function submit(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->student_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'payment_method' => 'required|in:Bank Alfalah,EasyPaisa,JazzCash',
            'transaction_id' => 'required|string|max:100',
            'receipt' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = [
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
        ];

        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $filename = 'receipt_' . $booking->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/receipts'), $filename);
            $data['payment_receipt'] = 'uploads/receipts/' . $filename;
        }

        $booking->update($data);

        return redirect()->route('student.dashboard')->with('success', 'Payment details submitted successfully! Admin will verify and confirm shortly.');
    }
}
