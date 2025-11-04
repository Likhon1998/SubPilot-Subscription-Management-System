<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Item;
use App\Models\CheckoutCustomer;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckoutController extends Controller
{
     public function index()
    {
        $customers = CheckoutCustomer::with('subscriptions.item')->orderBy('created_at', 'desc')->get();

        return view('admin.checkouts.index', compact('customers'));
    }
    public function showCheckoutForm(Product $product)
    {
        return view('frontend.checkout.customer_info', compact('product'));
    }

    /**
     * Step 2: Submit customer info & generate OTP
     */
    public function submitCustomerInfo(Request $request)
    {
        // Accept items as JSON string or array; validate general shape first
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'product_id' => 'required|exists:products,id',
            'items' => 'required', // can be json string or array; decode below
            'duration' => 'required|integer|min:1',
        ]);

        // Decode items if necessary
        $itemsInput = $request->input('items');

        if (is_string($itemsInput)) {
            $decoded = json_decode($itemsInput, true);
            if (!is_array($decoded)) {
                return back()->withErrors(['items' => 'Invalid items data'])->withInput();
            }
            $items = $decoded;
        } elseif (is_array($itemsInput)) {
            $items = $itemsInput;
        } else {
            return back()->withErrors(['items' => 'Invalid items data'])->withInput();
        }

        if (count($items) < 1) {
            return back()->withErrors(['items' => 'Please select at least one item'])->withInput();
        }

        // Ensure item ids are integers
        $itemIds = array_map('intval', $items);

        // Generate OTP
        $otp = random_int(100000, 999999);

        // Create or update checkout customer by email
        $customer = CheckoutCustomer::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'otp' => $otp,
                'otp_verified' => false,
                'otp_expires_at' => Carbon::now()->addMinutes(10),
                'checkout_completed' => false,
            ]
        );

        // Save checkout data in session
        session([
            'checkout_items' => $itemIds,
            'checkout_duration' => (int) $request->duration,
            'checkout_product_id' => (int) $request->product_id,
        ]);

        // Try to send OTP via mail. With MAIL_MAILER=log this will be logged.
        $mailSent = false;
        try {
            Mail::raw("Your SubPilot OTP is: {$otp}\nThis OTP expires in 10 minutes.", function ($message) use ($customer) {
                $message->to($customer->email)->subject('SubPilot OTP Verification');
            });
            $mailSent = true;
            Log::info("OTP email queued/logged for {$customer->email}");
        } catch (\Throwable $e) {
            // Mail failed — don't break the flow
            Log::warning("OTP mail failed for {$customer->email}: " . $e->getMessage());
        }

        // For local/dev convenience store OTP in session (REMOVE in production)
        session(['test_otp' => $otp, 'test_otp_mail_sent' => $mailSent]);

        $flash = $mailSent
            ? 'OTP has been sent to your email.'
            : 'OTP generated (mail not sent). Check storage/logs/laravel.log or use test OTP.';

        // Pass OTP in flash only for local/dev; remove in production
        return redirect()->route('checkout.otp.form', $customer->id)
            ->with('success', $flash . ' (test OTP: '.$otp.')');
    }

    /**
     * Step 3: Show OTP verification form
     */
    public function showOtpForm(CheckoutCustomer $customer)
    {
        return view('frontend.checkout.otp_verify', compact('customer'));
    }

    /**
     * Step 4: Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:checkout_customers,id',
            'otp' => 'required|digits:6',
        ]);

        $customer = CheckoutCustomer::findOrFail($request->customer_id);

        // Already verified -> go to payment
        if ($customer->otp_verified) {
            return redirect()->route('checkout.payment', $customer->id);
        }

        // Check OTP correctness and expiry
        if ($customer->otp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP'])->withInput();
        }

        if (Carbon::now()->gt($customer->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP expired. Please request a new one.'])->withInput();
        }

        $customer->update(['otp_verified' => true]);

        return redirect()->route('checkout.payment', $customer->id);
    }

    /**
     * Step 5: Show payment page
     */
    public function showPayment(CheckoutCustomer $customer)
    {
        // Ensure OTP verification
        if (!$customer->otp_verified) {
            return redirect()->route('checkout.otp.form', $customer->id)
                ->withErrors(['otp' => 'Please verify OTP before payment.']);
        }

        // Load items from session
        $itemIds = session('checkout_items', []);
        if (empty($itemIds)) {
            return redirect()->route('frontend.home')->withErrors(['checkout' => 'No items found in checkout.']);
        }

        $items = Item::whereIn('id', $itemIds)->get();
        $duration = session('checkout_duration', 1);
        $total = $items->sum('price') * (int)$duration;

        return view('frontend.checkout.payment', compact('customer', 'items', 'duration', 'total'));
    }

   
}
