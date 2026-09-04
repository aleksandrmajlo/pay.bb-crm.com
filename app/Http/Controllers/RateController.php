<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rates = Rate::all();
        $valuta = config('valuta');
        return view('rates.index', [
            'rates' => $rates,
            'valuta' => $valuta
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rate = new  Rate;
        $rate->title = $request->title;
        $rate->valuta = $request->valuta;
        $rate->isBar = $request->isBar;
        $rate->month = $request->month;
        $rate->year = $request->year;
        $rate->save();

        return back()->with('success', __('rates.added'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rate = Rate::findOrFail($id);
        $valuta = config('valuta');
        return view('rates.edit', [
            'rate' => $rate,
            'valuta' => $valuta
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rate =Rate::findOrFail($id);
        $rate->title = $request->title;
        $rate->valuta = $request->valuta;
        $rate->isBar = $request->isBar;
        $rate->month = $request->month;
        $rate->year = $request->year;
        $rate->save();

        return back()->with('success', __('rates.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $rate = Rate::findOrFail($id);
        $rate->delete();
        return back()->with('success', __('rates.delete'));
    }
}
