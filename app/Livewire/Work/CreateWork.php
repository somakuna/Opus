<?php

namespace App\Livewire\Work;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule; 
use Livewire\Component;
use App\Models\Work;
use App\Models\Partner;

class CreateWork extends Component
{
    public $client;
    public $priority = 1;
    public $source = 'Walk in';
    public $description;
    public $note;
    public $price = 0;
    public $payment_method = 'Cash';
    public $outsourced = 0;
    public $loan_id = 0;
    public $design = 0;
    public $ready = 0;
    public $delivered = 0;
    public $paid = 0;
    public $outsourced_price;
    public $partner_id;

    protected $rules = [
        'client'           => 'required|string|max:255',
        'priority'         => 'required|integer|min:0',
        'source'           => 'required|string|max:255',
        'description'      => 'required|string',
        'note'             => 'nullable|string',
        'price'            => 'nullable|numeric|min:0',
        'payment_method'   => 'required|string|max:255',
        'outsourced'       => 'nullable|boolean',
        'loan_id'          => 'nullable|integer',
        'design'           => 'nullable|boolean',
        'ready'            => 'nullable|boolean',
        'delivered'        => 'nullable|boolean',
        'paid'             => 'nullable|boolean',
        'outsourced_price' => 'required_with:partner_id|numeric|min:0',
        'partner_id'       => 'nullable|integer|exists:partners,id',
    ];

    protected $validationAttributes = [
        'client'           => 'Client name',
        'priority'         => 'Priority',
        'source'           => 'Source',
        'description'      => 'Description',
        'note'             => 'Note',
        'price'            => 'Price',
        'payment_method'   => 'Payment Method',
        'outsourced'       => 'Outsource',
        'design'           => 'Design',
        'ready'            => 'Ready',
        'delivered'        => 'Delivered',
        'paid'             => 'Paid',
        'outsourced_price' => 'Outsourced price',
        'partner_id'       => 'Partner',
    ];

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
        unset($validated['loan_id']); // remove it
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
