<div class="row g-3">
    <!-- Left Column: Form -->
    <div class="col-md-3">

      <div class="row g-2">
        <div class="col-12">
          <h5>Search loans</h5>
          <form>
          <div class="row g-2">
            <div class="col">   
                <input wire:model="description" type="text" placeholder="Searching for..." class="form-control  @error('description') is-invalid @enderror" id="floatingInput">
            </div>
            <div class="col-3">
              <button type="submit" wire:click.prevent="search" class="btn btn-success"><i class="bi bi-search"></i>Search</button>
            </div>
          </div>  
        </form>
        </div>
        <div class="col-12">
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th scope="col" class="text-center"><i class="bi bi-arrow-down"></i></th>
                <th scope="col">Partner</th>
                <th scope="col" class="text-center text-muted">Loans</th>
                <th scope="col" class="text-end">In</th>
                <th scope="col" class="text-end">Out</th>
                <th scope="col" class="text-end">Balance</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($partners as $partner)
                @if ($partner->loans->isNotEmpty())
                <tr>
                  <td scope="row" class="text-center">                    
                    <a href="" wire:click.prevent="filterLoansByClient({{$partner->id}})" class="text-primary-emphasis"><i class="bi bi-funnel"></i></a>
                  </td>
                  <td scope="row">{{ $partner->name }}</td>
                  <td class="text-muted text-center">{{ $partner->loans->count() }}</td>
                  <td class="text-end"> @money($partner->loans->where('method', 'in')->sum('amount')) </td>
                  <td class="text-end"> @money($partner->loans->where('method', 'out')->sum('amount'))</td>
                  <td class="text-end @if($partner->balance() >= 0) text-success @else text-danger @endif">@money($partner->balance())</td>
                </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right Column: Table -->
    <div class="col-md-9">
      <div class="table-responsive">
        <h5>Table</h5>
        <!-- Your table goes here -->
        <table class="table table-sm">
            <thead>
              <tr class="table-striped-bg">
                  <th scope="col" width="150">Partner</th>
                  <th scope="col" width="80" class="text-end">€</th>
                  <th scope="col">Description</th>
                  <th scope="col">Date</th>
                  <th scope="col" class="text-center" width="40">Action</th> 
              </tr>
            </thead>
            <tbody>
              @foreach ($loans as $loan)
                  <tr @if($loan->trashed()) class="table-danger" @endif>
                    <td class="text-secondary">{{ $loan->partner->name ?? '/' }}</td>
                    <td class="@if($loan->method == 'in') text-success @else text-danger @endif text-end" >@money($loan->amount)</td>
                    <td>{{ $loan->description }}</td>
                    <td class="text-secondary">{{ $loan->created_at->format('d.m.y.') ?? '/' }}</td>
                    <td class="text-center">
                      @if($loan->trashed()) 
                        <a href="" wire:click.prevent="restore({{ $loan->id }})" class="text-secondary"><i class="bi bi-recycle"></i></a> 
                        <a href="" wire:click.prevent="destroy({{ $loan->id }})" class="text-secondary"><i class="bi bi-x-octagon"></i></a>
                      @else
                      <a href="" wire:click.prevent="delete({{$loan->id}})" class="text-secondary">
                        <i class="bi bi-trash"></i>
                      </a>
                      @endif
                    </td>
                  </tr>
              @endforeach
              <tr class="table-secondary fs-4">
                <td colspan="5">
                  <span class="me-5">Total</span> 
                  <span class="me-5">
                    <span class="badge text-bg-success">
                      <i class="bi bi-box-arrow-in-right"></i>
                    </span>
                    @money($totalIn) </span>
                  <span class="me-5">
                    <span class="badge text-bg-danger">
                      <i class="bi bi-box-arrow-right"></i>
                    </span>
                    @money($totalOut)
                  </span>
                  <span>
                    <span class="badge text-bg-secondary">
                      <i class="bi bi-arrow-down-up"></i>
                    </span>
                    @money($totalIn - $totalOut)
                  </span>
                </td>
              </tr>
            </tbody>
        </table>
      </div>
      <div>{{ $loans->links() }}</div>  
    </div>
</div>
