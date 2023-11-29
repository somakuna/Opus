<div>
  <form wire:submit="update">
    <div class="row g-3 align-items-center">
      <div class="col-12">
        <h3>Edit work</h3>
      </div>
      <div class="col-6">
        <div class="form-floating">
          <input id="client" wire:model="work.client" type="text"class="form-control" placeholder="Name">
          <label>Client</label>
        </div>
        @error('work.client')<div class="text-danger"> {{ $message }}</div>@enderror
      </div>
      <div class="col-6">
        <div class="form-floating">
          <select class="form-select" wire:model="work.priority">
            <option value="0" @selected($work->priority == 0)>Low</option>
            <option value="1" @selected($work->priortiy == 1)>Medium</option>
            <option value="2" @selected($work->priortiy == 2)>High</option>
            <option value="3" @selected($work->priortiy == 3)>Most important</option>
          </select>
          <label class="form-label">Priority</label>
        </div>
        @error('work.priority')<div class="text-danger"> {{ $message }}</div>@enderror
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control" wire:model="work.description" placeholder="Description" style="height: 100px"></textarea>
          <label>Description</label>
        </div>
        @error('work.description')<div class="text-danger"> {{ $message }}</div>@enderror
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control text-secondary" wire:model="work.note" placeholder="Note"></textarea>
          <label>Note</label>
        </div>
        @error('work.note')<div class="text-danger"> {{ $message }}</div>@enderror
      </div>
      <div class="col-6">
        <div class="form-floating">
          <input type="number" wire:model="work.price" class="form-control" placeholder="Price">
          <label>Price</label>
        </div>
        @error('work.price')<div class="text-danger"> {{ $message }}</div>@enderror
      </div>
      <div class="col-6">
        <div class="form-floating">
          <select wire:model="work.payment_method" class="form-select">
            <option value="Cash" @selected($work->payment_method == 'Cash')>Cash</option>
            <option value="R1" @selected($work->payment_method == 'R1')>R1</option>
          </select>
          <label class="form-label">Payment method</label>
        </div>
        @error('work.payment_method')<div class="text-danger"> {{ $message }}</div>@enderror
      </div>
      <div class="col-6">
        <div class="form-floating">
          <select wire:model.live="work.partner_id" class="form-select text-warning" @disabled($work->loan)>
            <option value="" selected>-</option>
            @foreach ($partners as $partner)
              <option value="{{ $partner->id }}" @selected($work->partner_id == $partner->id)>{{ $partner->name }}</option>
            @endforeach
          </select>
          <label>Partner</label>
        </div>
        @error('work.partner_id')<div class="text-danger"> {{ $message }}</div>@enderror
      </div>
      <div class="col-6">
        <div class="form-floating">
          <input type="number" wire:model.live="work.outsourced_price" class="form-control" placeholder="Outsoruce price" @disabled($work->loan)>
          <label>Outsoruce price</label>
        </div>
        @error('work.outsourced_price')<div class="text-danger"> {{ $message }}</div>@enderror
      </div>
      @if($work->loan) 
      <div class="col-12">
        <div class="alert alert-warning text-center" role="alert">
          A loan has already been inserted for this work. To delete it, please click <a wire:click.prevent="deleteLoan" href="" class="link">here</a>.
        </div>
      </div>
      @endif
      <div class="col-auto">
        @if(!empty($work->partner_id))
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" wire:model="work.outsourced" value="1" @checked($work->outsourced)>
          <label class="form-check-label">Outsourced</label>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" wire:model="loan_id" value="1" @disabled($work->loan)>
          <label class="form-check-label">Add to Loans</label>
        </div>
        @endif
      </div>
      <div class="col-auto">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" wire:model="work.design" value="1" @checked($work->design)>
          <label class="form-check-label">Prepared</label>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" wire:model="work.ready" value="1" @checked($work->ready)>
          <label class="form-check-label">Ready</label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" wire:model="work.delivered" value="1" @checked($work->delivered)>
          <label class="form-check-label">Delivered</label>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" wire:model="work.paid" value="1" @checked($work->paid)>
          <label class="form-check-label">Paid</label>
        </div>
      </div>
      <div class="col text-end">
          <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
    <div class="text-primary" wire:loading> 
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </form>
</div>
