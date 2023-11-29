<?php

namespace App\Livewire\Work;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule; 
use Livewire\Component;
use App\Models\Work;
use App\Models\Loan;
use App\Models\Partner;

class EditWork extends Component
{
    public Work $work;
    public $loan_id;

    protected array $rules = [
        'work.client' => 'required',
        'work.priority' => 'required',
        'work.description' => 'required',
        'work.note' => '',
        'work.price' => '',
        'work.payment_method' => 'required',
        'work.outsourced' => '',
        'work.design' => '',
        'work.ready' => '',
        'work.delivered' => '',
        'work.paid' => '',
        'work.outsourced_price' => 'required_with:work.partner_id',
        'work.partner_id' => '',
    ];

    public function mount(Work $work)
    {
        $this->work = $work;
    }

    public function render()
    {
        if (! Auth::user())
            abort(403);
        return view('livewire.work.edit-work')->with([
            'partners' => Partner::get(),
        ]);
    }

    public function update()
    {
        if (! Auth::user())
            abort(403);

        $validated = $this->validate();
        $this->work->save($validated);
        // $this->work->save();
        if($this->loan_id) {
            $this->work->loan()->create([
                'method' => 'out',
                'amount' => $this->work->outsourced_price,
                'description' => $this->work->client,
                'partner_id' => $this->work->partner_id,
            ]);
        }

        return redirect()->to('/work');
    }

    public function deleteLoan()
    {
        if (! Auth::user())
            abort(403);
        $this->work->loan()->forceDelete();
        $this->work->refresh();
    }
}
