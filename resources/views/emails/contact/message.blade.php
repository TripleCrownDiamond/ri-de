<x-mail::message>
@if($isAdmin)
# Nouveau message de contact

Vous avez reçu un nouveau message via le formulaire de contact.

**Détails de l'expéditeur :**
- **Nom :** {{ $data['first_name'] }} {{ $data['last_name'] }}
- **Email :** {{ $data['email'] }}

**Message :**
{{ $data['message'] }}

<x-mail::button :url="config('app.url') . '/admin'">
Accéder au tableau de bord
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
@else
# Vielen Dank für Ihre Nachricht!

Hallo {{ $data['first_name'] }} {{ $data['last_name'] }},

wir haben Ihre Nachricht erhalten und werden uns so schnell wie möglich bei Ihnen melden.

**Ihre Nachricht:**
{{ $data['message'] }}

Vielen Dank,<br>
{{ config('app.name') }}
@endif
</x-mail::message>
