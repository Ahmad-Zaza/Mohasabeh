<?php

namespace App\Http\Controllers;

use App\Http\Models\Customer;
use App\Payments;
use App\PricePkg;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PDO;
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
        $this->updateSubscriptionDate();

        return $response;
    }

    protected function createPayment(float $price, $payment_id)
    {
        return Payments::create([
            'customer_id' => Auth::user()->id,
            'payment_id' => $payment_id,
            'init_amount' => $price,
            'currency' => 'USD',
            'status' => 'pending',
            'created_at' => Carbon::now(),
        ]);
    }

    protected function updatePayment($token, $response)
    {
        $payment = Payments::where('payment_id', $token)->first();
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $payment->status = 'success';
            $payment->payer_id = $response['payer']['payer_id'];
            $payment->payer_email = $response['payer']['email_address'];
            $payment->payer_name = $response['payer']['name']['given_name'];
            $payment->payer_surname = $response['payer']['name']['surname'];
            $payment->gross_amount = $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['value'];
            $payment->fee = $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'];
            $payment->net_amount = $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'];
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
        }
        $payment->save();
        return $payment;
    }

    protected function updateSubscriptionDate()
    {
        $months = $this->getSubscriptionTypeMonths();
        $pkg_id = Session::get('pkgg_id');
        $package = PricePkg::where('id', $pkg_id)->first();
        $customer = Customer::where('id', Auth::user()->id)->first();
        $subscription_start_date = $customer->subscription_start_date ?: Carbon::now();
        $subscription_end_date = $customer->subscription_end_date ? $customer->subscription_end_date->addMonths($months) : Carbon::now()->addMonths($months);
        $customer->update([
            'package_id' => $pkg_id,
            'is_free_trial' => 0,
            'subscription_start_date' => $subscription_start_date,
            'last_renewal_date' => Carbon::now(),
            'subscription_end_date' => $subscription_end_date,
            'subscription_type' => Session::get('sub_type'),
            'users_count' => $package->users_count,
            'currencies_count' => $package->currencies_count,
            'warehouses_count' => $package->warehouses_count,
        ]);
        ## customer DB
        $customerDB = "{$customer->database_name}";
        $customerDBHost = "localhost";
        $customerDBUser = "{$customer->database_name}";
        $customerDBPassword = "{$customer->database_password}";
        try {
            $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", $customerDBUser, $customerDBPassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            // $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", "root", null, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $query = "update `package_config` SET `package_id` = '$pkg_id', `users_num` = '$package->users_count', `inventories_num` = '$package->warehouses_count',
                        `currencies_num` = '$package->currencies_count', `backups_size` = '$package->backups_size', `attachs_size` =  '$package->attached_size',
                        `subscription_start_date` = '$subscription_start_date', `subscription_end_date` = '$subscription_end_date'";
            $dbh->exec($query);
        } catch (Exception $ex) {
            Log::error(__('data.unable_to_make_the_connection') . $ex->getMessage());
        }
    }

    protected function getSubscriptionTypeMonths()
    {
        $subscription_type = Session::get('sub_type');
        if (isset($subscription_type)) {
            if ($subscription_type == 'month') {
                return 1;
            } else if ($subscription_type == 'year') {
                return 12;
            } else {
                return 6;
            }
        }
        return 0;
    }

}
