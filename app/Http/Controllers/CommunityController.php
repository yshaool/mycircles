<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Community;

class CommunityController extends Controller
{
    /**
     * Instantiate a new CommunityController instance.
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
        return view('createcircle');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'name' => 'required',
        'image' => 'image|max:1999'
        ]);

        // Get filename with extension
        //$filenameWithExt = $request->file('image')->getClientOriginalName();

        // Get just the filename
        //$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        $imagename=strtolower($request->input('name'));
        $imagename = str_replace(" ", "-", $imagename);
        $imagename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $imagename);

        // Get extension
        $extension = $request->file('image')->getClientOriginalExtension();

        // Create new filename
        $filenameToStore = $imagename.'_'.time().'.'.$extension;

        // Uplaod image
        $path= $request->file('image')->storeAs('circles/', $filenameToStore);

        // Upload Photo
        $community = new Community;
        $community->user_id = Auth::id();
        $community->name = $request->input('name');
        $community->description = $request->input('description');
        $community->image = $filenameToStore;

        $community->save();
        return redirect('/home')->with('success', 'Circle Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
