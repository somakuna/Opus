<?php

namespace App\Livewire\Work;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule; 
use Livewire\Component;
use App\Models\Work;
use App\Models\Partner;

class CreateWork extends Component
{
    #[Rule('required', as: 'Client name')]
    public $client;
    #[Rule('required', as: 'Priority')]
    public $priority = '1';
    #[Rule('required', as: 'Source')]
    public $source = 'Walk in';
    #[Rule('required', as: 'Description')]
    public $description;
    #[Rule('sometimes', as: 'Note')]
    public $note;
    #[Rule('sometimes', as: 'Price')]
    public $price = 0;
    #[Rule('required', as: 'Payment Method')]
    public $payment_method = 'Cash';
    #[Rule('sometimes', as: 'Outsoruce')]
    public $outsourced = 0;
    public $loan_id = 0;
    #[Rule('sometimes', as: 'Design')]
    public $design = 0;
    #[Rule('sometimes', as: 'Ready')]
    public $ready = 0;
    #[Rule('sometimes', as: 'Delivered')]
    public $delivered = 0;
    #[Rule('sometimes', as: 'Paid')]
    public $paid = 0;
    #[Rule('required_with:partner_id', as: 'Outsourced price')]
    public $outsourced_price;
    #[Rule('sometimes', as: 'Partner')]
    public $partner_id;

    public function render()
    {
        if (! Auth::user())
            abort(403);
        return view('livewire.work.create-work')->with([
            'partners' => Partner::get(),
        ]);
    }

    public function create()
    {
        if (! Auth::user())
            abort(403);
        $validated = $this->validate();
        $work = Work::create($validated);
        if($this->loan_id) {
            $work->loan()->create([
                'method' => 'out',
                'amount' => $work->outsourced_price,
                'description' => $work->client,
                'partner_id' => $work->partner_id,
            ]);
        }
        return redirect()->to('/work');
        //dd($this->client);
    }
}
