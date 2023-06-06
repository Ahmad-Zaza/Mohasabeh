<?php

namespace App\Http\Controllers;

use App\Http\Models\Customer;
use App\Payments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function successPage()
    {
        return view('payment.success');
    }

    public function errorPage()
    {
        return view('payment.error');
    }

    public function createTransaction(Request $request)
    {
        $response = $this->initTransaction();
        return response()->json($response);
    }

    public function captureTransaction(string $id)
    {
        $response = $this->checkTransaction($id);
        return response()->json($response);
    }

    protected function initTransaction()
    {
        $price = session()->get('price');
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "shipping_preference" => 'NO_SHIPPING',
                "return_url" => route('success-transaction'),
                "cancel_url" => route('cancel-transaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => config('paypal.currency'),
                        "value" => $price,
                    ],
                ],
            ],
        ]);

        // Creating the payment record
        $payment = $this->createPayment($price, $response['id']);

        return $response;
    }

    protected function checkTransaction(string $id)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($id);

        $this->updatePayment($id, $response);
        // $this->updateSubscriptionDate();

        return $response;
    }

    protected function createPayment(float $price, $payment_id)
    {
        return Payments::create([
            'payer_id' => Auth::user()->id,
            'payment_id' => $payment_id,
            'amount' => $price,
            'currency' => 'USD',
            'status' => 'pending',
            'created_at' => Carbon::now(),
        ]);
    }

    protected function updatePayment($token, $response)
    {
        $payment = Payments::where('payment_id', $token)->first();

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $payment->update(['status' => 'success']);
        } else {
            $payment->status = 'error';
            $payment->error_name = $response['error']['name'];
            $payment->error_message = $response['error']['message'];
            $payment->debug_id = $response['error']['debug_id'];
            $details = "";
            foreach ($response['error']['details'] as $detail) {
                $details .= $detail['issue'] . ' -- ';
            }
            $payment->error_details = $details;
            $payment->save();
        }
    }

    protected function updateSubscriptionDate()
    {
        $customer = Customer::where('id', Auth::user()->id)->first();
        $customer->update([

        ]);
    }

}
