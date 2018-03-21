<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Album;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $bg = Album::where('album.share','1')->orderBy('album.like','desc')->orderBy('album.created_at','desc')->leftJoin('users','album.email','=','users.email')->select('album.*', 'users.id as uid', 'users.name','users.nick_name')->skip(0)->take(20)->get();
        if(Auth::check()){
            $user = $request->user();
            $userid = $user['id'];
            $album_like = \App\AlbumLike::where('userid',$userid)->get()->toArray();
        }else{
            $album_like = '';
        }
        return view('bg.bg',['bg'=>$bg,'album_like'=>$album_like]);
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
    /**
     * 夜晚切换
     */
    public function dayNight(Request $request){
        if($request->state=='true'){
            echo $_SESSION['daynight']=1;
        }else{
            echo $_SESSION['daynight']=0;
        }
    }

    /**
     * 欢迎界面
     */
    public function welcomeIndex(){
        return view('video/welcome');
    }
    /**
     *  home
     */
    public function home(){
        redirect('/');
    }
}
