<div>
    {{-- <form method="POST" action="{{ route('healthCenter.store') }}" enctype="multipart/form-data"> --}}
    <form wire:submit.prevent="create">
      <div class="row g-3 align-items-center">
        <div class="col-12 text-center">
          <h3 class="fw-bold text-secondary">Create work</h3>
        </div>
        <div class="col-12">
          <div class="form-floating">
            <input id="client" wire:model="client" type="text" class="form-control @error('client') is-invalid @enderror" placeholder="Name">
            <label>Client</label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-floating">
            <select class="form-select @error('priority') is-invalid @enderror" wire:model.live="priority">
              <option value="0">Low</option>
              <option value="1">Medium</option>
              <option value="2">High</option>
              <option value="3">Most important</option>
            </select>
            <label class="form-label">Priority</label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-floating">
            <select class="form-select @error('priority') is-invalid @enderror" wire:model.live="source">
              <option value="Walk in" class="text-secondary">Walk in</option>
              <option value="E-mail" class="text-primary">E-mail</option>
              <option value="WhatsApp" class="text-success">WhatsApp</option>
              <option value="Signal" class="text-primary">Signal</option>
            </select>
            <label class="form-label">Source</label>
          </div>
        </div> 
        <div class="col-md-6">
          <div class="form-floating">
            <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" placeholder="Description" style="height: 300px"></textarea>
            <label>Description</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <textarea class="form-control text-secondary @error('note') is-invalid @enderror" wire:model="note" placeholder="Note" style="height: 300px"></textarea>
            <label>Note</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <input type="number" wire:model="price" class="form-control @error('price') is-invalid @enderror" placeholder="Price">
            <label>Price</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select wire:model="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
              <option value="Cash" selected>Cash</option>
              <option value="R1">R1</option>
            </select>
            <label class="form-label">Payment method</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select wire:model.live="partner_id" class="form-select text-primary @error('partner_id') is-invalid @enderror">
              <option value="" selected>-</option>
              @foreach ($partners as $partner)
                <option value="{{$partner->id}}">{{$partner->name}}</option>
              @endforeach
            </select>
            <label>Partner</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <input type="number" wire:model="outsourced_price" class="form-control @error('outsourced_price') is-invalid @enderror" placeholder="Outsoruce price">
            <label>Outsource price</label>
          </div>
        </div>
        <div class="col-auto">
          @if (!empty($partner_id))
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="outsourced" value="1">
            <label class="form-check-label">Outsourced</label>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="loan_id" value="1">
            <label class="form-check-label">Add to loans</label>
          </div>
          @endif
        </div>
        <div class="col-auto">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="design" value="1">
            <label class="form-check-label">Prepared</label>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="ready" value="1">
            <label class="form-check-label">Ready</label>
          </div>
        </div>
        <div class="col-auto">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="delivered" value="1">
            <label class="form-check-label">Delivered</label>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="paid" value="1">
            <label class="form-check-label">Paid</label>
          </div>
        </div>
        <div class="col text-end">
          <button type="submit" class="btn btn-success">Create</button>
        </div>
        <div class="col-auto">
          <div class="text-warning" wire:loading> 
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </div>
      </div>
    </form>
</div>
