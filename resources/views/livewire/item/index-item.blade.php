<div class="row g-3">
  <!-- Left Column: Form -->
  <div class="col-md-3">
    <div class="panel">
      <h5 class="panel-title"><i class="bi bi-arrow-left-right"></i> Item lending</h5>
      <form>
        <div class="row g-2">
          <div class="col-6">
            <input wire:model="name" type="text" placeholder="What?" class="form-control @error('name') is-invalid @enderror">
          </div>
          <div class="col-6">
            <input wire:model="lender" type="text" placeholder="To who?" class="form-control @error('lender') is-invalid @enderror">
          </div>
          <div class="col-12">
            <input wire:model="note" type="text" placeholder="Note..." class="form-control @error('note') is-invalid @enderror">
          </div>
          <div class="col-12">
            <input wire:model="date_lended" type="date" class="form-control @error('date_lended') is-invalid @enderror">
          </div>
          <div class="col-12">
            @if (!$item)
              <a wire:click.prevent="create" class="btn btn-primary btn-sm w-100"><i class="bi bi-floppy"></i> Save</a>
            @else
              <a wire:click.prevent="store({{$item}})" class="btn btn-success btn-sm w-100"><i class="bi bi-floppy"></i> Update</a>
            @endif
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Right Column: Table -->
  <div class="col-md-9">
    <div class="modern-table">
      <table class="table table-sm mb-0">
          <thead>
            <tr>
                <th width="200">Item</th>
                <th width="200">Lender</th>
                <th width="200">Note</th>
                <th>Date lent</th>
                <th>Date deleted</th>
                <th class="text-center" width="80">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
                <tr @if($item->trashed()) class="table-danger" @endif>
                  <td>{{ $item->name ?? '/' }}</td>
                  <td class="text-secondary">{{ $item->lender ?? '/' }}</td>
                  <td class="text-secondary text-sm">{{ $item->note }}</td>
                  <td class="text-secondary text-sm">{{ $item->date_lended ? $item->date_lended->format('d.m.y.') : '/' }}</td>
                  <td class="text-secondary text-sm">{{ $item->deleted_at ? $item->deleted_at->format('d.m.y.') : '/' }}</td>
                  <td class="text-center">
                    @if($item->trashed())
                      <a href="" wire:click.prevent="restore({{ $item->id }})" class="action-btn" style="width:auto;height:auto"><i class="bi bi-arrow-counterclockwise"></i></a>
                      <a href="" wire:click.prevent="destroy({{ $item->id }})" class="action-btn" style="width:auto;height:auto;color:#e74c3c"><i class="bi bi-x-circle"></i></a>
                    @else
                      <a href="" wire:click.prevent="whatToEdit({{$item}})" class="action-btn" style="width:auto;height:auto"><i class="bi bi-pencil"></i></a>
                      <a href="" wire:click.prevent="delete({{$item->id}})" wire:confirm="Are you sure you want to delete?" class="action-btn" style="width:auto;height:auto"><i class="bi bi-trash3"></i></a>
                    @endif
                  </td>
                </tr>
            @endforeach
          </tbody>
      </table>
    </div>
    <div class="mt-3">{{ $items->links() }}</div>
  </div>
</div>
