<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use Illuminate\Http\Request;

class LegalPageController extends Controller
{
    public function show(string $locale, LegalPage $legalPage)
    {
        if (!$legalPage->is_active) {
            abort(404);
        }

        // Remplacement dynamique des variables dans le contenu
        $company = \App\Models\CompanyInfo::first();
        if ($company) {
            $replacements = [
                '[NOM_SITE]' => $company->nom,
                '[EMAIL_CONTACT]' => $company->email_contact,
                '[TELEPHONE]' => $company->telephone,
                '[ADRESSE_SIEGE]' => $company->adresse_siege,
                '[SIREN]' => $company->siren,
                '[SIRET]' => $company->siret,
                '[NUMERO_TVA]' => $company->numero_tva,
                '[FORME_JURIDIQUE]' => $company->forme_juridique,
                '[CAPITAL_SOCIAL]' => number_format($company->capital_social, 2, ',', ' ') . ' €',
                '[RCS_VILLE]' => $company->rcs_ville,
                '[IBAN]' => $company->iban,
                '[BIC]' => $company->bic,
                '[BANK_NAME]' => $company->bank_name,
                '[BANK_ADDRESS]' => $company->bank_address,
                '[OPENING_HOURS]' => $company->opening_hours,
                '[DATE_CREATION]' => $company->date_creation?->format('d/m/Y'),
                '[NAF_APE]' => $company->activite_naf_ape,
                '[DIRIGEANTS]' => is_array($company->dirigeants) ? implode(', ', array_map(function($d) {
                    if (is_array($d)) {
                        $parts = [];
                        if (!empty($d['prenom'])) $parts[] = $d['prenom'];
                        if (!empty($d['nom'])) $parts[] = $d['nom'];
                        $name = implode(' ', $parts);
                        if (!empty($d['fonction'])) return $name . " (" . $d['fonction'] . ")";
                        return $name;
                    }
                    return (string)$d;
                }, $company->dirigeants)) : '',
            ];

            $legalPage->content = str_replace(
                array_keys($replacements),
                array_values($replacements),
                $legalPage->content
            );
        }

        return view('legal.show', compact('legalPage'));
    }
}
