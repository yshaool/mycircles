<?php
namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Auth;
use App\Community;
use App\User;
use App\CommunityMember;
use Image;
use App\Jobs\InviteMembers;
use App\Http\Traits\DbFieldGuesserTrait;
use App\Mail\MemberInvite;
use App\Exports\CommunityMemberExport;
use App\Imports\CommunityMemberImport;

class CommunityController extends Controller
{
    use DbFieldGuesserTrait; //sample of using Trait
    /**
     * Instantiate a new CommunityController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['joinFromEmailLink']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //InviteMembers::dispatch(); example of use of job

        //<input type="hidden" name="invite_code" value="{{ old('invite_code') }}">
        $user= User::find(Auth::id());

        if (session()->has('invite_code')) {
            session()->forget('invite_code');
            $community_member=CommunityMember::where('invite_code',  session()->get('invite_code'))->first();
            if ($community_member)
            {
                $community_member->user_id=$user->id;
                $community_member->save();
                return redirect('/communities')->with('success','You joined a circle!');
            }
            else
            {
                return redirect('/communities')->with('error','Code is incorrect! Please verify you copy with no spaces.');
            }
        }
        return view('home')->with('user', $user);
    }

    /**
     * downloadMembers
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadMembers($id)
    {
        $community= Community::find($id);
        $user= User::find(Auth::id());

        //check if user has credential to view this communty (member or owner)
        if ($community->user_id!=Auth::id())
            return redirect('/communities')->with('error','You do not have access to download members of this Circle.');

        //return Excel::download(new CommunityMemberExport, 'CommunityMembers.xlsx');
        return (new CommunityMemberExport($id))->download('CommunityMembers.xlsx');
    }

    /**
     * Show the form for members from file.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddMembersFromFileForm($id)
    {
        $community= Community::find($id);
        $user= User::find(Auth::id());

        //check if user has credential to view this communty (member or owner)
        if ($community->user_id!=Auth::id())
            return redirect('/communities')->with('error','You do not have access to Add member to this Circle.');


        return view('uploadmembersfile')->with('community',$community);
    }

    /**
     * Show the form for members from file.
     *
     * @return \Illuminate\Http\Response
     */
    public function parseMembersFileDisplayColSelection(Request $request, $id)
    {
        $this->validate($request, [
            'members-file' => 'required|file'
            ]);

        $community= Community::find($id);
        $user= User::find(Auth::id());

        //check if user has credential to view this communty (member or owner)
        if ($community->user_id!=Auth::id())
            return redirect('/communities')->with('error','You do not have access to Add members to this Circle.');

        $membersArray=Excel::toArray(new CommunityMemberImport, request()->file('members-file'));

        $CommunityMemberFieldlist=array();
        array_push($CommunityMemberFieldlist, ['dbColName'=>'name','rule'=>'none','possibleColNames'=>['name']]);
        array_push($CommunityMemberFieldlist, ['dbColName'=>'f_name','rule'=>'none','possibleColNames'=>['first name','f_name','f name']]);
        array_push($CommunityMemberFieldlist, ['dbColName'=>'l_name','rule'=>'none','possibleColNames'=>['last name','l_name','l name']]);
        array_push($CommunityMemberFieldlist, ['dbColName'=>'phone','rule'=>'isPhone','possibleColNames'=>['phone','cellphone','home phone','work phone']]);
        array_push($CommunityMemberFieldlist, ['dbColName'=>'email','rule'=>'isEmail','possibleColNames'=>['email','email address']]);
        array_push($CommunityMemberFieldlist, ['dbColName'=>'custom1','rule'=>'none','possibleColNames'=>[]]);
        array_push($CommunityMemberFieldlist, ['dbColName'=>'custom2','rule'=>'none','possibleColNames'=>[]]);
        array_push($CommunityMemberFieldlist, ['dbColName'=>'custom3','rule'=>'none','possibleColNames'=>[]]);
        array_push($CommunityMemberFieldlist, ['dbColName'=>'custom4','rule'=>'none','possibleColNames'=>[]]);


        $guessedHeaders=$this->guessArrayMapToDbFields($CommunityMemberFieldlist, $membersArray[0],request()->input('header-row'));

        $possibleColumnsNames=array('name','f_name','l_name','phone','email','custom1','custom2','custom3','custom4');
        $request->session()->put('membersArray', $membersArray[0]);
        $request->session()->put('hasHeaderRow', request()->input('header-row'));
        return view('parsemembersfile',['membersArray'=>$membersArray[0],'guessedHeaders'=>$guessedHeaders, 'possibleColumnsNames'=>$possibleColumnsNames, 'withHeaderRow'=>request()->input('header-row'),'community'=>$community]);


        // For debuging purpose
        //json_encode($membersArray[0],JSON_PRETTY_PRINT);
        //[['dbColName'->'phone','rule'=>'isPhone','possibleColNames'=['phone','cellphone']]]
        //$membersArray[0]
        //request()->input('header-row')
        //return json_encode($guessedHeaders,JSON_PRETTY_PRINT);
    }

    /**
     * Handle the insert/update of members from file by the columns names selected.
     *
     * @return \Illuminate\Http\Response
     */
    public function addMemberFromFile(Request $request, $id)
    {
        $community= Community::find($id);
        $user= User::find(Auth::id());

        //check if user has credential to view this communty (member or owner)
        if ($community->user_id!=Auth::id())
            return redirect('/communities')->with('error','You do not have access to Add members to this Circle.');

        $membersArray=session()->get('membersArray');
        $hasHeaderRow=session()->get('hasHeaderRow');
        $selectedRowToAdd=request()->input('memberRowNum');
        $colsDbMaping=request()->input('colHeadingNames');

        $emailColIndex=array_search ('email' , $colsDbMaping );
        $nameColIndex=array_search ('name' , $colsDbMaping );
        $phoneColIndex=array_search ('phone' , $colsDbMaping );
        $custom1ColIndex=array_search ('custom1' , $colsDbMaping );
        $custom2ColIndex=array_search ('custom2' , $colsDbMaping );
        $custom3ColIndex=array_search ('custom3' , $colsDbMaping );
        $custom4ColIndex=array_search ('custom4' , $colsDbMaping );

        $fNameColIndex=array_search ('f_name' , $colsDbMaping );
        $lNameColIndex=array_search ('l_name' , $colsDbMaping );

        // array_search ('email' , $colsDbMaping ) - return column index of email
        //traverse over members array. If row index is in request()->input('memberRowNum')
        //then try to find member by email (according to email column index).
        //If found - update existing member. If not create new member.
        //array_search ('name' , $colsDbMaping ) - return index of name

        for ($i=0; $i<count($membersArray);$i++){
            if (in_array($i,$selectedRowToAdd)){
                $community_member=CommunityMember::where('email', $membersArray[$i][$emailColIndex])->first();
                if ($community_member)//update
                {
                    if ($fNameColIndex!==false && $lNameColIndex!==false)
                        $community_member->name=$membersArray[$i][$fNameColIndex]." ".$membersArray[$i][$lNameColIndex];

                    if ($nameColIndex!==false)
                        $community_member->name=$membersArray[$i][$nameColIndex];
                    if ($phoneColIndex!==false)
                        $community_member->phone=$membersArray[$i][$phoneColIndex];
                    if ($custom1ColIndex!==false)
                        $community_member->custom1=$membersArray[$i][$custom1ColIndex];
                    if ($custom2ColIndex!==false)
                        $community_member->custom2=$membersArray[$i][$custom2ColIndex];
                    if ($custom3ColIndex!==false)
                        $community_member->custom3=$membersArray[$i][$custom3ColIndex];
                    if ($custom4ColIndex!==false)
                        $community_member->custom4=$membersArray[$i][$custom4ColIndex];

                    $community_member->save();

                }
                else//insert
                {
                    $randomInviteCode=str_random(16).time();
                    $community_member=new CommunityMember;
                    $community_member->community_id=$community->id;
                    $community_member->invite_code=$randomInviteCode;

                    if ($emailColIndex!==false)
                        $community_member->email=$membersArray[$i][$emailColIndex];
                    if ($fNameColIndex!==false && $lNameColIndex!==false)
                        $community_member->name=$membersArray[$i][$fNameColIndex]." ".$membersArray[$i][$lNameColIndex];
                    if ($nameColIndex!==false)
                        $community_member->name=$membersArray[$i][$nameColIndex];
                    if ($phoneColIndex!==false)
                        $community_member->phone=$membersArray[$i][$phoneColIndex];
                    if ($custom1ColIndex!==false)
                        $community_member->custom1=$membersArray[$i][$custom1ColIndex];
                    if ($custom2ColIndex!==false)
                        $community_member->custom2=$membersArray[$i][$custom2ColIndex];
                    if ($custom3ColIndex!==false)
                        $community_member->custom3=$membersArray[$i][$custom3ColIndex];
                    if ($custom4ColIndex!==false)
                        $community_member->custom4=$membersArray[$i][$custom4ColIndex];

                    $community_member->save();
                }
            }
        }

        return redirect('/communities/'.$community->id)->with('success','Circle Updated');
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
    public function showjoin()
    {
        return view('joincircle');
    }

    /**
     * Join a Circle using invitation code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function join(Request $request)
    {
        $this->validate($request, [
            'invite_code' => 'required'
            ]);

        $user= User::find(Auth::id());
        $community_member=CommunityMember::where('invite_code', $request->input('invite_code'))->first();
        if ($community_member)
        {
            $community_member->user_id=$user->id;
            $community_member->save();
            return redirect('/communities')->with('success','You joined a circle!');
        }
        else
        {
            return redirect('/communities')->with('error','Code is incorrect! Please verify you copy with no spaces.');
        }

    }

    /**
     * joinFromEmailLink - join a Circle using invitation code directlty from email link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function joinFromEmailLink(Request $request)
    {
        //code is missing
        if ($request->input('code')===null)
            return redirect('/');



        //user logged in connect user to comme
        if (Auth::check()) {
            $user= User::find(Auth::id());
            $community_member=CommunityMember::where('invite_code', $request->input('code'))->first();
            if ($community_member)
            {
                $community_member->user_id=$user->id;
                $community_member->save();
                return redirect('/communities')->with('success','You joined a circle!');
            }
            else
            {
                return redirect('/communities')->with('error','The code you supplyis incorrect - please try again.');
            }
        } //user not logged in
        else{
            $community_member=CommunityMember::where('invite_code', $request->input('code'))->first();
            if ($community_member) // we found the community member using code
            {

                $user= User::where('email', $community_member->email)->first();
                if ($user)// user with that email already exists - set email and redirect to login
                {
                    //connect the user id
                    $community_member->user_id=$user->id;
                    $community_member->save();

                    //redirect to login
                    $request->merge(['email'=>$user->email]);
                    $request->flash();
                    return redirect('login');
                }

                //set the code in session
                $request->session()->put('invite_code', $request->input('code'));

                //user not exist - set data from community member in session and redirect to register
                $request->merge(['email'=>$community_member->email, 'name'=>$community_member->name, 'phone'=>$community_member->phone ]);
                $request->flash();
                return redirect('register');
            }
            return redirect('/');
        }
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
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120'
        ]);


        $cirlcename=strtolower($request->input('name'));
        $cirlcename = str_replace(" ", "-", $cirlcename);
        $cirlcename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $cirlcename);

        // Create new filename
        $filenameToStore = $cirlcename.'-'.time().'.jpg';

        $path   = $request->file('image');
        // returns Intervention\Image\Image
        $img = Image::make($path)->encode('jpg');
        $img->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        });
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
        $user= User::find(Auth::id());

        //check if user has credential to view this communty (member or owner)
        if ($community->user_id!=Auth::id() && !$user->communities->contains($community))
            return redirect('/communities')->with('error','You do not have access to view this Circle.');

        return view('circle')->with('community',$community);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $community= Community::find($id);

        //check if user has credential to view this communty (member or owner)
        if ($community->user_id!=Auth::id())
            return redirect('/communities')->with('error','You do not have access to edit this Circle.');

        return view('editcircle')->with('community',$community);
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
        $community= Community::find($id);

        //make sure user is authorised for this community
        if ($community->user_id!=Auth::id())
             redirect('/communities')->with('error','You do not have access to update this Circle.');

        $this->validate($request, [
        'name' => 'required'
        ]);

        if ($request->file('image'))
        {
            $cirlcename=strtolower($request->input('name'));
            $cirlcename = str_replace(" ", "-", $cirlcename);
            $cirlcename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $cirlcename);

            $filenameToStore = $cirlcename.'-'.time().'.jpg';

            $path   = $request->file('image');

            $img = Image::make($path)->fit(400)->encode('jpg');
            Storage::put('public/circles/'.$filenameToStore, $img->__toString());
            Storage::delete('public/circles/'.$community->image);
            $community->image=$filenameToStore;
        }

        $community->name = $request->input('name');
        $community->description = $request->input('description');
        $community->save();

        return redirect('/communities/'.$community->id)->with('success','Circle Updated');
    }

    /**
     * Show verify delete view.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showVerifyDelete($id)
    {
        $community= Community::find($id);

        //make sure user is authorised for this community
        if ($community->user_id!=Auth::id())
             redirect('/communities')->with('error','You do not have access to Delete this Circle.');

        return view('circle-verify-delete')->with('community',$community);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $community= Community::find($id);

        //make sure user is authorised for this community
        if ($community->user_id!=Auth::id())
             redirect('/communities')->with('error','You do not have access to Delete this Circle.');


        Storage::delete('public/circles/'.$community->image);
        foreach ($community->communityMembers as $member){
            $member->delete();
        }
        $community->delete();
        return redirect('/communities')->with('success','Circle Deleted successfully!');

    }

    public function showInvite($id)
    {
        $community= Community::find($id);

        //check if user has credential to invite members from this communty (member or owner)
        if ($community->user_id!=Auth::id())
            return redirect('/communities')->with('error','You do not have access to edit this Circle.');

        return view('invite-members')->with('community',$community);
    }

    public function inviteMembers(Request $request,$id)
    {
        $community= Community::find($id);
        $userOwner= User::find(Auth::id());

        if ($community->user_id!=Auth::id())
            return redirect('/communities/'.$id.'/showinvite')->with('error','You do not have access to edit this Circle.');

        $selectedMembers=$request->input('memeberstoinvite');
        if (!isset($selectedMembers))
            return redirect('/communities/'.$id.'/showinvite')->with('error','No members selected.');

        foreach ($selectedMembers as $memberId) {
            $community_member=CommunityMember::find($memberId);
            Mail::to($community_member->email)->send(new MemberInvite($community,$community_member,$userOwner));
        }

        //Mail::to("yshaool@gmail.com")->send(new MemberInvite($community,$community_member));
        return redirect('/communities/'.$community->id)->with('success','Invitation Emails Sent');
    }


}
