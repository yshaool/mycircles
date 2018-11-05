<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Community;
use App\User;
use App\CommunityMember;
use Image;
use App\Jobs\InviteMembers;
use App\Http\Traits\ExampleTrait;

class CommunityController extends Controller
{
    use ExampleTrait; //sample of using Trait
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
        //InviteMembers::dispatch(); example of use of job
        //$this->sampleTraitFunction();

        $user= User::find(Auth::id());
        return view('home')->with('user', $user);
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
     * Join a Circle using invitation code.
     *

     * @return \Illuminate\Http\Response
     */
    public function join()
    {
        return view('joincircle');
    }

    /**
     * Show Add/Edit Member form and send to it community and if Edit Member
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddEditMemberForm(Request $request)
    {
        $community= Community::find($request->input('cmid'));
        $communityMember= CommunityMember::find($request->input('cmmid'));
        // Verify that user owns the community before allowing it to Add/edit member
        if (!$community->isUserOwner(Auth::id()))
        {
            return redirect('/communities');
        }
        return view('addeditmember',['community'=>$community,'communityMember'=>$communityMember]);
    }

    /**
     * Add/Edit Member from form
     *
     * @return \Illuminate\Http\Response
     */
    public function addMemberFromForm(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email'
        ]);
        // Verify that user owns the community before allowing it to Add/edit member
        $community=Community::find($request->input('community_id'));
        if (!$community->isUserOwner(Auth::id()))
        {
            return redirect('/communities');
        }
        $successMessage="Member Added Successfully!";
        if ($request->input('community_member_id')==0) //add new
        {
            $randomInviteCode=str_random(16).time();
            $community_member=new CommunityMember;
            $community_member->community_id=$request->input('community_id');
            $community_member->email=$request->input('email');
            $community_member->name=$request->input('name');
            $community_member->phone=$request->input('phone');
            $community_member->invite_code=$randomInviteCode;
            $community_member->save();
        }
        else //update exisiting
        {
            $community_member= CommunityMember::find($request->input('community_member_id'));
            $community_member->email=$request->input('email');
            $community_member->name=$request->input('name');
            $community_member->phone=$request->input('phone');
            $community_member->save();
            $successMessage="Member Updated Successfully!";
        }
        return redirect('/communities/'.$request->input('community_id'))->with('success',$successMessage);
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


        $cirlcename=strtolower($request->input('name'));
        $cirlcename = str_replace(" ", "-", $cirlcename);
        $cirlcename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $cirlcename);

        // Create new filename
        $filenameToStore = $cirlcename.'-'.time().'.jpg';

        $path   = $request->file('image');
        // returns Intervention\Image\Image
        $img = Image::make($path)->fit(400)->encode('jpg');
        Storage::put('public/circles/'.$filenameToStore, $img->__toString());


        // Upload Photo
        $community = new Community;
        $community->user_id = Auth::id();
        $community->name = $request->input('name');
        $community->description = $request->input('description');
        $community->image = $filenameToStore;
        $community->save();

        $randomInviteCode=str_random(16).time();
        //Add the user as member of the community
        $user= User::find(Auth::id());
        $community_member=new CommunityMember;
        $community_member->community_id=$community->id;
        $community_member->user_id=$user->id;
        $community_member->email=$user->email;
        $community_member->name=$user->name;
        $community_member->phone=$user->phone;
        $community_member->invite_code=$randomInviteCode;
        $community_member->save();

        $user= User::find(Auth::id());
        return view('/home',['success'=> 'Circle Created', 'user'=>$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $community= Community::find($id);
        //check if user has credential to view this communty (member or owner)
        $user= User::find(Auth::id());

        if ($community->user_id==Auth::id() || $user->communities->contains($community))
            return view('circle')->with('community',$community);
        else
        {
            $community= new Community;
            $community->name="Access denied";
            return view('circle')->with('community',$community);
        }

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
