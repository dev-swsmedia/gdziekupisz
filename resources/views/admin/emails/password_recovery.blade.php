@component('mail::message')
Witaj,

otrzymujesz tę wiadomość, ponieważ wygenerowałeś żądanie odzyskania hasła. Kliknij w poniższy przycisk, by utworzyć nowe hasło do Twojego konta w serwisie.

@component('mail::button', ['url' => $url])
ODZYSKAJ HASŁO
@endcomponent

Jeżeli powyższy przycisk nie działa, możesz także wpisać w przeglądarkę następujący adres: {{ $url }}

Pozdrawiamy,<br>
PrenumerataSWS
@endcomponent
