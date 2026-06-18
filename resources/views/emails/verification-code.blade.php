@component('mail::message')
# Bienvenue sur Le Rouleau Gris, {{ $userName }} !

Merci de rejoindre notre archive de pensées et de connaissances.

Voici votre code de confirmation :

@component('mail::panel')
# {{ $code }}
@endcomponent

Ce code est valable **15 minutes**.

@component('mail::button', ['url' => config('app.url').'/verify-email'])
Vérifier mon compte
@endcomponent

*Si vous n'avez pas créé de compte, ignorez cet email.*

— **Le Rouleau Gris**
@endcomponent