<x-mail::message>
@if($isAdmin)
# Nouvelle commande reçue

Une nouvelle commande a été passée sur le site.

**Détails de la commande :**
- **Produit :** {{ $order->product_name }}
- **SKU :** {{ $order->sku ?? 'N/A' }}
- **Prix :** {{ number_format($order->product_price, 2, ',', '.') }} €
- **Quantité :** {{ $order->quantity }}
- **Total :** {{ number_format($order->product_price * $order->quantity, 2, ',', '.') }} €

@if($order->product_image)
![{{ $order->product_name }}]({{ $order->product_image }})
@endif

**Informations client :**
- **Nom :** {{ $order->customer_name }}
- **Email :** {{ $order->customer_email }}
- **Téléphone :** {{ $order->customer_phone ?? 'Non renseigné' }}
- **Adresse :** {{ $order->customer_address ?? 'Non renseignée' }}

**Message du client :**
{{ $order->message ?? 'Aucun message.' }}

<x-mail::button :url="config('app.url') . '/admin/orders'">
Gérer les commandes
</x-mail::button>

@else
# Vielen Dank für Ihre Bestellung!

Hallo {{ $order->customer_name }},

Ihre Bestellung wurde erfolgreich an uns übermittelt. Hier ist eine Zusammenfassung Ihrer Bestellung:

**Bestelldetails:**
- **Produkt:** {{ $order->product_name }}
- **Artikelnummer (SKU):** {{ $order->sku ?? 'N/A' }}
- **Preis:** {{ number_format($order->product_price, 2, ',', '.') }} €
- **Menge:** {{ $order->quantity }}
- **Gesamt:** {{ number_format($order->product_price * $order->quantity, 2, ',', '.') }} €

@if($order->product_image)
![{{ $order->product_name }}]({{ $order->product_image }})
@endif

@if($company_info)
@php
    $instructions = $isAdmin ? $company_info->payment_instructions_fr : $company_info->payment_instructions_de;
    $hasRib = $company_info->show_rib_on_order && ($company_info->iban || $company_info->bic || $company_info->bank_name);
@endphp

@if($instructions || $hasRib)
<x-mail::panel>
### {{ $isAdmin ? 'Instructions de paiement' : 'Zahlungsinformationen' }}

@if($instructions)
<div style="margin-bottom: 15px;">
{!! $instructions !!}
</div>
@endif

@if($hasRib)
@if($company_info->bank_name)
**{{ $isAdmin ? 'Banque' : 'Bank' }}:** {{ $company_info->bank_name }}  
@endif
@if($company_info->iban)
**IBAN:** {{ $company_info->iban }}  
@endif
@if($company_info->bic)
**BIC:** {{ $company_info->bic }}  
@endif
@endif

<small>* {{ $isAdmin ? 'La commande sera traitée après réception du paiement.' : 'Ihre Bestellung wird bearbeitet, sobald wir Ihre Zahlung erhalten haben.' }}</small>
</x-mail::panel>
@endif
@endif

Wir werden uns in Kürze mit Ihnen in Verbindung setzen, um die weiteren Schritte zu besprechen.

@endif

Merci / Vielen Dank,<br>
{{ config('app.name') }}
</x-mail::message>
