@if ($work->partner)
<a wire:click.prevent="changeStatus({{$work->id}}, 'outsourced')"
   class="action-btn @if($work->outsourced) status-on @else status-off @endif"
   title="Outsourced">
    <i class="bi bi-fast-forward"></i>
</a>
@endif

@foreach (['design' => 'bi-layers-half', 'ready' => 'bi-check2-all', 'delivered' => 'bi-box-arrow-right', 'paid' => 'bi-currency-euro'] as $status => $icon)
<a wire:click.prevent="changeStatus({{$work->id}}, '{{ $status }}')"
   class="action-btn @if($work->$status) status-on @else status-off @endif"
   title="{{ ucfirst($status) }}">
    <i class="bi {{ $icon }}"></i>
</a>
@endforeach
