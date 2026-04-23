<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="view-toggle btn-group btn-group-sm" role="group">
            <button wire:click="$set('viewMode', 'kanban')" class="btn {{ $viewMode === 'kanban' ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="bi bi-kanban"></i> Kanban
            </button>
            <button wire:click="$set('viewMode', 'table')" class="btn {{ $viewMode === 'table' ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="bi bi-table"></i> Table
            </button>
        </div>
    </div>

    @if($viewMode === 'kanban')
        <div class="row g-3">
            <x-work-column :works="$works" priority="3" color="danger" label="Urgent" />
            <x-work-column :works="$works" priority="2" color="warning" label="High" />
            <x-work-column :works="$works" priority="1" color="primary" label="Medium" />
            <x-work-column :works="$works" priority="0" color="success" label="Low" />
        </div>
    @else
        <div class="modern-table">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 4px; padding: 0;"></th>
                            <th>#</th>
                            <th>Client</th>
                            <th>Description</th>
                            <th>Source</th>
                            <th>Price</th>
                            <th>Partner</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $priorityColors = [3 => '#e74c3c', 2 => '#f0ad4e', 1 => '#4f6ef7', 0 => '#2ecc71'];
                            $sortedWorks = $works->sortByDesc('priority');
                        @endphp
                        @forelse($sortedWorks as $work)
                            <tr class="work-table-row">
                                <td class="p-0" style="width: 4px; background: {{ $priorityColors[$work->priority] ?? '#6c757d' }};"></td>
                                <td class="text-muted">{{ $work->id }}</td>
                                <td class="fw-semibold">{{ $work->client }}</td>
                                <td class="text-truncate-cell">{{ Str::limit(strip_tags($work->description), 60) }}</td>
                                <td>@include('components.work-source', ['work' => $work])</td>
                                <td>
                                    @if($work->price)
                                        <span class="price-badge">{{ $work->price }} &euro;</span>
                                    @endif
                                </td>
                                <td>
                                    @if($work->partner)
                                        <span class="text-sm">{{ $work->partner->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @include('components.work-status', ['work' => $work])
                                    </div>
                                </td>
                                <td class="text-muted text-sm text-nowrap">{{ $work->created_at }}</td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-end">
                                        @include('components.work-controls', ['work' => $work, 'priority' => $work->priority])
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">No work items found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
