<?php

namespace App\Http\Controllers;

use App\Models\Billiard;
use App\Models\Consumer;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class   ConsumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('billiard_id')) {
            $billiard_id = $request->billiard_id;
            $billiard = Billiard::findOrFail($billiard_id);

            config(['database.connections.mysql.database' => $billiard->idd]);
            DB::purge('mysql');
            DB::reconnect('mysql');

            $users = Consumer::orderBy('id','desc')->paginate(15)->withQueryString();
            return view('consumers.index', [
                'title' => $billiard->idd,
                'users' => $users,
                'billiard_id' => $billiard_id,
                'billiard' => $billiard,
            ]);
        } else {
            abort(404);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->has('billiard_id')) {
            $billiard_id = $request->billiard_id;
            $billiard = Billiard::findOrFail($billiard_id);
            config(['database.connections.mysql.database' => $billiard->idd]);
            DB::purge('mysql');
            DB::reconnect('mysql');

            $roles=Role::all();
            $locales=config('locales_billiards');

            return view('consumers.create',[
                'roles'=>$roles,
                'billiard'=>$billiard,
                'locales'=>$locales
            ]);

        }else {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('billiard_id')) {
            $billiard_id = $request->billiard_id;
            $billiard = Billiard::findOrFail($billiard_id);
            config(['database.connections.mysql.database' => $billiard->idd]);
            DB::purge('mysql');
            DB::reconnect('mysql');

            $validated = $request->validate([
                'phone' => ['required', 'unique:users'],
            ]);

            $phone = $request->phone;
            $user = new Consumer;
            $user->name = $request->name;
            $user->phone = $phone;
            $user->sklad = $request->sklad;
            $user->status = $request->status;
            $user->order_history = $request->order_history;
            if($request->has('view')){
                $user->view = $request->view;
            }

            if($request->has('barmen_view')){
                $user->barmen_view=$request->barmen_view;
            }
            $user->save();

            $role = Role::find($request->role_id);
            $user->roles()->attach($role);
            return redirect('/consumers?billiard_id='.$billiard_id)->with('success', __('site.user_add'));

        }else {
            abort(404);
        }
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
    public function edit(string $id, Request $request)
    {

        if ($request->has('billiard_id')) {
            $billiard_id = $request->billiard_id;
            $billiard = Billiard::findOrFail($billiard_id);
            config(['database.connections.mysql.database' => $billiard->idd]);
            DB::purge('mysql');
            DB::reconnect('mysql');

            $user=Consumer::findOrFail($id);
            $roles=Role::all();
            $locales=config('locales_billiards');
            return view('consumers.edit',[
                'user'=>$user,
                'roles'=>$roles,
                'billiard'=>$billiard,
                'locales'=>$locales
            ])  ;

        }else {
            abort(404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->has('billiard_id')) {
            $billiard_id = $request->billiard_id;
            $billiard = Billiard::findOrFail($billiard_id);
            config(['database.connections.mysql.database' => $billiard->idd]);
            DB::purge('mysql');
            DB::reconnect('mysql');

            $user = Consumer::findOrFail($id);

            $user->name = $request->name;
            $user->phone = $request->phone;;
            $user->status = $request->status;
            $user->sklad = $request->sklad;
            $user->order_history = $request->order_history;
            if($request->has('view')){
                $user->view = $request->view;
            }
            if($request->has('barmen_view')){
                $user->barmen_view=$request->barmen_view;
            }
            $user->lang = $request->lang;
            $user->save();
            $user->roles()->sync($request->role_id);
            return back()->with('success', __('consumers.updated'));

        }else {
            abort(404);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id,Request $request)
    {
        if ($request->has('billiard_id')) {
            $billiard_id = $request->billiard_id;
            $billiard = Billiard::findOrFail($billiard_id);
            config(['database.connections.mysql.database' => $billiard->idd]);
            DB::purge('mysql');
            DB::reconnect('mysql');

            $user = Consumer::findOrFail($id);
            $user->delete();
            return back()->with('success', __('consumers.deleted'));

        }else {
            abort(404);
        }
    }

    public function consumers_unique(Request $request){

        $billiard_id = $request->billiard_id;
        $billiard = Billiard::findOrFail($billiard_id);
        config(['database.connections.mysql.database' => $billiard->idd]);
        DB::purge('mysql');
        DB::reconnect('mysql');

        $phone = $request->phone;
        $user = Consumer::where('phone', $phone)->first();
        if ($user) {
            return response()->json([
                'suc' => false,
            ], 200);
        } else {
            return response()->json([
                'suc' => true,
            ], 200);
        }
    }
}
