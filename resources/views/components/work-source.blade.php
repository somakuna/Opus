@php
    $sourceStyles = [
        'Walk in'  => ['icon' => 'bi-person', 'class' => 'badge-walk-in'],
        'E-mail'   => ['icon' => 'bi-envelope', 'class' => 'badge-email'],
        'WhatsApp' => ['icon' => 'bi-whatsapp', 'class' => 'badge-whatsapp'],
        'Signal'   => ['icon' => 'bi-signal', 'class' => 'badge-signal'],
    ];
    $source = $sourceStyles[$work->source] ?? ['icon' => 'bi-question-circle', 'class' => 'badge-walk-in'];
@endphp

<span class="source-badge {{ $source['class'] }}">
    <i class="bi {{ $source['icon'] }}"></i> {{ $work->source }}
</span>
<span class="price-badge">
    {{ $work->payment_method }} &middot; {{ $work->price }} &euro;
</span>
