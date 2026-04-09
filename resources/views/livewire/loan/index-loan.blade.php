<div class="row g-3">
    <!-- Left Column: Form + Summary -->
    <div class="col-md-3">
      <div class="panel mb-3">
        <h5 class="panel-title"><i class="bi bi-plus-circle"></i> New loan</h5>
        <form>
          <div class="row g-2">
            <div class="col-6">
                <select wire:model="partner_id" class="form-select @error('partner_id') is-invalid @enderror">
                  <option value="" selected>Partner</option>
                  @foreach ($partners as $partner)
                    <option value="{{$partner->id}}">{{$partner->name}}</option>
                  @endforeach
                </select>
            </div>
            <div class="col-6">
                <input wire:model="amount" type="number" placeholder="Amount &euro;" class="form-control @error('amount') is-invalid @enderror">
            </div>
            <div class="col-12">
                <input wire:model="description" type="text" placeholder="Description" class="form-control @error('description') is-invalid @enderror">
            </div>
            <div class="col-12 d-flex gap-2">
              <a wire:click.prevent="create('in')" class="btn btn-success btn-sm flex-fill">
                <i class="bi bi-box-arrow-in-right"></i> IN
              </a>
              <a wire:click.prevent="create('out')" class="btn btn-danger btn-sm flex-fill">
                <i class="bi bi-box-arrow-right"></i> OUT
              </a>
              <a class="btn btn-outline-secondary btn-sm" href="{{ route('loan.search') }}">
                <i class="bi bi-search"></i>
              </a>
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

    <!-- Right Column: Loan Table -->
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
            </tbody>
        </table>
      </div>
      <div class="mt-3">{{ $loans->links() }}</div>
    </div>

    <div class="col-md-12" style="height: 32rem">
      <livewire:livewire-line-chart
          key="{{ $lineChartModel->reactiveKey() }}"
          :line-chart-model="$lineChartModel"
      />
    </div>
</div>
