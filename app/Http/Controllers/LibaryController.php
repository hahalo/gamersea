<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libary;
use App\LibaryMi;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LibaryController extends Controller
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
     * Search the Libary
     */
    public  function  search(Request $request){
        $content = $request->search_text;
        $this->validate($request,['search_text'=>'required|min:2']);
        $libarymi =  LibaryMi::where('username',$content)->orwhere('email',$content)->get()->toArray();
        $libarycsdn =  Libary::where('username',$content)->orwhere('email',$content)->get()->toArray();
        //$queries = DB::getQueryLog();
        //file_put_contents('test.txt',print_r($queries,true));
        if(!empty($libarymi)||!empty($libarycsdn)){
           // $libary = array_merge($libarymi,$libarycsdn);
            $libary = array($libarycsdn,$libarymi);
            echo json_encode($libary);
            //echo json_encode($libarymi);
        }else{
            $statue = array('email'=>'null');
            echo  json_encode($statue);
        }

        //echo $content;
    }
    /**
     * Search csdn libary
     */
    public  function  searchCsdn(Request $request){
        $content = $request->search_text;
        $this->validate($request,['search_text'=>'required|min:2']);
        $libarycsdn =  Libary::where('username',$content)->orwhere('email','like',' '.$content.'%')->get()->toArray();
        if(!empty($libarycsdn)){
            echo json_encode($libarycsdn);
        }else{
            $statue = array('email'=>'null');
            echo  json_encode($statue);
        }
    }
    /**
     * Search Mi libary
     */
    public  function  searchMi(Request $request){
        $content = $request->search_text;
        $this->validate($request,['search_text'=>'required|min:2']);
        $libarymi =  LibaryMi::where('username',$content)->orwhere('email',' '.$content.'%')->get()->toArray();
        if(!empty($libarymi)){
            echo json_encode($libarymi);
        }else{
            $statue = array('email'=>'null');
            echo  json_encode($statue);
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
