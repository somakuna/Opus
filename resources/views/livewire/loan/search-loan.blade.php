<div class="row g-3">
    <!-- Left Column: Search + Summary -->
    <div class="col-md-3">
      <div class="panel mb-3">
        <h5 class="panel-title"><i class="bi bi-search"></i> Search loans</h5>
        <form>
          <div class="row g-2">
            <div class="col">
                <input wire:model="description" type="text" placeholder="Searching for..." class="form-control @error('description') is-invalid @enderror">
            </div>
            <div class="col-auto">
              <button type="submit" wire:click.prevent="search" class="btn btn-primary btn-sm">
                <i class="bi bi-search"></i> Search
              </button>
            </div>
          </div>
        </form>
      </div>

      <div class="modern-table">
        <table class="table table-sm mb-0">
          <thead>
            <tr>
              <th class="text-center" width="30"></th>
              <th>Partner</th>
              <th class="text-center text-muted">#</th>
              <th class="text-end">In</th>
              <th class="text-end">Out</th>
              <th class="text-end">Balance</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($partners as $partner)
              @if ($partner->loans->isNotEmpty())
              <tr>
                <td class="text-center">
                  <a href="" wire:click.prevent="filterLoansByClient({{$partner->id}})" class="action-btn" style="width:auto;height:auto"><i class="bi bi-funnel"></i></a>
                </td>
                <td>{{ $partner->name }}</td>
                <td class="text-muted text-center">{{ $partner->loans->count() }}</td>
                <td class="text-end text-sm">@money($partner->loans->where('method', 'in')->sum('amount'))</td>
                <td class="text-end text-sm">@money($partner->loans->where('method', 'out')->sum('amount'))</td>
                <td class="text-end fw-semibold @if($partner->balance() >= 0) text-success @else text-danger @endif">@money($partner->balance())</td>
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Right Column: Results Table -->
    <div class="col-md-9">
      <div class="modern-table">
        <table class="table table-sm mb-0">
            <thead>
              <tr>
                  <th width="150">Partner</th>
                  <th width="80" class="text-end">Amount</th>
                  <th>Description</th>
                  <th>Date</th>
                  <th class="text-center" width="60">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($loans as $loan)
                  <tr @if($loan->trashed()) class="table-danger" @endif>
                    <td class="text-secondary">{{ $loan->partner->name ?? '/' }}</td>
                    <td class="@if($loan->method == 'in') text-success @else text-danger @endif text-end fw-semibold">@money($loan->amount)</td>
                    <td>{{ $loan->description }}</td>
                    <td class="text-secondary text-sm">{{ $loan->created_at->format('d.m.y.') ?? '/' }}</td>
                    <td class="text-center">
                      @if($loan->trashed())
                        <a href="" wire:click.prevent="restore({{ $loan->id }})" class="action-btn" style="width:auto;height:auto"><i class="bi bi-arrow-counterclockwise"></i></a>
                        <a href="" wire:click.prevent="destroy({{ $loan->id }})" class="action-btn" style="width:auto;height:auto;color:#e74c3c"><i class="bi bi-x-circle"></i></a>
                      @else
                        <a href="" wire:click.prevent="delete({{$loan->id}})" class="action-btn" style="width:auto;height:auto"><i class="bi bi-trash3"></i></a>
                      @endif
                    </td>
                  </tr>
              @endforeach
              <tr class="fw-semibold" style="background: #f8f9fa;">
                <td colspan="5">
                  <div class="d-flex gap-4 align-items-center">
                    <span>Total</span>
                    <span>
                      <span class="badge text-bg-success"><i class="bi bi-box-arrow-in-right"></i></span>
                      @money($totalIn)
                    </span>
                    <span>
                      <span class="badge text-bg-danger"><i class="bi bi-box-arrow-right"></i></span>
                      @money($totalOut)
                    </span>
                    <span>
                      <span class="badge text-bg-secondary"><i class="bi bi-arrow-left-right"></i></span>
                      @money($totalIn - $totalOut)
                    </span>
                  </div>
                </td>
              </tr>
            </tbody>
        </table>
      </div>
      <div class="mt-3">{{ $loans->links() }}</div>
    </div>
</div>
