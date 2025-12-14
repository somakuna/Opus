@php
    $colors = [
        'Walk in' => 'secondary',
        'E-mail' => 'primary',
        'WhatsApp' => 'success',
        'Signal' => 'primary'
    ];
@endphp

<span class="badge text-bg-{{ $colors[$work->source] ?? 'secondary' }}">{{ $work->source }}</span>
<span class="badge text-bg-dark">{{ $work->payment_method }} {{ $work->price }} €</span>
