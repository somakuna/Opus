<div class="col-auto">
    <a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, false]) }}" target="_blank"
        class="@if($work->printed) text-body-emphasis @endif">
        <i class="bi bi-receipt"></i>
    </a>
</div>
<div class="col-auto">
    <a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, true]) }}" target="_blank"
        class="@if($work->printed) text-body-emphasis @endif">
        <i class="bi bi-printer"></i>
    </a>
</div>
<div class="col-auto"><a href="{{ route('work.edit', $work) }}"><i class="bi bi-pencil"></i></a></div>
<div class="col-auto"><a wire:click.prevent="delete({{$work->id}})"><i class="bi bi-recycle"></i></a></div>

@if($priority >= 0 && $priority < 3)
<div class="col-auto"><a wire:click.prevent="increasePriority({{$work->id}})"><i class="bi bi-caret-left"></i></a></div>
@endif
@if($priority <= 3 && $priority > 0)
<div class="col-auto"><a wire:click.prevent="decreasePriority({{$work->id}})"><i class="bi bi-caret-right"></i></a></div>
@endif
