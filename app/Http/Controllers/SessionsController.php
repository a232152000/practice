<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email' => 'required|email|max:255',
           'password' => 'required'
        ]);

        if(Auth::attempt($credentials, $request->has('remember'))){
            session()->flash('success', '歡迎回來！');
            return redirect()->route('users.show', [Auth::user()]);
        }else{
            session()->flash('danger', '很抱歉，您的信箱或密碼錯誤');
            return redirect()->back()->withInput();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '成功推出！');
        return redirect('login');
    }
}
