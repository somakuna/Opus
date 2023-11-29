<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Loan;

class LoanController extends Controller
{

    public function index()
    {
        return view('loan.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
