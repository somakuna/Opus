<?php

namespace App\Http\Controllers;

use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        return view('expense.index');
    }

    public function create()
    {
        return view('expense.create');
    }

    public function edit(Expense $expense)
    {
        return view('expense.edit', compact('expense'));
    }
}
