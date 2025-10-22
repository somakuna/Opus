<div class="row g-3">
  <!-- Left Column: Form -->
  <div class="col-md-3">
    <div class="row g-2">
      <div class="col-12">
        <h5>Insert item lending</h5>
        <form>
        <div class="row g-2">
          <div class="col-6">
            <input wire:model="name" type="text" placeholder="What?" class="form-control text-primary-emphasis @error('name') is-invalid @enderror" id="floatingInput">
          </div>
          <div class="col-6">
              <input wire:model="lender" type="text" placeholder="To who?" class="form-control text-primary-emphasis @error('lender') is-invalid @enderror" id="floatingInput">   
          </div>
          <div class="col-12">   
              <input wire:model="note" type="text" placeholder="Note..." class="form-control @error('note') is-invalid @enderror" id="floatingInput">
          </div>
          <div class="col-12">   
            <input wire:model="date_lended" type="date" placeholder="Date" class="form-control @error('date_lended') is-invalid @enderror" id="floatingInput">
          </div>
          <div class="col-auto">
            @if (!$item)
              <a wire:click.prevent="create" class="btn btn-primary"><i class="bi bi-floppy"></i> Save</a>
            @else
              <a wire:click.prevent="store({{$item}})" class="btn btn-success"><i class="bi bi-floppy"></i> Edit</a>
            @endif
          </div>
          </div>
        </div>  
      </form>
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
                <th scope="col" width="200">Item</th>
                <th scope="col" width="200">Lender</th>
                <th scope="col" width="200">Note</th>
                <th scope="col">Date lended</th>
                <th scope="col">Date deleted</th>
                <th scope="col" class="text-center" width="40">Action</th> 
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
                <tr @if($item->trashed()) class="table-danger" @endif>
                  <td class="text-secondary">{{ $item->name ?? '/' }}</td>
                  <td class="text-secondary">{{ $item->lender ?? '/' }}</td>
                  <td class="text-secondary">{{ $item->note }}</td>
                  <td class="text-secondary">{{ $item->date_lended ? $item->date_lended->format('d.m.y.') : '/' }}</td>
                  <td class="text-secondary">{{ $item->deleted_at ? $item->deleted_at->format('d.m.y.') : '/' }}</td>
                  <td class="text-center">
                    @if($item->trashed()) 
                      <a href="" wire:click.prevent="restore({{ $item->id }})" class="text-secondary"><i class="bi bi-recycle"></i></a> 
                      <a href="" wire:click.prevent="destroy({{ $item->id }})" class="text-secondary"><i class="bi bi-x-octagon"></i></a>
                    @else
                    <a href="" wire:click.prevent="whatToEdit({{$item}})" class="text-secondary">
                      <i class="bi bi-pen"></i>
                    </a>
                    <a href="" wire:click.prevent="delete({{$item->id}})" class="text-secondary">
                      <i class="bi bi-trash"></i>
                    </a>
                    @endif
                  </td>
                </tr>
            @endforeach
          </tbody>
      </table>
    </div>
    <div>{{ $items->links()}}</div>  
  </div>
</div>
