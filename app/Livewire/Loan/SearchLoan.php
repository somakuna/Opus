<?php

namespace App\Livewire\Loan;

use App\Models\Loan;
use App\Models\Partner;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Rule; 
use Livewire\Component;
use Livewire\WithPagination;

class SearchLoan extends Component
{
    use WithPagination;

    #[Rule('', as: 'Partner')]
    public $partner_id;
    #[Rule('required', as: 'Description')]
    public $description;
    public $pickedPartnerId = false;

    public function render()
    {
        $partners = Partner::with('loans')->orderBy('name', 'asc')->get();
        if ($this->pickedPartnerId) {
            $loans = Loan::with('partner')
                ->withTrashed()
                ->where('partner_id', $this->pickedPartnerId)
                ->where('description', 'like', '%' . $this->description . '%')
                ->latest('id')
                ->paginate(20);
            
            $totalIn = Loan::with('partner')
                        ->withTrashed()
                        ->where('partner_id', $this->pickedPartnerId)
                        ->where('description', 'like', '%' . $this->description . '%')
                        ->where('method', 'in')
                        ->sum('amount');

            $totalOut = Loan::with('partner')
                        ->withTrashed()
                        ->where('partner_id', $this->pickedPartnerId)
                        ->where('description', 'like', '%' . $this->description . '%')
                        ->where('method', 'out')
                        ->sum('amount');

        } else {
            $loans = Loan::with('partner')
                ->where('description', 'like', '%' . $this->description . '%')
                ->paginate(20);

            $totalIn = Loan::with('partner')
                ->where('description', 'like', '%' . $this->description . '%')
                ->where('method', 'in')
                ->sum('amount');

            $totalOut = Loan::with('partner')
                ->where('description', 'like', '%' . $this->description . '%')
                ->where('method', 'out')
                ->sum('amount');
        }
                
        return view('livewire.loan.search-loan', [
            'partners' => $partners,
            'loans' => $loans,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
        ]);
    }

    public function search()
    {
        if (! Auth::user())
            abort(403);
        $validated = $this->validate();
        //dd($this->description);
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
        $this->resetPage();
    }
}
