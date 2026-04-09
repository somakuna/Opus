{{-- resources/views/components/work-column.blade.php --}}
@props(['works', 'priority', 'color', 'label'])

@php
    $filteredWorks = $works->where('priority', $priority);
    $colorMap = [
        'danger'  => '#e74c3c',
        'warning' => '#f0ad4e',
        'primary' => '#4f6ef7',
        'success' => '#2ecc71',
    ];
    $dotColor = $colorMap[$color] ?? '#6c757d';
@endphp

@if($filteredWorks->count())
<div class="col-sm-3 priority-column">
    <div class="priority-header">
        <span class="priority-dot" style="background: {{ $dotColor }}"></span>
        <span class="priority-label">{{ $label }}</span>
        <span class="priority-count">{{ $filteredWorks->count() }}</span>
    </div>

    @foreach ($filteredWorks as $work)
        <div class="work-card priority-{{ $priority }}">
            <div class="work-card-header">
                <div>
                    <h4 class="work-client">{{ $work->client }}</h4>
                    <div class="work-meta">#{{ $work->id }} &middot; {{ $work->created_at }}</div>
                </div>
                <div class="d-flex flex-column align-items-end gap-1">
                    @include('components.work-source', ['work' => $work])
                </div>
            </div>

            <div class="work-description">
                @markdown($work->description)
            </div>

            @if($work->note)
                <div class="work-note">{!! nl2br(e($work->note)) !!}</div>
            @endif

            @if($work->partner)
                <div class="work-partner">
                    <span>
                        <i class="bi bi-person-gear"></i>
                        <strong>{{ $work->partner->name }}</strong> &middot; {{ $work->outsourced_price }} &euro;
                    </span>
                    <span>
                        @if($work->outsourced) <i class="bi bi-send-check text-success"></i> @endif
                        @if($work->loan) <i class="bi bi-currency-exchange text-primary"></i> @endif
                    </span>
                </div>
            @endif

            <div class="work-actions">
                <div class="work-controls">
                    @include('components.work-controls', ['work' => $work, 'priority' => $priority])
                </div>
                <div class="work-statuses">
                    @include('components.work-status', ['work' => $work])
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif
