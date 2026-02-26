<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index($locale)
    {
        $settings = CompanyInfo::first() ?? new CompanyInfo();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request, $locale)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email_contact' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:30',
            'adresse_siege' => 'nullable|string',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'opening_hours' => 'nullable|string',
            'logo_path' => 'nullable|string',
            'iban' => 'nullable|string|max:34',
            'bic' => 'nullable|string|max:11',
            'bank_name' => 'nullable|string|max:255',
            'bank_address' => 'nullable|string',
            'show_rib_on_order' => 'nullable|boolean',
            'payment_instructions_de' => 'nullable|string',
            'payment_instructions_fr' => 'nullable|string',
            'siren' => 'nullable|string|max:20',
            'siret' => 'nullable|string|max:20',
            'numero_tva' => 'nullable|string|max:30',
            'date_creation' => 'nullable|date',
            'activite_naf_ape' => 'nullable|string|max:20',
            'forme_juridique' => 'nullable|string|max:100',
            'rcs_ville' => 'nullable|string|max:100',
            'capital_social' => 'nullable|numeric|min:0',
            'dirigeants' => 'nullable|string',
        ]);

        $validated['show_rib_on_order'] = $request->has('show_rib_on_order');
        
        // Convert dirigeants string to array if provided
        if ($request->has('dirigeants') && is_string($request->dirigeants)) {
            $input = $request->dirigeants;
            // Check if input is JSON (from previous manual error or special input)
            if (str_starts_with(trim($input), '[') || str_starts_with(trim($input), '{')) {
                $decoded = json_decode($input, true);
                if (is_array($decoded)) {
                    $validated['dirigeants'] = $decoded;
                } else {
                    $validated['dirigeants'] = array_filter(array_map('trim', explode(',', $input)));
                }
            } else {
                $validated['dirigeants'] = array_filter(array_map('trim', explode(',', $input)));
            }
        } else {
            $validated['dirigeants'] = null;
        }

        $settings = CompanyInfo::first();
        if ($settings) {
            $settings->update($validated);
        } else {
            CompanyInfo::create($validated);
        }

        return back()->with('success', 'Paramètres mis à jour.');
    }
}
