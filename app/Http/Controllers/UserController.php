<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use Auth;
use Image;
class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user= User::find($id);
        return view('user')->with('user',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user= User::find($id);
        return view('user-edit')->with('user',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editUsername($id)
    {
        $user= User::find($id);
        return view('username-edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUsername(Request $request, $id)
    {
        $user= User::find($id);

        //make sure user is authorised for this action
        if ($user->id!=Auth::id())
             redirect('/users/',Auth::id())->with('error','You do not have access to update this user.');

        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users'
        ]);

        $user->email = $request->input('email');
        $user->save();

        return redirect('/users/'.$user->id)->with('success','Username Updated');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user= User::find($id);


        //make sure user is authorised for this community
        if ($user->id!=Auth::id())
             redirect('/users/',Auth::id())->with('error','You do not have access to update this user.');


        $this->validate($request, [
            'name' => 'required|string|max:255'
        ]);


        if ($request->file('image'))
        {
            $username=strtolower($request->input('name'));
            $username = str_replace(" ", "-", $username);
            $username = preg_replace('/[^a-zA-Z0-9-_\.]/','', $username);

            $filenameToStore = $username.'-'.time().'.jpg';

            $path   = $request->file('image');

            $img = Image::make($path)->fit(300)->encode('jpg');
            Storage::put('public/users/'.$filenameToStore, $img->__toString());
            if ($user->image!="")
                Storage::delete('public/users/'.$user->image);
            $user->image=$filenameToStore;
        }

        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->profession = $request->input('profession');
        $user->services = $request->input('services');

        $user->save();

        return redirect('/users/'.$user->id)->with('success','User Updated');
    }

/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPassword($id)
    {
        $user= User::find($id);
        return view('password-edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id)
    {
        $user= User::find($id);

        //make sure user is authorised for this action
        if ($user->id!=Auth::id())
             redirect('/users/',Auth::id())->with('error','You do not have access to update this user.');

        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed',
            'newpassword' => 'required|string|min:6|confirmed'
        ]);

        //$user->email = $request->input('email');
        $user->save();

        return redirect('/users/'.$user->id)->with('success','Password Updated');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
