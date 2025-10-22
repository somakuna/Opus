<?php

namespace App\Livewire\Note;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule; 
use App\Models\Note;

class IndexNote extends Component
{
    #[Rule('required', as: 'Text')]
    public $text;
    public Note $note;

    public function render()
    {  
        if (! Auth::user())
            abort(403);

        $notes = Note::latest('id')->get();
        return view('livewire.note.index-note', [
            'notes' => $notes
        ]);
    }

    public function create()
    {
        if (! Auth::user())
            abort(403);

        $validated = $this->validate();
        Note::create($validated);
    }

    public function whatToEdit(Note $note)
    {
        if (! Auth::user())
            abort(403);
        $this->text = $note->text;
        $this->note = $note;
    }

    public function store(Note $note)
    {
        if (! Auth::user())
            abort(403);
        $validated = $this->validate();
        
        $note->update($validated);
        $this->reset();
        // $this->note = '';
    }

    public function delete($id)
    {
        if (! Auth::user())
            abort(403);
       
        Note::find($id)->delete();

    }


}
