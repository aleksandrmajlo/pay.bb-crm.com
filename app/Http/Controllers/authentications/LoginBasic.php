<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class LoginBasic extends Controller
{
  public function index(Request $request)
  {
      if($request->has('custom_token')){
          $receivedToken = $request->custom_token;
          $user=DB::table('users')->where('custom_token',$receivedToken)->first();
          if($user){
              Auth::loginUsingId($user->id,true);
              return redirect('/billiards');
          }else{
              return redirect()->route('logout');
          }

      }else{
          return redirect()->route('logout');
      }
  }
}
