<div class="row">
    <div class="col">
        <table class="table table-light table-sm table-striped">
            <caption>List of deleted works</caption>
            <thead>
              <tr class="">
                <th scope="col">Client</th>
                <th scope="col" style="width:55%">Work desc.</th>
                <th scope="col">Note</th>
                <th scope="col">Price</th>
                <th scope="col">Outsourced</th>
                <th scope="col">OS price</th>
                <th scope="col">Created</th>
                <th scope="col">Deleted</th>
                <th scope="col" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($works as $work)
                <tr>
                  <td>{{ $work->client }}</td>
                  <td>@markdown($work->description)</td>
                  <td>{{ $work->note }}</td>
                  <td>{{ $work->price }}</td>
                  <td>@if($work->partner) {{ $work->partner->name }} @endif</td>
                  <td>{{ $work->outsourced_price }}</td>
                  <td>{{ $work->created_at}}</td>
                  <td>{{ $work->deleted_at}}</td>
                  <td class="text-center">
                      <a wire:click.prevent="restore({{$work->id}})" class="text-success"><i class="bi bi-arrow-repeat"></i></a>
                      <a wire:click.prevent="forceDelete({{$work->id}})" class="text-danger"><i class="bi bi-x-circle"></i></a>
                  </td>
                </tr>
                @endforeach
            </tbody>
          </table>
    </div>
</div>
