@component('mail::message')
    # {{ $subject }}

    Se ha registrado una nueva entrada.

    - **Entrada**: {{ $body['user'] }}

    - **Hora de entrada**: {{ $body['start_time'] }}
    - **Hora de salida**: {{ $body['end_time'] }}
    - **Hora de inicio de almuerzo**: {{ $body['lunch_start_time'] }}
    - **Hora de fin de almuerzo**: {{ $body['lunch_end_time'] }}
    cuerpo de la notificación

    @component('mail::button', ['url' => $url])
        Ver entrada
    @endcomponent


    ¡Gracias por usar nuestra aplicación!
@endcomponent
