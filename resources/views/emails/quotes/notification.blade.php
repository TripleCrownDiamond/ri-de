<x-mail::message>
@if($isAdmin)
# Nouvelle demande de devis

Une nouvelle demande de devis a été soumise.

**Détails de la demande :**
- **Produit :** {{ $data['product'] }}
- **SKU :** {{ $data['sku'] ?? 'N/A' }}
- **Quantité :** {{ $data['qty'] }}
- **Nom du client :** {{ $data['name'] }}
- **Email :** {{ $data['email'] }}
- **Téléphone :** {{ $data['phone'] ?? 'Non renseigné' }}

**Message / Besoins spécifiques :**
{{ $data['message'] ?? 'Aucun message.' }}

<x-mail::button :url="config('app.url') . '/admin/products'">
Voir les produits
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
@else
# Bestätigung Ihrer Angebotsanfrage

Hallo {{ $data['name'] }},

vielen Dank für Ihre Anfrage. Wir haben Ihre Nachricht erhalten und werden Ihnen so schnell wie möglich ein passendes Angebot erstellen.

**Zusammenfassung Ihrer Anfrage:**
- **Produkt:** {{ $data['product'] }}
- **Menge:** {{ $data['qty'] }}

**Ihre Nachricht:**
{{ $data['message'] ?? 'Keine Nachricht hinterlassen.' }}

Wir freuen uns darauf, von Ihnen zu hören.

Vielen Dank,<br>
{{ config('app.name') }}
@endif
</x-mail::message>
