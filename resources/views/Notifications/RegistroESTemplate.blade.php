@component('mail::message')
    # {{ $subject }}:{{ $body['id'] }}

    |----------Usuario:----------|
    {{ $body['user'] }}


    |----------ENTRADA:----------|
    ->:{{ $body['start_time'] }}

    |----------SALIDA:-----------|
    ->:{{ $body['end_time'] }}

    |----------ALMUERZO:---------|
    ->:{{ $body['lunch_start_time'] }}

    |------SALIDA ALMUERZO:------|
    ->:{{ $body['lunch_end_time'] }}

    |----------SUMARY:-----------|
    ***Duracion de Almuerzo***:**
    ->:{{ $body['lunchDuration'] }}
    ***Duracion de Trabajo***:**
    ->:{{ $body['workDuration'] }}


    |------------STOCK:----------|
    {{ $body['stock'] }}
@endcomponent
