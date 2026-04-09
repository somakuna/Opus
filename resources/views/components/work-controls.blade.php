<a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, false]) }}" target="_blank"
    class="action-btn @if($work->printed) status-on @endif" title="Receipt">
    <i class="bi bi-receipt"></i>
</a>
<a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, true]) }}" target="_blank"
    class="action-btn @if($work->printed) status-on @endif" title="Print">
    <i class="bi bi-printer"></i>
</a>
<a href="{{ route('work.edit', $work) }}" class="action-btn" title="Edit">
    <i class="bi bi-pencil"></i>
</a>
<a wire:click.prevent="delete({{$work->id}})" class="action-btn" title="Delete">
    <i class="bi bi-trash3"></i>
</a>

@if($priority >= 0 && $priority < 3)
<a wire:click.prevent="increasePriority({{$work->id}})" class="action-btn" title="Increase priority">
    <i class="bi bi-chevron-left"></i>
</a>
@endif
@if($priority <= 3 && $priority > 0)
<a wire:click.prevent="decreasePriority({{$work->id}})" class="action-btn" title="Decrease priority">
    <i class="bi bi-chevron-right"></i>
</a>
@endif
