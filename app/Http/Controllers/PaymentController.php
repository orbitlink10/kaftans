<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function initiate(Request $request, Booking $booking)
    {
        abort_unless($booking->customer_id === auth()->id() || auth()->user()->isRole(['admin', 'dispatcher']), 403);

        $data = $request->validate([
            'phone_number' => ['required', 'string', 'max:20'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'customer_id' => $booking->customer_id,
            'phone_number' => $this->normalizePhone($data['phone_number']),
            'amount' => $data['amount'],
            'status' => 'pending',
        ]);

        if (! config('services.mpesa.consumer_key')) {
            return back()->with('success', 'Payment recorded as pending. Add Daraja credentials in .env to send STK Push.');
        }

        $token = $this->accessToken();
        $timestamp = now()->format('YmdHis');
        $shortCode = config('services.mpesa.shortcode');
        $password = base64_encode($shortCode.config('services.mpesa.passkey').$timestamp);

        $response = Http::withToken($token)->post(config('services.mpesa.base_url').'/mpesa/stkpush/v1/processrequest', [
            'BusinessShortCode' => $shortCode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => config('services.mpesa.transaction_type', 'CustomerPayBillOnline'),
            'Amount' => (int) $payment->amount,
            'PartyA' => $payment->phone_number,
            'PartyB' => $shortCode,
            'PhoneNumber' => $payment->phone_number,
            'CallBackURL' => route('mpesa.callback'),
            'AccountReference' => $booking->booking_number,
            'TransactionDesc' => 'Lasafi booking payment',
        ])->json();

        $payment->update([
            'checkout_request_id' => $response['CheckoutRequestID'] ?? null,
            'merchant_request_id' => $response['MerchantRequestID'] ?? null,
            'callback_response' => $response,
            'status' => isset($response['ResponseCode']) && $response['ResponseCode'] === '0' ? 'pending' : 'failed',
        ]);

        return back()->with('success', 'M-Pesa STK Push initiated.');
    }

    public function callback(Request $request)
    {
        $payload = $request->all();
        $stk = data_get($payload, 'Body.stkCallback', []);
        $checkoutId = $stk['CheckoutRequestID'] ?? null;
        $payment = Payment::where('checkout_request_id', $checkoutId)->first();

        if ($payment) {
            $items = collect(data_get($stk, 'CallbackMetadata.Item', []))->pluck('Value', 'Name');
            $payment->update([
                'status' => (int) ($stk['ResultCode'] ?? 1) === 0 ? 'paid' : 'failed',
                'mpesa_receipt_number' => $items->get('MpesaReceiptNumber'),
                'callback_response' => $payload,
            ]);
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }

    private function accessToken(): string
    {
        $response = Http::withBasicAuth(config('services.mpesa.consumer_key'), config('services.mpesa.consumer_secret'))
            ->get(config('services.mpesa.base_url').'/oauth/v1/generate', ['grant_type' => 'client_credentials'])
            ->throw()
            ->json();

        return $response['access_token'];
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone);

        if (Str::startsWith($phone, '0')) {
            return '254'.substr($phone, 1);
        }

        if (Str::startsWith($phone, '7') || Str::startsWith($phone, '1')) {
            return '254'.$phone;
        }

        return $phone;
    }
}
