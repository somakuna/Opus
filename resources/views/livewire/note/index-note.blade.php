<div class="row g-4">
    <!-- Left Column: Form -->
    <div class="col-md-5">
      <div class="form-floating mb-3">
        <form>
        <textarea wire:model="text" class="form-select @error('text') is-invalid @enderror" placeholder="Leave a text here" style="height: 500px"></textarea>
        </form> 
      </div>
      <div class="text-end"> 
        @if (!$note)
          <a wire:click.prevent="create" class="btn btn-primary"><i class="bi bi-floppy"></i> Save</a>
        @else
          <a wire:click.prevent="store({{$note}})" class="btn btn-success"><i class="bi bi-floppy"></i> Edit</a>
        @endif
      </div>
    </div>
    <div class="col-md-7">
      <div class="row g-3">
        @foreach ($notes as $note)
        <div class="col-12 border rounded p-3 shadow bg-white">
            <div>@markdown($note->text)</div>
            <div class="w-100 text-end">
              <span class="text-secondary" style="font-size: 8pt">Created: {{$note->created_at->format('d.m.Y. H:i')}} / Updated: {{$note->updated_at->format('d.m.Y. H:i')}} /</span>
              <a wire:click.prevent="whatToEdit({{$note}})" class="text-secondary"><i class="bi bi-pen"></i></a>
              <a wire:click.prevent="delete({{ $note->id }})" wire:confirm="Are you sure you want to delete?" class="text-secondary"><i class="bi bi-trash"></i></a> 
            </div>
        </div>
        @endforeach
      </div>
    </div>
</div>