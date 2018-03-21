<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MhGmItem;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MhAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view(
            'admin.mh.mhadmin',
            [
                'gmItemsGruops'=>MhGmItem::select('ItemType')->groupby('ItemType')->get()
            ]
        );
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
        $this->validate($request,['ItemID'=>'required|min:5','ItemName'=>'required']);
        $ItemID = $request->ItemID;
        $ItemName = $request->ItemName;
        $ItemType = $request->ItemType;
        $ItemCount = MhGmItem::where('ItemID',$ItemID)->count();
        if(empty($ItemCount)){
            MhGmItem::insert(['ItemID' => "$ItemID", 'ItemName' => "$ItemName",'ItemType'=>"$ItemType",'Lxt_Updte_Time'=>date('Y-m-d H:i:s')]);
            return redirect('/mhadmin')->with('status', '上传成功！☺');
        }else{
            return redirect('/mhadmin')->with('status', '发现重复的物品代码→ →');
        }

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
