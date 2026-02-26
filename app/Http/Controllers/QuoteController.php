<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuoteNotification;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        return view('quote.index', [
            'product' => $request->input('product'),
            'sku' => $request->input('sku'),
            'qty' => $request->input('qty'),
        ]);
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
            'message' => 'nullable|string',
        ]);

        // Send Emails with try-catch
        try {
            // Send Email to Admin
            $adminEmail = CompanyInfo::first()?->email_contact ?? config('mail.from.address');
            Mail::to($adminEmail)->send(new QuoteNotification($validated, true));

            // Send Email to Client
            Mail::to($validated['email'])->send(new QuoteNotification($validated, false));
        } catch (\Exception $e) {
            \Log::error('Quote mail sending failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Votre demande de devis a été envoyée. Nous reviendrons vers vous avec une proposition.');
    }
}
