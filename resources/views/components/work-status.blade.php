@if ($work->partner)
<div class="col-auto">
    <a wire:click.prevent="changeStatus({{$work->id}}, 'outsourced')" 
       class="@if($work->outsourced) text-success @else text-danger @endif">
        <i class="bi bi-fast-forward"></i>
    </a>
</div>
@endif

@foreach (['design' => 'bi-layers-half', 'ready' => 'bi-check2-all', 'delivered' => 'bi-box-arrow-right', 'paid' => 'bi-currency-euro'] as $status => $icon)
<div class="col-auto">
    <a wire:click.prevent="changeStatus({{$work->id}}, '{{ $status }}')" 
       class="@if($work->$status) text-success @else text-danger @endif">
        <i class="bi {{ $icon }}"></i>
    </a>
</div>
@endforeach
