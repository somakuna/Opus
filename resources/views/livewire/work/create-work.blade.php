<div>
    <form wire:submit.prevent="create">
      <div class="modern-form">
        <h3 class="form-header"><i class="bi bi-plus-circle"></i> Create work</h3>
        <div class="row g-3">
          <div class="col-12">
            <div class="form-floating">
              <input id="client" wire:model="client" type="text" class="form-control @error('client') is-invalid @enderror" placeholder=" ">
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
                <option value="Walk in">Walk in</option>
                <option value="E-mail">E-mail</option>
                <option value="WhatsApp">WhatsApp</option>
                <option value="Signal">Signal</option>
              </select>
              <label class="form-label">Source</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" placeholder=" " style="height: 250px"></textarea>
              <label>Description</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <textarea class="form-control @error('note') is-invalid @enderror" wire:model="note" placeholder=" " style="height: 250px"></textarea>
              <label>Note</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <input type="number" wire:model="price" class="form-control @error('price') is-invalid @enderror" placeholder=" ">
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
              <select wire:model.live="partner_id" class="form-select @error('partner_id') is-invalid @enderror">
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
              <input type="number" wire:model="outsourced_price" class="form-control @error('outsourced_price') is-invalid @enderror" placeholder=" ">
              <label>Outsource price</label>
            </div>
          </div>

          <div class="col-12">
            <div class="d-flex flex-wrap align-items-center gap-4 pt-2">
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
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" wire:model="design" value="1">
                <label class="form-check-label">Prepared</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" wire:model="ready" value="1">
                <label class="form-check-label">Ready</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" wire:model="delivered" value="1">
                <label class="form-check-label">Delivered</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" wire:model="paid" value="1">
                <label class="form-check-label">Paid</label>
              </div>
            </div>
          </div>

          <div class="col-12 d-flex justify-content-between align-items-center pt-2">
            <div class="loading-spinner" wire:loading>
              <div class="spinner-border" role="status"></div>
              <span>Saving...</span>
            </div>
            <div class="ms-auto">
              <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-lg"></i> Create
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
</div>
