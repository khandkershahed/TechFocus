<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banking;

use App\Models\Country;
use Illuminate\Http\Request;

class BankingController extends Controller
{
    public function index()
    {
        $bankings = Banking::with([ 'country'])->get();
        return view('admin.bankings.index', compact('bankings'));
    }

    public function create()
    {
       
        $countries = Country::all();
        return view('admin.bankings.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'date' => 'required|date',
            'deposit' => 'nullable|numeric',
            'withdraw' => 'nullable|numeric',
        ]);

        Banking::create($request->all());

        return redirect()->route('admin.bankings.index')
            ->with('success', 'Banking transaction created successfully.');
    }

    public function show(Banking $banking)
    {
        return view('admin.bankings.show', compact('banking'));
    }

    public function edit(Banking $banking)
    {
        
        $countries = Country::all();
        return view('admin.bankings.edit', compact('banking','countries'));
    }

    public function update(Request $request, Banking $banking)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'date' => 'required|date',
            'deposit' => 'nullable|numeric',
            'withdraw' => 'nullable|numeric',
        ]);

        $banking->update($request->all());

        return redirect()->route('admin.bankings.index')
            ->with('success', 'Banking transaction updated successfully.');
    }

    public function destroy(Banking $banking)
    {
        $banking->delete();

        return redirect()->route('admin.bankings.index')
            ->with('success', 'Banking transaction deleted successfully.');
    }
}