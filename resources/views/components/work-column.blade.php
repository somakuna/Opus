{{-- resources/views/components/work-column.blade.php --}}
@props(['works', 'priority', 'color', 'label', 'density' => 'comfortable'])

@php
    $filteredWorks = $works->where('priority', $priority);
    $colorMap = [
        'danger'  => '#e74c3c',
        'warning' => '#f0ad4e',
        'primary' => '#4f6ef7',
        'success' => '#2ecc71',
    ];
    $dotColor = $colorMap[$color] ?? '#6c757d';
    $columnTotal = $filteredWorks->sum('price');
    $isCompact = $density === 'compact';
    $steps = ['design' => 'Design', 'ready' => 'Ready', 'delivered' => 'Delivered', 'paid' => 'Paid'];
@endphp

<div class="priority-column">
    <div class="priority-header">
        <span class="priority-dot" style="background: {{ $dotColor }}"></span>
        <span class="priority-label">{{ $label }}</span>
        <span class="priority-count">{{ $filteredWorks->count() }}</span>
        @if($columnTotal)
            <span class="priority-total">{{ number_format($columnTotal, 0, ',', '.') }} &euro;</span>
        @endif
    </div>

    <div class="column-scroll">
        @forelse ($filteredWorks as $work)
            @php $done = collect($steps)->keys()->filter(fn ($k) => $work->$k)->count(); @endphp

            <div class="work-card priority-{{ $priority }} {{ $isCompact ? 'is-compact' : '' }}">
                <div class="work-progress" title="{{ $done }}/{{ count($steps) }} done">
                    @foreach($steps as $key => $stepLabel)
                        <span class="work-progress-seg {{ $work->$key ? 'is-done' : '' }}" title="{{ $stepLabel }}"></span>
                    @endforeach
                </div>

                <div class="work-card-header">
                    <div class="work-card-identity">
                        <h4 class="work-client">{{ $work->client }}</h4>
                        <div class="work-meta">#{{ $work->id }} &middot; {{ $work->created_at }}</div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1">
                        @include('components.work-source', ['work' => $work])
                    </div>
                </div>

                @if($isCompact)
                    @if($work->description)
                        <div class="work-snippet">{{ Str::limit(strip_tags($work->description), 90) }}</div>
                    @endif
                    @if($work->partner)
                        <div class="work-partner-line">
                            <i class="bi bi-person-gear"></i> {{ $work->partner->name }}
                            @if($work->outsourced_price) &middot; {{ $work->outsourced_price }} &euro; @endif
                            @if($work->outsourced) <i class="bi bi-send-check text-success"></i> @endif
                            @if($work->loan) <i class="bi bi-currency-exchange text-primary"></i> @endif
                        </div>
                    @endif
                @else
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
        @empty
            <div class="column-empty">No {{ strtolower($label) }} work</div>
        @endforelse
    </div>
</div>
