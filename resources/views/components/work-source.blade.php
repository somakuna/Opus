@php
    $colors = [
        'Walk in' => 'secondary',
        'E-mail' => 'primary',
        'WhatsApp' => 'success',
        'Signal' => 'info'
    ];
@endphp

<span class="badge badge-source text-bg-{{ $colors[$work->source] ?? 'secondary' }}">{{ $work->source }}</span>
<span class="badge badge-price">{{ $work->payment_method }} {{ $work->price }} &euro;</span>
