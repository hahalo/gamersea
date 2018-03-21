<?php

namespace App\Http\Controllers;

use App\User;
use App\Follow;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CenterController extends Controller
{
    public $user ;
    public function __construct(Request $request)
    {
        if (Auth::check()) {
            $this->user = $request->user();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $iFollowArr='';
        $user = $this->user;
        $followNum = Follow::where('userid',$this->user->id)->count();
        $isFollowNum = Follow::where('followid',$this->user->id)->count();
        //关注的人
        $follows = Follow::where('follow.userid',$this->user->id)->leftJoin('users','follow.followid','=','users.id')->select('follow.*', 'users.id as uid', 'users.name','users.nick_name','users.photo','users.sex','users.signature')->skip(0)->take(50)->get();
        //粉丝
        $fans = Follow::where('follow.followid',$this->user->id)->leftJoin('users','follow.userid','=','users.id')->select('follow.*', 'users.id as uid', 'users.name','users.nick_name','users.photo','users.sex','users.signature')->skip(0)->take(50)->get();
        //我关注的人数组
        foreach ($follows as $follow){
            $iFollowArr[] = $follow['followid'];
        }
        return view('i.i',compact("user",'followNum','isFollowNum','follows','fans','iFollowArr'));
    }
    /**
     * people
     */
    public function people(Request $request){
        $id = $request->id;
        $isFollow = '0';
        if (Auth::check()) {
            $this->user = $request->user();
            if($this->user->id==$id){
                return redirect('/i');
            }else{
                $isFollow = Follow::where('userid',$this->user->id)->where('followid',$id)->count();
            }
        }
        $user = User::where('id',$id)->first();
        if(empty($user)){
            return redirect('/error');
        }else{
            return view('i.people',compact("user",'isFollow','id'));
        }

    }
    public function follow(Request $request)
    {
        $followid = $request->followid;
        $user = $this->user;
        $userid = $user->id;
        $follow = Follow::where('userid',$userid)->where('followid',$followid)->count();
        if(empty($follow)){
            Follow::create(['userid'=>$userid,'followid'=>$followid]);
        }
    }
    public function unFollow(Request $request)
    {
        $followid = $request->followid;
        $user = $this->user;
        $userid = $user->id;
        $follow = Follow::where('userid',$userid)->where('followid',$followid)->count();
        if(!empty($follow)){
            Follow::where('userid',$userid)->where('followid',$followid)->delete();
        }
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = $this->user;
        return view('i.edit',compact("user"));
    }

    public function editUserInfo(Request $request)
    {
        $user = $this->user;
        $userField = $request->id;
        $userInfo  = $request->userInfo;
        if($userField=='nick_name'){
            session(['test'=>$user->id]);
            User::where('id',$user->id)->update(['nick_name'=>$userInfo]);
        }else if($userField=='sex'){
            User::where('id',$user->id)->update(['sex'=>$userInfo]);
        }else if($userField=='signature'){
            User::where('id',$user->id)->update(['signature'=>$userInfo]);
        }else if($userField=='photo'){
            $timeRands = date('YmdHis',time()).rand(1000,9999);
            $photo = $timeRands.'.jpg';
            $explodeBase64  = explode(";base64,", $userInfo);
            $userInfoDecode = base64_decode($explodeBase64[1]);
            file_put_contents('icon/'.$photo,$userInfoDecode);
            User::where('id',$user->id)->update(['photo'=>$photo]);
        }
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
