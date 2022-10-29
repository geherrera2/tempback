@component('mail::message')
# Hola

Estás recibiendo este email porque se ha solicitado un cambio de contraseña para tu cuenta.

@component('mail::button', ['url' => $route])
Restablecer contraseña
@endcomponent

Este enlace para restrablecer la contraseña caduca en 60 minutos.

Si no has solicitado un cambio de contraseña, puedes ingnorar o eliminar este correo.

Gracias,<br>
{{ config('app.name') }}
@endcomponent
