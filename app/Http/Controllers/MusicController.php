<?php

namespace App\Http\Controllers;

use App\Music;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MusicController extends Controller
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
       //验证
        $this->validate($request,['musicname'=>'required|max:255']);
        $this->validate($request,['singer'=>'required']);
        $this->validate($request,['singerpic'=>'required']);
        $this->validate($request,['musicfile'=>'required']);
        //存储音乐
        $musicname = strip_tags($request->musicname);
        $singer = strip_tags($request->singer);
        $pic_ext = $request->file('singerpic')->getClientOriginalExtension();
        $pic_arr = array('jpg','jpeg','png','bmp');
        if(!in_array(strtolower($pic_ext),$pic_arr)){
            return redirect()->back()->withInput()->withErrors('图片格式不正确！');
        }
        $singerpic = $request->file('singerpic')->move('pic',date('YmdHis',time()).rand(1000,9999).'.'.$pic_ext);
        $music_ext = $request->file('musicfile')->getClientOriginalExtension();
        $music_arr = array('mp3','wav','wma','ogg');
        if(!in_array(strtolower($music_ext),$music_arr)){
            return redirect()->back()->withInput()->withErrors('音乐格式不正确！！');
        }
        $musicurl = $request->file('musicfile')->move('music','music'.date('YmdHis',time()).rand(1000,9999).'.'.$music_ext);

        Music::create(['musicname'=>$musicname,'singer'=>$singer,'singerpic'=>$singerpic,'musicurl'=>$musicurl]);
        return redirect('/addMusic')->with('status', 'Upload Success! 上传成功！ :)');
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
    public  function showmusic(Request $request){
        $music =  Music::select('singerpic as src', 'musicname as title','musicurl as song','singer as singer ')->get()->toArray();
        echo json_encode($music);
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
