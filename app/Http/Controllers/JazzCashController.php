<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\JazzCashService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JazzCashController extends Controller
{
    protected $jazzCashService;

    public function __construct(JazzCashService $jazzCashService)
    {
        $this->jazzCashService = $jazzCashService;
    }

    public function checkout($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->payment_status === Booking::STATUS_PAID) {
            return redirect()->route('student.dashboard')->with('info', 'This session is already paid.');
        }

        $paymentData = $this->jazzCashService->preparePaymentData($booking);
        $apiUrl = $this->jazzCashService->getApiUrl();

        return view('payment.jazzcash.checkout', compact('booking', 'paymentData', 'apiUrl'));
    }

    public function callback(Request $request)
    {
        Log::info('JazzCash Callback Header:', $request->all());

        // For Mock Payment, we can check for a special flag or just trust the response
        $bookingId = $request->input('pp_BillReference') 
            ? str_replace('BILL', '', $request->input('pp_BillReference'))
            : $request->input('booking_id');

        $booking = Booking::findOrFail($bookingId);

        if ($request->input('pp_ResponseCode') == '000') {
            $booking->update([
                'payment_status' => Booking::STATUS_PAID,
                'payment_method' => 'JazzCash',
                'transaction_id' => $request->input('pp_TxnRefNo'),
            ]);

            return redirect()->route('student.dashboard')->with('success', 'Payment successful! Your session is confirmed.');
        } else {
            $booking->update([
                'payment_status' => Booking::STATUS_FAILED,
            ]);

            return redirect()->route('student.dashboard')->with('error', 'Payment failed: ' . $request->input('pp_ResponseMessage'));
        }
    }

    /**
     * Mock payment success for testing since real JazzCash requires a live environment
     */
    public function mockSuccess($id)
    {
        if (!$this->jazzCashService->isMockMode()) {
            abort(403);
        }

        $booking = Booking::findOrFail($id);
        
        $booking->update([
            'payment_status' => Booking::STATUS_PAID,
            'payment_method' => 'JazzCash (Mock)',
            'transaction_id' => 'MOCK' . strtoupper(uniqid()),
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Mock payment successful! Session status updated.');
    }
}
