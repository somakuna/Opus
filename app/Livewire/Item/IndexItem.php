<?php

namespace App\Livewire\Item;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule; 
use Livewire\Component;

class IndexItem extends Component
{
    #[Rule('required', as: 'name')]
    public $name;
    #[Rule('required', as: 'lender')]
    public $lender;
    #[Rule('nullable', as: 'note')]
    public $note;
    #[Rule('required', as: 'date_lended')]
    public $date_lended;

    public Item $item;

    public function mount()
    {
        // Set the default value when the component is mounted
        $this->date_lended = now()->format('Y-m-d');
    }

    public function render()
    {  
        if (! Auth::user())
            abort(403);

        $items = Item::withTrashed()->paginate(20);
        return view('livewire.item.index-item', [
            'items' => $items
        ]);
    }

    public function create()
    {
        if (! Auth::user())
            abort(403);

        $validated = $this->validate();
        Item::create($validated);
        $this->reset();
    }

    public function whatToEdit(Item $item)
    {
        if (! Auth::user())
            abort(403);
        $this->name = $item->name;
        $this->lender = $item->lender;
        $this->note = $item->note;
        $this->date_lended = $item->date_lended->format('Y-m-d');
        $this->item = $item;
    }

    public function store(Item $item)
    {
        if (! Auth::user())
            abort(403);
        $validated = $this->validate();
        $item->update($validated);
        $this->reset();
        // $this->item = '';
    }

    public function delete($id)
    {
        if (! Auth::user())
            abort(403);
       
        $item = Item::find($id)->delete();

    }
    
    public function restore($id)
    {
        if (! Auth::user())
            abort(403);
        $item = Item::where('id', $id)->restore();
    }

    public function destroy($id)
    {
        if (! Auth::user())
            abort(403);
        Item::where('id', $id)->forceDelete();
    }
}
