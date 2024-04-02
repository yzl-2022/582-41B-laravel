<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id','name')
                ->orderby('name')
                ->paginate(10);
        //return view('user.index', ["users" => $users]);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:20'
        ]);
    
        $user = new User;
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
    
        return redirect(route('user.index'))->withSuccess('User created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function forgot(){
        return view('user.forgot');
    }

    public function email(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);
        $user = User::where('email', $request->email)->first();
        $userId = $user->id;
        $tempPassword = str::random(45);
        $user->temp_password =  $tempPassword;
        $user->save();
            
        $to_name = $user->name;
        $to_email = $request->email;
        $body="<a href='".route('user.reset', [$userId,$tempPass])."'>Click here to reset  your password</a>";
    
        Mail::send('user.mail', ['name'=>$to_name,'body' => $body],
            function($message) use ($to_email)
            {
               $message->to($to_email)->subject('Reset Password');
            });
       return redirect(route('login'))->withSuccess('Please check your email to reset your password!');   
    }

    public function reset(User $user, $token)
    {
        if ($user->temp_password === $token) {

            return view ('user.reset');
        }
        return redirect(route('user.forgot'))->withErrors('Credentials does not match');   
    }

    public function resetUpdate(User $user, $token, Request $request)
    {
        if ($user->temp_password === $token) {
            $request->validate([
                'password' => 'required|min:6|confirmed',
            ]);
            $user->password = Hash::make($request->password);
            $user->temp_password = NULL;
            $user->save();
            return redirect(route('login'))->withSuccess('Password changed with success');  
        }
        return redirect(route('user.forgot'))->withErrors('Credentials does not match');   
    }
}
