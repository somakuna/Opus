<div class="row">
    <!-- Left Column: Form -->
    <div class="col-md-3">

      <div class="row g-2">
        <div class="col-12">
          <h5>Insert new loan</h5>
          <form>
          <div class="row g-2">
            <div class="col-6">
                <select wire:model="partner_id" class="form-select text-warning @error('partner_id') is-invalid @enderror">
                  <option value="" selected>-</option>
                  @foreach ($partners as $partner)
                    <option value="{{$partner->id}}">{{$partner->name}}</option>
                  @endforeach
                </select>  
            </div>
            <div class="col-6">
                <input wire:model="amount" type="number" placeholder="€" class="form-control text-primary-emphasis @error('amount') is-invalid @enderror" id="floatingInput">   
            </div>
            <div class="col-12">   
                <input wire:model="description" type="text" placeholder="Description" class="form-control  @error('description') is-invalid @enderror" id="floatingInput">
            </div>
            <div class="col-auto">
              <a wire:click.prevent="create('in')" class="btn btn-success"><i class="bi bi-box-arrow-in-right"></i> IN</a>
            </div>
            <div class="col-auto">
              <a wire:click.prevent="create('out')" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> OUT</a>
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
                @if($loan->trashed()) 
                  <tr class="table-danger">
                    <td class="text-secondary">{{ $loan->partner->name ?? '/' }}</td>
                    <td class="@if($loan->method == 'in') text-success @else text-danger @endif text-end" >@money($loan->amount)</td>
                    <td>{{ $loan->description }}</td>
                    <td class="text-secondary">{{ $loan->created_at->format('d.m.y.') ?? '/' }}</td>
                    <td class="text-center">
                      <a href="" wire:click.prevent="restore({{ $loan->id }})" class="text-secondary"><i class="bi bi-recycle"></i></a> 
                      <a href="" wire:click.prevent="destroy({{ $loan->id }})" class="text-secondary"><i class="bi bi-x-octagon"></i></a>
                    </td>
                  </tr>
                @else
                  <tr>
                    <td class="text-secondary">{{ $loan->partner->name ?? '/' }}</td>
                    <td class="@if($loan->method == 'in') text-success @else text-danger @endif text-end" >@money($loan->amount)</td>
                    <td>{{ $loan->description }}</td>
                    <td class="text-secondary">{{ $loan->created_at->format('d.m.y.') ?? '/' }}</td>
                    <td class="text-center">
                      <a href="" wire:click.prevent="delete({{$loan->id}})" class="text-secondary">
                        <i class="bi bi-trash"></i>
                      </a>
                    </td>
                  </tr>
                @endif
              @endforeach
            </tbody>
        </table>
      </div>
      <div>{{ $loans->links() }}</div>  
    </div>
</div>
