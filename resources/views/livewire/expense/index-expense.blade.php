<div>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h5 class="section-header mb-0"><i class="bi bi-cash-stack"></i> Periodic expenses</h5>
        <a href="{{ route('expense.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> New
        </a>
    </div>

    <div class="schedule-summary mb-3">
        <div class="summary-tile">
            <span class="summary-label">Due so far</span>
            <span class="summary-value">{{ $totalDue }}</span>
        </div>
        <div class="summary-tile">
            <span class="summary-label">Paid</span>
            <span class="summary-value text-success">{{ $totalPaid }}</span>
        </div>
        <div class="summary-tile">
            <span class="summary-label">Not paid</span>
            <span class="summary-value {{ $totalDue - $totalPaid > 0 ? 'text-danger' : 'text-muted' }}">{{ $totalDue - $totalPaid }}</span>
        </div>
        <div class="summary-tile">
            <span class="summary-label">Outstanding</span>
            <span class="summary-value {{ $outstandingAmount > 0 ? 'text-danger' : 'text-muted' }}">{{ number_format($outstandingAmount, 2) }} &euro;</span>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2 mb-3">
        <div class="flex-grow-1" style="max-width: 320px;">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search by name or description...">
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
                        <th>Name</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Frequency</th>
                        <th>Start</th>
                        <th>End</th>
                        <th class="text-center">Due so far</th>
                        <th class="text-center">Paid</th>
                        <th>Next due</th>
                        <th class="text-end">Amount</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                        @php
                            $dueCount = $expense->due_count;
                            $paidCount = $expense->settled_count;
                            $openCount = $dueCount - $paidCount;
                        @endphp
                        <tr wire:key="expense-{{ $expense->id }}">
                            <td class="fw-semibold">{{ $expense->name }}</td>
                            <td>
                                <span class="circular-type-badge type-{{ Str::slug($expense->type) }}">
                                    {{ $expense->type }}
                                </span>
                            </td>
                            <td class="text-truncate-cell text-sm">{{ Str::limit($expense->description, 50) }}</td>
                            <td class="text-sm text-nowrap">
                                <i class="bi bi-clock-history text-muted"></i>
                                {{ $expense->frequency_label }}
                            </td>
                            <td class="text-sm text-nowrap">{{ $expense->start_date->format('d.m.Y.') }}</td>
                            <td class="text-sm text-nowrap">
                                @if($expense->end_date)
                                    {{ $expense->end_date->format('d.m.Y.') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a wire:click.prevent="toggleExpand({{ $expense->id }})" class="due-count-badge" title="Show occurrences">
                                    {{ $dueCount }}&times;
                                    <i class="bi bi-chevron-{{ $expanded === $expense->id ? 'up' : 'down' }}"></i>
                                </a>
                            </td>
                            <td class="text-center text-nowrap">
                                <span class="charged-ratio {{ $openCount > 0 ? 'has-open' : ($dueCount > 0 ? 'all-settled' : '') }}">
                                    {{ $paidCount }} / {{ $dueCount }}
                                </span>
                            </td>
                            <td class="text-sm text-nowrap">
                                @if($expense->status === 'active' && $expense->next_due_date)
                                    @php
                                        $daysUntil = now()->startOfDay()->diffInDays($expense->next_due_date, false);
                                    @endphp
                                    <span class="{{ $daysUntil <= 7 ? 'text-danger fw-semibold' : ($daysUntil <= 30 ? 'text-warning' : 'text-muted') }}">
                                        {{ $expense->next_due_date->format('d.m.Y.') }}
                                        @if($daysUntil <= 7 && $daysUntil >= 0)
                                            <i class="bi bi-exclamation-circle"></i>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                @if($expense->amount)
                                    <span class="price-badge">{{ number_format($expense->amount, 2) }} &euro;</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="circular-status-badge status-{{ $expense->status }}">
                                    {{ ucfirst($expense->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-end">
                                    <a wire:click.prevent="toggleStatus({{ $expense->id }})" class="action-btn" title="Toggle status">
                                        @if($expense->status === 'active')
                                            <i class="bi bi-pause-fill"></i>
                                        @else
                                            <i class="bi bi-play-fill"></i>
                                        @endif
                                    </a>
                                    <a href="{{ route('expense.edit', $expense) }}" class="action-btn" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a wire:click.prevent="delete({{ $expense->id }})" class="action-btn" title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        @if($expanded === $expense->id)
                            <tr wire:key="expense-detail-{{ $expense->id }}" class="occurrence-row">
                                <td colspan="12" class="p-0">
                                    <div class="occurrence-panel">
                                        <div class="occurrence-panel-header">
                                            <span>
                                                <i class="bi bi-list-check"></i>
                                                Occurrences due so far &mdash; <strong>{{ $dueCount }}</strong>,
                                                paid <strong class="text-success">{{ $paidCount }}</strong>,
                                                open <strong class="{{ $openCount > 0 ? 'text-danger' : 'text-muted' }}">{{ $openCount }}</strong>
                                                @if($expense->unsettled_amount > 0)
                                                    ({{ number_format($expense->unsettled_amount, 2) }} &euro;)
                                                @endif
                                            </span>
                                            @if($openCount > 0)
                                                <a wire:click.prevent="payAll({{ $expense->id }})" class="btn btn-outline-success btn-sm">
                                                    <i class="bi bi-check2-all"></i> Mark all paid
                                                </a>
                                            @endif
                                        </div>

                                        @php $rows = $expense->scheduleRows()->reverse(); @endphp

                                        @if($rows->isEmpty())
                                            <div class="occurrence-empty">Nothing due yet &mdash; starts {{ $expense->start_date->format('d.m.Y.') }}</div>
                                        @else
                                            <div class="occurrence-scroll">
                                                <table class="table table-sm occurrence-table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 3rem;">#</th>
                                                            <th>Due date</th>
                                                            <th class="text-end">Amount</th>
                                                            <th>Paid on</th>
                                                            <th class="text-center" style="width: 8rem;">Paid</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($rows as $row)
                                                            @php
                                                                $payment = $row['settlement'];
                                                                $isPaid = (bool) $payment;
                                                            @endphp
                                                            <tr wire:key="payment-{{ $expense->id }}-{{ $row['date']->format('Ymd') }}" class="{{ $isPaid ? '' : 'occurrence-open' }}">
                                                                <td class="text-muted">{{ $row['number'] }}</td>
                                                                <td class="text-nowrap">{{ $row['date']->format('d.m.Y.') }}</td>
                                                                <td class="text-end text-nowrap">
                                                                    @php $amount = $payment?->amount ?? $expense->amount; @endphp
                                                                    @if($amount !== null)
                                                                        {{ number_format($amount, 2) }} &euro;
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-nowrap text-sm">
                                                                    @if($payment && $payment->paid_at)
                                                                        {{ $payment->paid_at->format('d.m.Y.') }}
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <a wire:click.prevent="togglePayment({{ $expense->id }}, '{{ $row['date']->format('Y-m-d') }}')"
                                                                       class="settle-toggle {{ $isPaid ? 'is-settled' : '' }}"
                                                                       title="{{ $isPaid ? 'Mark as not paid' : 'Mark as paid' }}">
                                                                        <i class="bi bi-{{ $isPaid ? 'check-circle-fill' : 'circle' }}"></i>
                                                                        {{ $isPaid ? 'Paid' : 'Open' }}
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted py-4">No periodic expenses found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
