<?php

namespace App\Http\Controllers;

use App\Exceptions\ClubDatabaseProvisionerException;
use App\Models\Billiard;
use App\Models\Rate;
use App\Services\ClubDatabaseProvisioner;
use Illuminate\Http\Request;

class BilliardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $billiards = Billiard::all();
        return view('billiards.index', [
            'billiards' => $billiards
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $billiard = Billiard::findOrFail($id);
        $rates=Rate::where('billiard_id',$id)->get();
        $rate_not_bar=Rate::where('billiard_id',$id)->where('isBar',0)->first();
        $rate_with_bar=Rate::where('billiard_id',$id)->where('isBar',1)->first();
        $valuta = config('valuta');
        return view('billiards.edit', [
            'billiard' => $billiard,
            'rates' =>$rates,
            'valuta' => $valuta,
            'rate_not_bar'=>$rate_not_bar,
            'rate_with_bar'=>$rate_with_bar,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $billiard = Billiard::findOrFail($id);

        $billiard->name = $request->name;
        $billiard->date_end = $request->date_end;
        $billiard->valuta = $request->valuta;
        $billiard->comment = $request->comment;
        $billiard->save();

        if(!$request->has('billiard_rate')){
            Rate::where('billiard_id',$billiard->id)->delete();
        }
        return back()->with('success', __('billiard.updated'));
    }

    public function billiard_rates(Request $request)
    {
        $billiard_id=$request->billiard_id;
        $billiard=Billiard::find($billiard_id);

        if($request->has('rate_not_bar_id')){

            Rate::where('id', $request->rate_not_bar_id)->update([
                'title'=>$request->title,
                'month'=>$request->month,
                'year'=>$request->year,
                'valuta'=>$billiard->valuta,
            ]);

            Rate::where('id', $request->rate_with_bar_id)->update([
                'title'=>$request->title_bar,
                'month'=>$request->month_bar,
                'year'=>$request->year_bar,
                'valuta'=>$billiard->valuta,
            ]);
            return back()->with('success', __('rates.updated_billiard'));
        }else{
            Rate::create([
                'title'=>$request->title,
                'isBar'=>0,
                'month'=>$request->month,
                'year'=>$request->year,
                'valuta'=>$billiard->valuta,
                'billiard_id'=>$request->billiard_id,
            ]);
            Rate::create([
                'title'=>$request->title_bar,
                'isBar'=>1,
                'month'=>$request->month_bar,
                'year'=>$request->year_bar,
                'valuta'=>$billiard->valuta,
                'billiard_id'=>$request->billiard_id,
            ]);
            return back()->with('success', __('rates.added_billiard'));
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Billiard $billiard, ClubDatabaseProvisioner $provisioner)
    {
        abort_unless(
            (int) $billiard->isFree === 1,
            403,
            __('billiard.delete_not_allowed')
        );

        try {
            $provisioner->delete($billiard);
        } catch (ClubDatabaseProvisionerException $exception) {
            report($exception);

            return back()->with('error', __('billiard.delete_failed'));
        }

        // The provisioner normally removes this billing record itself.
        // Deleting the stale model is a safe local fallback and is a no-op
        // when the row has already been removed by the provisioner.
        $billiard->delete();

        return redirect()
            ->route('billiards.index')
            ->with('success', __('billiard.deleted'));
    }
}
