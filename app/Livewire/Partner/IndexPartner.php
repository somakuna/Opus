<?php

namespace App\Livewire\Partner;

use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\Work;
use App\Models\Loan;
use App\Models\Partner;


class IndexPartner extends Component
{
    public $partner;

    protected $rules = [
        'partner.name' => 'required',
        'partner.email' => 'required|email',
    ];

    public function mount()
    {
        $this->partner = new Partner();
    }

    public function render()
    {
        if (! Auth::user())
            abort(403);
        return view('livewire.partner.index-partner', [
            'partners' => Partner::orderBy('name')->get(),
        ]);
    }

    public function savePartner()
    {
        if (! Auth::user())
            abort(403);
        $validated = $this->validate();
        
        if ($this->partner->id) {
            $this->partner->save();
        } else {
            Partner::create($validated['partner']);
        }
        $this->reset();
    }

    public function deletePartner($partnerId)
    {
        if (! Auth::user())
            abort(403);
        
        $partner = Partner::find($partnerId);
        if ($partner->loans || $partner->works)
            return 0;
        $partner->delete();
    }

    public function softDeleteAllPartnerLoans($id)
    {
        if (! Auth::user())
            abort(403);

        Loan::where('partner_id', $id)->delete();
    }

    public function forceDeleteAllPartnerLoans($id)
    {
        if (! Auth::user())
            abort(403);

        Loan::where('partner_id', $id)->forceDelete();
    }

    public function editPartner($partnerId)
    {
        if (! Auth::user())
            abort(403);
        $this->partner = Partner::find($partnerId);
    }

    public function resetForm()
    {
        if (! Auth::user())
            abort(403);
        $this->partner = new Partner();
    }
}