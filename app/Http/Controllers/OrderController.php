<?php

namespace App\Http\Controllers;

use App\Models\Billiard;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title_billiard=__('site.all');
        if($request->has('billiard_id')){
            $orders=Order::orderBy('id','desc')->where('billiard_id',$request->billiard_id)->paginate(15)->withQueryString();
            $billiard=Billiard::findOrFail($request->billiard_id);
            $title_billiard=$billiard->idd;
        }else{
            $orders=Order::orderBy('id','desc')->paginate(15)->withQueryString();
        }

        return view('orders.index',[
          'orders'=>$orders,
            'title_billiard'=>$title_billiard
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
       $order=Order::findOrfail($id);
       $user_name='';
       $user=\DB::connection($order->billiards)->table('users')->find($order->user_id);
       if($user){
           $user_name=  $user->name;
       }
       return view('orders.show',[
           'order'=>$order,
           'user_name' =>$user_name
       ]);
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
        $rate = Order::findOrFail($id);
        $rate->delete();
        return back()->with('success', __('order.delete'));
    }

    public function order_status(Request $request){
        $order_id=$request->order_id;
        $order=Order::find($order_id);
        if($order){
            $month = $order->month;
            $billiards = $order->billiards;
            $billiards_table=\DB::table('billiards')->where('idd', $billiards)->first();
            $date_end = $billiards_table->date_end;
            $date_end_car = Carbon::createFromFormat('Y-m-d', $date_end);
            $newDate_end = $date_end_car->addMonths($month);

            \DB::table('billiards')->where('idd', $billiards)
                ->update([
                    'date_end' => $newDate_end->format('Y-m-d'),
                    'updated_at' => now()
                ]);
            $order->paid=1;
            $order->save();

        }

        return back()->with('success', __('order.updated'));
    }
}
