<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderNotification;
use App\Services\InvoiceService;

class OrderController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }
    public function index(Request $request)
    {
        $product = $request->input('product');
        $sku = $request->input('sku');
        $qty = $request->input('qty');

        return view('order.index', compact('product', 'sku', 'qty'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product' => 'required|string',
            'sku' => 'nullable|string',
            'qty' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'message' => 'nullable|string',
            'create_account' => 'boolean',
            'password' => 'required_if:create_account,1|nullable|string|min:8|confirmed',
            'accept_terms' => 'required|accepted',
        ]);

        $user_id = auth()->id();

        // Optional registration
        if (!$user_id && $request->create_account) {
            $user = \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            ]);
            auth()->login($user);
            $user_id = $user->id;
        }

        // Save Order to Database
        $product = \App\Models\Product::where('sku', $validated['sku'])->first();
        $productPrice = $product ? $product->price_ttc : 0;
        $productImage = $product ? $product->media()->where('is_primary', true)->first()?->path : null;

        $order = Order::create([
            'user_id' => $user_id,
            'product_name' => $validated['product'],
            'product_price' => $productPrice,
            'product_image' => $productImage,
            'sku' => $validated['sku'],
            'quantity' => $validated['qty'],
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'customer_phone' => $validated['phone'],
            'customer_address' => $validated['address'],
            'message' => $validated['message'],
        ]);

        $company_info = \App\Models\CompanyInfo::first();
        $adminEmail = $company_info?->email_contact ?? config('mail.from.address');

        // Generate PDF Invoice
        $pdfData = null;
        /*
        try {
            $pdfData = $this->invoiceService->generateInvoice($order);
        } catch (\Exception $e) {
            \Log::error('PDF generation failed: ' . $e->getMessage());
        }
        */

        // Send Emails with try-catch to avoid 500 error if mail server is unreachable
        try {
            // Send Email to Admin (In FR as requested)
            Mail::to($adminEmail)->send(new OrderNotification($order, true, $pdfData));

            // Send Email to Client (In DE as requested)
            Mail::to($validated['email'])->send(new OrderNotification($order, false, $pdfData));
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            // We continue even if mail fails, so the user sees the thanks page
        }

        return redirect()->route('order.thanks', ['order' => $order->id]);
    }

    public function thanks($locale, Order $order)
    {
        $company_info = \App\Models\CompanyInfo::first();
        // Check if the order was just created in this session to ensure security
        // or just let the model binding handle it if it's public enough
        return view('order.thanks', compact('order', 'company_info'));
    }

    public function userOrders(Request $request)
    {
        $orders = auth()->user()->orders()->latest('id')->paginate(10);
        return view('orders.user', compact('orders'));
    }
}
