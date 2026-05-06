<div>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h5 class="section-header mb-0"><i class="bi bi-arrow-repeat"></i> Circular</h5>
        <a href="{{ route('circular.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> New
        </a>
    </div>

    <div class="d-flex flex-wrap gap-2 mb-3">
        <div class="flex-grow-1" style="max-width: 320px;">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search by client or description...">
        </div>
        <select wire:model.live="filterStatus" class="form-select form-select-sm" style="width: auto;">
            <option value="">All statuses</option>
            <option value="active">Active</option>
            <option value="paused">Paused</option>
            <option value="ended">Ended</option>
        </select>
    </div>

    <div class="modern-table">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Frequency</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Next due</th>
                        <th class="text-end">Price</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($circulars as $circular)
                        <tr>
                            <td class="fw-semibold">{{ $circular->client }}</td>
                            <td>
                                <span class="circular-type-badge type-{{ Str::slug($circular->type) }}">
                                    {{ $circular->type }}
                                </span>
                            </td>
                            <td class="text-truncate-cell text-sm">{{ Str::limit($circular->description, 50) }}</td>
                            <td class="text-sm text-nowrap">
                                <i class="bi bi-clock-history text-muted"></i>
                                {{ $circular->frequency_label }}
                            </td>
                            <td class="text-sm text-nowrap">{{ $circular->start_date->format('d.m.Y.') }}</td>
                            <td class="text-sm text-nowrap">
                                @if($circular->end_date)
                                    {{ $circular->end_date->format('d.m.Y.') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-sm text-nowrap">
                                @if($circular->status === 'active' && $circular->next_due_date)
                                    @php
                                        $daysUntil = now()->startOfDay()->diffInDays($circular->next_due_date, false);
                                    @endphp
                                    <span class="{{ $daysUntil <= 7 ? 'text-danger fw-semibold' : ($daysUntil <= 30 ? 'text-warning' : 'text-muted') }}">
                                        {{ $circular->next_due_date->format('d.m.Y.') }}
                                        @if($daysUntil <= 7 && $daysUntil >= 0)
                                            <i class="bi bi-exclamation-circle"></i>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                @if($circular->price)
                                    <span class="price-badge">{{ number_format($circular->price, 2) }} &euro;</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="circular-status-badge status-{{ $circular->status }}">
                                    {{ ucfirst($circular->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-end">
                                    <a wire:click.prevent="toggleStatus({{ $circular->id }})" class="action-btn" title="Toggle status">
                                        @if($circular->status === 'active')
                                            <i class="bi bi-pause-fill"></i>
                                        @else
                                            <i class="bi bi-play-fill"></i>
                                        @endif
                                    </a>
                                    <a href="{{ route('circular.edit', $circular) }}" class="action-btn" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a wire:click.prevent="delete({{ $circular->id }})" class="action-btn" title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">No circular items found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
