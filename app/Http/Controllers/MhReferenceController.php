<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MhReferenceController extends Controller
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
    public function search(Request $request)
    {
        $content = $request->search_text;
        if(!empty($content)){
            $content = strtoupper($content);
            $heroes_text_chinese_2016 = file_get_contents('heroes_text_chinese_2016.txt');
            $test = explode("<br />",nl2br($heroes_text_chinese_2016));
            for($i=0;$i<count($test);$i++){
                if(strstr($test[$i],$content)){
                    $find = explode('"',$test[$i]);
                    $find_arr[] = $find;
                }
            }
            if(isset($find_arr)&&!empty($find_arr)){
                echo json_encode($find_arr);
            }else{
                $find_arr = array('null','null','null','null');
                echo json_encode($find_arr);
            }
        }
    }
    //效率快0.1s
    public function searchFgets(Request $request)
    {
        $content = $request->search_text;
        if(!empty($content)){
            $content = strtoupper($content);
            $heroes_text_chinese_2016 = fopen('heroes_text_chinese_2016.txt','rb');
            while(!feof($heroes_text_chinese_2016)){
                //读取一行
                $buffer = fgets($heroes_text_chinese_2016);
                //匹配单词并计数
                if(strstr($buffer,$content)){
                    $find = explode('"',$buffer);
                    $find_arr[] = $find;
                }
            }
            if(isset($find_arr)&&!empty($find_arr)){
                echo json_encode($find_arr);
            }else{
                $find_arr = array('null','null','null','null');
                echo json_encode($find_arr);
            }
        }
    }
}
