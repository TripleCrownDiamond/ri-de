<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    protected $table = 'company_infos';

    protected $fillable = [
        'nom',
        'siren',
        'siret',
        'numero_tva',
        'date_creation',
        'activite_naf_ape',
        'forme_juridique',
        'adresse_siege',
        'dirigeants',
        'telephone',
        'email_contact',
        'rcs_ville',
        'capital_social',
        'facebook',
        'instagram',
        'opening_hours',
        'logo_path',
        'iban',
        'bic',
        'bank_name',
        'bank_address',
        'show_rib_on_order',
        'payment_instructions_de',
        'payment_instructions_fr',
    ];

    protected $casts = [
        'date_creation' => 'date',
        'dirigeants' => 'array',
        'capital_social' => 'decimal:2',
        'show_rib_on_order' => 'boolean',
    ];
}

