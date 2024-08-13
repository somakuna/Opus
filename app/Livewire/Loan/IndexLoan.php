<?php

namespace App\Livewire\Loan;

use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\Work;
use App\Models\Loan;
use App\Models\Partner;
use Carbon\Carbon;
use Asantibanez\LivewireCharts\Models\LineChartModel;

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

        // $columnChartModel = $expenses->groupBy('type')
        //     ->reduce(function ($columnChartModel, $data) {
        //         $type = $data->first()->type;
        //         $value = $data->sum('amount');

        //         return $columnChartModel->addColumn($type, $value, $this->colors[$type]);
        //     }, LivewireCharts::columnChartModel()
        //         ->setTitle('Expenses by Type')
        //         ->setAnimated($this->firstRun)
        //         ->withOnColumnClickEventName('onColumnClick')
        //         ->setLegendVisibility(false)
        //         ->setDataLabelsEnabled($this->showDataLabels)
        //         //->setOpacity(0.25)
        //         ->setColors(['#b01a1b', '#d41b2c', '#ec3c3b', '#f66665'])
        //         ->setColumnWidth(90)
        //         ->withGrid()
        //     );


        $partners = Partner::with('loans')->orderBy('name', 'asc')->get();
        if($this->pickedPartnerId)
        {
            $loans = Loan::with('partner')->withTrashed()->where('partner_id', $this->pickedPartnerId)->latest('id')->paginate(20);
            $loans2 = Loan::with('partner')->withTrashed()->where('partner_id', $this->pickedPartnerId)->get();
        }
        else
        {
            $loans = Loan::with('partner')->latest('id')->paginate(20);
            $loans2 = Loan::with('partner')->get();
        }

        $mjeseciImena = collect([
            'Siječanj (1)', 'Veljača (2)' , 'Ožujak (3)',  'Travanj (4)' , 'Svibanj (5)' , 'Lipanj (6)',  'Srpanj (7)',  'Kolovoz (8)' , 'Rujan (9)',  'Listopad (10)', 'Studeni (11)' , 'Prosinac (12)'
        ]);

        $lineChartModel = (new LineChartModel())
            // ->setTitle('Expenses by Type')
            ->setAnimated(true)
            ->setXAxisCategories($mjeseciImena)
            ->setSmoothCurve()
            ->multiLine()
            //->setDataLabelsEnabled(true)
            //->sparklined() // bez grida ispod
            ->withLegend()  
            ->setColors(['#dc3545', '#198754', '#ffc107'])
        ;
        $year = Carbon::now()->year;

        for ($i=1; $i <= 12; $i++)
        {
            $date = Carbon::parse("01-{$i}-{$year}");
            $firstDayInYear = Carbon::parse("01-01-{$year}");
            //$racuni = Racun::whereBetween('datum_izdavanja', [$date->format('Y-m-01 00:00:00'), $date->format('Y-m-t 23:59:59')])->get();
            $outLoans = $loans2->where('method', 'out')->whereBetween('created_at', [$date->format('Y-m-01 00:00:00'), $date->format('Y-m-t 23:59:59')])->sum('amount');
            $inLoans = $loans2->where('method', 'in')->whereBetween('created_at', [$date->format('Y-m-01 00:00:00'), $date->format('Y-m-t 23:59:59')])->sum('amount');
            $lineChartModel->addSeriesPoint('Out', $mjeseciImena[$i-1], $outLoans);
            $lineChartModel->addSeriesPoint('In', $mjeseciImena[$i-1], $inLoans);
            $lineChartModel->addSeriesPoint('Balance', $mjeseciImena[$i-1], $inLoans-$outLoans);
            //$lineChartModel->addSeriesPoint('Out', $loan2->created_at->format('d.m.y.'), $loan2->amount);
        }
        $lineChartModel->setJsonConfig([
            'grid.column.colors' => ['#f1f1f1', '#fbfbfb'],
            'tooltip.theme' => ['light'],

        ]);

        return view('livewire.loan.index-loan', [
            'partners' => $partners,
            'loans' => $loans,
            'lineChartModel' => $lineChartModel,
        ]);
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
