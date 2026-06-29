<?php

namespace App\Services;

use Carbon\Carbon;

class JazzCashService
{
    protected $merchantId;
    protected $password;
    protected $integritySalt;
    protected $returnUrl;
    protected $apiUrl;
    protected $isMock;

    public function __construct()
    {
        $this->merchantId = env('JAZZCASH_MERCHANT_ID', 'MOCK_MERCHANT');
        $this->password = env('JAZZCASH_PASSWORD', 'MOCK_PASS');
        $this->integritySalt = env('JAZZCASH_INTEGRITY_SALT', 'MOCK_SALT');
        $this->returnUrl = route('payment.jazzcash.callback');
        $this->isMock = env('JAZZCASH_MOCK', true);
        
        $this->apiUrl = $this->isMock 
            ? 'https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantpay/' 
            : 'https://payments.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantpay/';
    }

    public function preparePaymentData($booking)
    {
        $amount = $booking->price_at_booking * 100; // Amount in paisas
        $txnRefNo = 'TXN' . Carbon::now()->format('YmdHis') . $booking->id;
        $expiryDate = Carbon::now()->addHours(1)->format('YmdHis');
        
        $postData = [
            'pp_Version' => '1.1',
            'pp_TxnType' => 'MWALLET',
            'pp_Language' => 'EN',
            'pp_MerchantID' => $this->merchantId,
            'pp_SubMerchantID' => '',
            'pp_Password' => $this->password,
            'pp_BankID' => 'TBANK',
            'pp_ProductID' => 'REPK',
            'pp_TxnRefNo' => $txnRefNo,
            'pp_Amount' => $amount,
            'pp_TxnCurrency' => 'PKR',
            'pp_TxnDateTime' => Carbon::now()->format('YmdHis'),
            'pp_BillReference' => 'BILL' . $booking->id,
            'pp_Description' => 'TutorHub Session Payment for Booking #' . $booking->id,
            'pp_TxnExpiryDateTime' => $expiryDate,
            'pp_ReturnURL' => $this->returnUrl,
            'pp_SecureHash' => '',
            'ppmpf_1' => $booking->id, // Custom field 1 to store booking ID
        ];

        $postData['pp_SecureHash'] = $this->generateSecureHash($postData);

        return $postData;
    }

    protected function generateSecureHash($data)
    {
        ksort($data);
        $hashString = $this->integritySalt;
        foreach ($data as $key => $val) {
            if ($val != '' && $key != 'pp_SecureHash') {
                $hashString .= '&' . $val;
            }
        }
        return strtoupper(hash_hmac('sha256', $hashString, $integritySalt = $this->integritySalt));
    }

    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    public function isMockMode()
    {
        return $this->isMock;
    }
}
