<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $company_info = CompanyInfo::first();
        return view('contact.index', compact('company_info'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $adminEmail = CompanyInfo::first()?->email_contact ?? config('mail.from.address');
        
        try {
            // Admin notification (FR)
            Mail::to($adminEmail)->send(new ContactMessage($validated, true));
            
            // Client confirmation (DE)
            Mail::to($validated['email'])->send(new ContactMessage($validated, false));
        } catch (\Exception $e) {
            \Log::error('Contact mail sending failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
}
