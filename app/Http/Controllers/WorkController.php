<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Support\Facades\View;

class WorkController extends Controller
{
    public function index()
    {
        // $works = Work::with('partner')->get();
        return view('work.index');
    }

    public function create()
    {
        return view('work.create');
    }

    public function store(StoreWorkRequest $request)
    {
        //
    }

    public function show(Work $work): View
    {
        //
    }

    public function edit(Work $work)
    {
        //return view('work.edit', compact('work')); 

        return view('work.edit', compact('work'));
    }

    public function print(Work $work)
    {
        return view('work.print', [
            'work' => $work
        ]);
    }

    public function showDeleted()
    {
        return view('work.show-deleted');
    }

    public function update(UpdateWorkRequest $request, Work $work)
    {
        //
    }

    public function destroy(Work $work)
    {
        //
    }
}
