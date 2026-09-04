<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use App\Services\LanguageService;
use Illuminate\Http\Request;

class LangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $langs=Lang::all();
        return view('langs.index',compact('langs'));
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

        $lang = new Lang();
        $lang->name = $request->name;
        $lang->slug = $request->slug;
        $lang->save();
        LanguageService::updateTagsTable();
        return back()->with('success', 'Lang Created Successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lang = Lang::findOrFail($id);
        $slug=$lang->slug;
        $lang->delete();
        LanguageService::deleteLanguageColumn($slug);
        return back()->with('success', 'Lang Deleted Successfully');
    }
}
