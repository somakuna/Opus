<?php

namespace App\Http\Controllers;

use App\Models\Circular;

class CircularController extends Controller
{
    public function index()
    {
        return view('circular.index');
    }

    public function create()
    {
        return view('circular.create');
    }

    public function edit(Circular $circular)
    {
        return view('circular.edit', compact('circular'));
    }
}
