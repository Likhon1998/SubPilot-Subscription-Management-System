<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\CheckoutCustomer;
use App\Models\Item;
use App\Models\Subscription;

class SslCommerzPaymentController extends Controller
{
    // --------------------------
    // STEP 1: Redirect to SSLCommerz
    // --------------------------
    public function payNow(Request $request)
    {
        try {
            $customer_id = $request->input('customer_id');
            $item_ids = $request->input('item_ids', []);
            $duration = (int) $request->input('duration', 1);

            if (!$customer_id || empty($item_ids)) {
                return back()->with('error', 'Customer or items not found.');
            }

            $customer = CheckoutCustomer::find($customer_id);
            $items = Item::whereIn('id', $item_ids)->get();

            if (!$customer || $items->isEmpty()) {
                return back()->with('error', 'Invalid customer or items.');
            }

            $total = $items->sum('price') * $duration;
            $tran_id = uniqid('TXN_');

            // Store temporary transaction for tracking
            DB::table('temp_transactions')->insert([
                'tran_id' => $tran_id,
                'customer_id' => $customer->id,
                'item_ids' => json_encode($item_ids),
                'duration' => $duration,
                'total_amount' => $total,
                'created_at' => now(),
            ]);

            // Prepare SSLCommerz data
            $post_data = [
                'store_id' => env('SSLCZ_STORE_ID'),
                'store_passwd' => env('SSLCZ_STORE_PASSWORD'),
                'total_amount' => $total,
                'currency' => 'BDT',
                'tran_id' => $tran_id,
                'success_url' => route('ssl.success'),
                'fail_url' => route('ssl.fail'),
                'cancel_url' => route('ssl.cancel'),

                'cus_name' => $customer->name,
                'cus_email' => $customer->email,
                'cus_add1' => 'Dhaka',
                'cus_city' => 'Dhaka',
                'cus_country' => 'Bangladesh',
                'cus_phone' => $customer->phone,

                'shipping_method' => 'NO',
                'product_name' => $items->pluck('name')->join(', '),
                'product_category' => 'Service',
                'product_profile' => 'general',
            ];

            $sslcz_mode = env('SSLCZ_MODE', 'sandbox');
            $sslcz_url = $sslcz_mode === 'live'
                ? env('SSLCZ_LIVE_URL') . '/gwprocess/v4/api.php'
                : env('SSLCZ_SANDBOX_URL') . '/gwprocess/v4/api.php';

            $response = Http::asForm()->post($sslcz_url, $post_data);

            if ($response->successful()) {
                $result = $response->json();
                if (!empty($result['GatewayPageURL'])) {
                    return redirect()->away($result['GatewayPageURL']);
                } else {
                    Log::error('SSLCommerz GatewayPageURL missing', ['response' => $result]);
                    return back()->with('error', 'Failed to connect to SSLCommerz.');
                }
            } else {
                Log::error('SSLCommerz API connection failed', ['body' => $response->body()]);
                return back()->with('error', 'SSLCommerz API connection failed.');
            }
        } catch (\Exception $e) {
            Log::error('SSLCommerz PayNow Exception', ['message' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong while initiating payment.');
        }
    }

    // --------------------------
    // STEP 2: Payment Success
    // --------------------------
    public function success(Request $request)
    {
        Log::info('SSL Success Callback', $request->all());

        $tran_id = $request->input('tran_id') ?? $request->query('tran_id');

        $transaction = DB::table('temp_transactions')->where('tran_id', $tran_id)->first();

        if (!$transaction) {
            return view('frontend.payment_fail')->with('error', 'Transaction not found.');
        }

        $itemIds = json_decode($transaction->item_ids, true);
        $items = Item::whereIn('id', $itemIds)->get()->keyBy('id');

        if ($items->isEmpty()) {
            return view('frontend.payment_fail')->with('error', 'No valid items found.');
        }

        $sumPrices = $items->sum('price');

        foreach ($itemIds as $itemId) {
            $item = $items->get($itemId);
            if (!$item) continue;

            $proportionalAmount = round(($item->price / $sumPrices) * $transaction->total_amount, 2);

            Subscription::create([
                'checkout_customer_id' => $transaction->customer_id,
                'item_id' => $item->id,
                'duration' => $transaction->duration,
                'total_amount' => $proportionalAmount,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths($transaction->duration),
                'active' => true,
            ]);
        }

        CheckoutCustomer::where('id', $transaction->customer_id)->update([
            'checkout_completed' => true,
        ]);

        DB::table('temp_transactions')->where('tran_id', $tran_id)->delete();

        return view('frontend.payment_success');
    }

    public function fail(Request $request)
    {
        Log::warning('Payment Failed', $request->all());
        return view('frontend.payment_fail');
    }

    public function cancel(Request $request)
    {
        Log::notice('Payment Canceled', $request->all());
        return view('frontend.payment_cancel');
    }
}
