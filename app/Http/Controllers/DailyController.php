<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Daily;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DailyController extends Controller
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
        //存储日志
        $contents = $request->contents;
        $contents =  urlencode($contents);
        $contents = str_replace("\n","<br>",$contents);
        $this->validate($request,['releasetime'=>'required|max:255']);
        $this->validate($request,['contents'=>'required']);
        Daily::create(['releasetime'=>$request->releasetime,'content'=>$contents]);
        return redirect('/addDaily');
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
     * search the daily by datetime
     * 根据日期来搜索日志
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //
        $timebegin = $request->timebegin;
        $timeend   = $request->timeend;
        return view(
            'daily.daily',
            ['daily'=>daily::where('releasetime','>=',$timebegin)
            ->where('releasetime','<=',$timeend)
            ->get()]
        );
        //return redirect('/video');
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
