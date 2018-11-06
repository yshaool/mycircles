<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Community;
use App\User;
use App\CommunityMember;
class CommunityMemberController extends Controller
{
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
    public function create(Request $request)
    {
        $community= Community::find($request->input('cmid'));
        $communityMember= CommunityMember::find(0);
        // Verify that user owns the community before allowing it to Add/edit member
        if (!$community->isUserOwner(Auth::id()))
        {
            return redirect('/communities');
        }
        return view('addeditmember',['community'=>$community,'communityMember'=>$communityMember,'actionTitle'=>'Add']);
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
    public function edit(Request $request,$id)
    {
        $community= Community::find($request->input('cmid'));
        $communityMember= CommunityMember::find($id);
        // Verify that user owns the community before allowing it to Add/edit member
        if (!$community->isUserOwner(Auth::id()))
        {
            return redirect('/communities');
        }
        return view('addeditmember',['community'=>$community,'communityMember'=>$communityMember,'actionTitle'=>'Edit']);
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
    public function destroy(Request $request,$id)
    {
        $community= Community::find($request->input('cmid'));
        $communityMember= CommunityMember::find($id);
        // Verify that user owns the community before allowing it to Add/edit member
        if (!$community->isUserOwner(Auth::id()) || $communityMember->community->id!=$request->input('cmid'))
        {
            return redirect('/communities');
        }
        $communityMember->delete();
        return redirect('/communities/'.$request->input('cmid'))->with('success','Member deleted successfully!');
    }
}
