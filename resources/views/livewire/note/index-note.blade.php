<div class="row g-3">
    <!-- Left Column: Editor -->
    <div class="col-md-5">
      <div class="panel">
        <h5 class="panel-title"><i class="bi bi-journal-text"></i> {{ $note ? 'Edit note' : 'New note' }}</h5>
        <form>
          <textarea wire:model="text" class="form-control @error('text') is-invalid @enderror" placeholder="Write your note here..." style="height: 400px; resize: vertical;"></textarea>
        </form>
        <div class="text-end mt-3">
          @if (!$note)
            <a wire:click.prevent="create" class="btn btn-primary"><i class="bi bi-floppy"></i> Save</a>
          @else
            <a wire:click.prevent="store({{$note}})" class="btn btn-success"><i class="bi bi-floppy"></i> Update</a>
          @endif
        </div>
      </div>
    </div>

    <!-- Right Column: Notes list -->
    <div class="col-md-7">
      @foreach ($notes as $note)
      <div class="note-card">
          <div class="note-content">@markdown($note->text)</div>
          <div class="note-meta">
            <span>Created: {{ $note->created_at->format('d.m.Y. H:i') }} &middot; Updated: {{ $note->updated_at->format('d.m.Y. H:i') }}</span>
            <span class="d-flex gap-1">
              <a wire:click.prevent="whatToEdit({{$note}})" class="action-btn"><i class="bi bi-pencil"></i></a>
              <a wire:click.prevent="delete({{ $note->id }})" wire:confirm="Are you sure you want to delete?" class="action-btn"><i class="bi bi-trash3"></i></a>
            </span>
          </div>
      </div>
      @endforeach
    </div>
</div>
