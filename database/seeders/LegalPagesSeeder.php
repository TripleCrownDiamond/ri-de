<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalPage;
use Illuminate\Support\Facades\Schema;

class LegalPagesSeeder extends Seeder
{
    public function run()
    {
        if (Schema::hasTable('legal_pages')) {
            $pages = [
                [
                    'title' => 'Allgemeine Geschäftsbedingungen (AGB)',
                    'slug' => 'agb',
                    'content' => '<h2>1. Geltungsbereich</h2><p>Diese AGB gelten für alle Bestellungen bei [NOM_SITE].</p><h2>2. Vertragspartner</h2><p>Der Kaufvertrag kommt zustande mit [NOM_SITE], [ADRESSE_SIEGE].</p><h2>3. Preise und Zahlung</h2><p>Alle Preise verstehen sich inklusive MwSt. ([NUMERO_TVA]). Wir akzeptieren Banküberweisung auf unser Konto: [BANK_NAME], IBAN: [IBAN], BIC: [BIC].</p>',
                    'is_active' => 1
                ],
                [
                    'title' => 'Datenschutzerklärung',
                    'slug' => 'datenschutz',
                    'content' => '<h2>1. Datenschutz auf einen Blick</h2><p>Wir nehmen den Schutz Ihrer Daten sehr ernst. Verantwortlich ist [NOM_SITE], [ADRESSE_SIEGE], E-Mail: [EMAIL_CONTACT].</p>',
                    'is_active' => 1
                ],
                [
                    'title' => 'Widerrufsbelehrung & Retouren',
                    'slug' => 'widerruf-retouren',
                    'content' => '<h2>Widerrufsrecht</h2><p>Sie haben das Recht, binnen vierzehn Tagen ohne Angabe von Gründen diesen Vertrag zu widerrufen.</p><p>Die Rücksendung erfolgt an: [ADRESSE_SIEGE].</p>',
                    'is_active' => 1
                ],
                [
                    'title' => 'Versandinformationen',
                    'slug' => 'versand',
                    'content' => '<h2>Lieferung</h2><p>Die Lieferung erfolgt innerhalb Deutschlands und nach Österreich. <strong>Innerhalb Deutschlands liefern wir versandkostenfrei (auf unsere Kosten)</strong>.</p><h2>Lieferzeit</h2><p>Die Lieferzeit in Deutschland beträgt <strong>7 bis 15 Werktage</strong>.</p>',
                    'is_active' => 1
                ],
                [
                    'title' => 'Garantiebedingungen',
                    'slug' => 'garantie',
                    'content' => '<h2>Gesetzliche Mängelhaftung</h2><p>Es gilt die gesetzliche Mängelhaftung für alle Produkte von [NOM_SITE].</p>',
                    'is_active' => 1
                ]
            ];

            foreach ($pages as $p) {
                LegalPage::updateOrCreate(['slug' => $p['slug']], $p);
            }
        }
    }
}
