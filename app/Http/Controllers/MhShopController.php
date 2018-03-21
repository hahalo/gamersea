<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MhGmItem;
use App\MhQueuedItem;
use App\Http\Requests;
use Auth;
use App\MhUser;
use App\MhCharacterInfo;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MhShopController extends Controller
{
    //session测试
    //session(['test'=>'hhhhh']);
    //$test = session('test');
    public  $pageSize  = 36;
    public  $gameNames =  '';
    public  $sqlsrv;
    public function __construct()
    {
        if(!env('MH_OPEN')){
            return false;
        }
        //SQL数据库
        $sqlsrv = DB::connection('sqlsrv');
        //获取游戏角色
        if(Auth::check()){
            $user = Auth::user();
            $name = $user['name'];
            $gameNames = $sqlsrv->select("SELECT a.ID,b.ID as RID,b.Name from [User] a join CharacterInfo b on a.ID=b.UID where a.Name = :name",['name'=>$name]);
            $this->gameNames = $gameNames;
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!env('MH_OPEN')){
            return redirect('/');
        }
        return view(
            'mh.mhshop',
            [
                'gmItems' => MhGmItem::orderBy('ID','desc')->paginate($this->pageSize),
                'gmItemsGruops'=>MhGmItem::select('ItemType')->groupby('ItemType')->get(),
                'pageSize'=>$this->pageSize,
                'gameNames'=> $this->gameNames
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
 * search
 */
    public function search(Request $request)
    {
        $itemName = $request->s;
        return view(
            'mh.mhshop',
            [
                'gmItems' => MhGmItem::where('ItemName','like','%'.$itemName.'%')
                    ->orWhere('ItemID','like','%'.$itemName.'%')
                    ->paginate($this->pageSize),
                    'pageSize'=>$this->pageSize,
                    'gmItemsGruops'=>MhGmItem::select('ItemType')->groupby('ItemType')->get(),
                    'gameNames'=> $this->gameNames
            ]
        );
    }
    /**
     * searchTypeNormol
     */
    public function searchTypeNormol($id)
    {
        return view(
            'mh.mhshop',
            [
                'gmItems' => MhGmItem::where('ItemType', $id)->paginate($this->pageSize),
                'gmItemsGruops'=>MhGmItem::select('ItemType')->groupby('ItemType')->get(),'type'=>$id,
                'pageSize'=>$this->pageSize,
                'gameNames'=> $this->gameNames
            ]
        );
    }
    /**
     * searchType2
     * 解决 指环/戒指 问题
     */
    public function searchType2($id,$id2)
    {
        if(!empty($id2))
        {
            $id="$id/$id2";
        }
        return view(
            'mh.mhshop',
            [
                'gmItems' => MhGmItem::where('ItemType', $id)->paginate($this->pageSize),
                'gmItemsGruops'=>MhGmItem::select('ItemType')->groupby('ItemType')->get(),'type'=>$id,
                'pageSize'=>$this->pageSize,
                'gameNames'=> $this->gameNames
            ]
        );
        
    }
    /**
     * 购买商品
     */
    public function buy(Request $request){
        //goodsNum:goodsNum,itemID:itemID,role:role,rid:rid
        $role = $request->role;
        $rid = $request->rid;
        $goodsNum = $request->goodsNum;
        $ID = $request->itemID;
        //获取物品代码
        $itemIdArr = MhGmItem::where('ID',$ID)->first()->toArray();
        $itemID = $itemIdArr['ItemID'];
        $itemName = $itemIdArr['ItemName'];
        //protected $fillable = ['CID','ItemClassEx','Count','IsCharacterBinded','MailTitle','MailContent'];
        $itemClassEx = MhQueuedItem::insert
        (
            [
                'CID'=>$rid,
                'ItemClassEx'=>$itemID,
                'Count'=>$goodsNum,
                'IsCharacterBinded'=>'0',
                'MailTitle'=>$itemName,
                'MailContent'=>'GM送福利啦，酷(oo)'.$itemName
            ]
        );
        if($rid!=''&&$role!=''){
            session(['rid'=>$rid,'role'=>$role]);
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
