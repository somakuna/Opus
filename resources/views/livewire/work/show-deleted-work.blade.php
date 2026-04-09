<div>
  <h5 class="section-header mb-3"><i class="bi bi-archive"></i> Archived works</h5>
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
  <div class="mt-3">
      {{ $works->links() }}
  </div>
</div>
