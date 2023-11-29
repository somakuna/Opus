<?php

namespace App\Livewire\Loan;

use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\Work;
use App\Models\Loan;
use App\Models\Partner;

class IndexLoan extends Component
{
    use WithPagination;

    #[Rule('required', as: 'Partner')]
    public $partner_id;
    #[Rule('required', as: 'Price amount')]
    public $amount;
    #[Rule('required', as: 'Description')]
    public $description;
    #[Rule('', as: 'Method')]
    public $method;

    public $pickedPartnerId = false;

    public function render()
    {
        $partners = Partner::with('loans')->orderBy('name', 'asc')->get();
        if($this->pickedPartnerId)
            $loans = Loan::with('partner')->withTrashed()->where('partner_id', $this->pickedPartnerId)->latest('id')->paginate(20);
        else
            $loans = Loan::with('partner')->latest('id')->paginate(20);

        return view('livewire.loan.index-loan', [
            'partners' => $partners,
            'loans' => $loans,
        ]);

        //return view('livewire.loan.index-loan');
    }

    public function create($method)
    {
        if (! Auth::user())
            abort(403);

        $this->method = $method;
        $validated = $this->validate();
        $this->pickedPartnerId = null;
        Loan::create($validated);
        $this->reset();
    }

    public function delete($id)
    {
        if (! Auth::user())
            abort(403);

        $loan = Loan::withTrashed()->findOrFail($id);
        $loan->delete();
    }

    public function destroy($id)
    {
        if (! Auth::user())
            abort(403);

        Loan::withTrashed()->find($id)->forceDelete();
    }

    public function restore($id)
    {
        if (! Auth::user())
            abort(403);
        
        Loan::withTrashed()->find($id)->restore();
    }

    public function filterLoansByClient($id)
    {
        if (! Auth::user())
            abort(403);
        $this->pickedPartnerId = $id;
    }
}
