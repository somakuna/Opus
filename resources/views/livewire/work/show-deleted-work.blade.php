<div>
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
      <h5 class="section-header mb-0"><i class="bi bi-archive"></i> Archived works</h5>
      <div style="max-width: 320px; flex-grow: 1;">
          <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search by client or description...">
      </div>
  </div>
  <div class="modern-table">
      <table class="table table-sm mb-0">
          <thead>
            <tr>
              <th>Client</th>
              <th style="width:40%">Description</th>
              <th>Note</th>
              <th class="text-end">Price</th>
              <th>Outsourced</th>
              <th class="text-end">OS price</th>
              <th>Created</th>
              <th>Deleted</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($works as $work)
              <tr>
                <td class="fw-semibold">{{ $work->client }}</td>
                <td class="text-sm">@markdown($work->description)</td>
                <td class="text-secondary text-sm">{{ $work->note }}</td>
                <td class="text-end">{{ $work->price }}</td>
                <td class="text-secondary text-sm">@if($work->partner) {{ $work->partner->name }} @endif</td>
                <td class="text-end">{{ $work->outsourced_price }}</td>
                <td class="text-secondary text-sm">{{ $work->created_at }}</td>
                <td class="text-secondary text-sm">{{ $work->deleted_at }}</td>
                <td class="text-center">
                    <a wire:click.prevent="restore({{$work->id}})" class="action-btn" style="width:auto;height:auto" title="Restore">
                      <i class="bi bi-arrow-counterclockwise text-success"></i>
                    </a>
                    <a wire:click.prevent="forceDelete({{$work->id}})" class="action-btn" style="width:auto;height:auto" title="Delete permanently">
                      <i class="bi bi-x-circle text-danger"></i>
                    </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
  </div>
  @if($works->isEmpty() && $search)
      <div class="text-center text-muted py-3">No results found for "{{ $search }}"</div>
  @endif
</div>
