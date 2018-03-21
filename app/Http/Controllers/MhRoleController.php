<?php

namespace App\Http\Controllers;

use App\MhEnchantScroll;
use App\MhQueuedItem;
use App\MHSynthesisSkillBonus;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Session\Session;

class MhRoleController extends Controller
{

    public $shop;
    public $pageSize  = 36;
    public $current_page =1;
    public $rid;
    public $role;
    public $enchantScrolls;
    public $search;//搜索内容
    public $searchSql; //搜索SQL
    public $searchArr; //搜索内容绑定参数
    public $synthesisSkillBonus;
    public function __construct(Request $request)
    {
        if(!Auth::check()){
           return;
        }
        if(!env('MH_OPEN')){
            return false;
        }
       $this->shop = new MhShopController();
        if($request->has('page')){
            $this->current_page = $request->input('page');
            $this->current_page = $this->current_page <= 0 ? 1 :$this->current_page;
        }
        if(Session('role')){
            foreach ($this->shop->gameNames as $gameName){
                $this->rid = $gameName->RID;
                $this->role= $gameName->Name;
            }
            if(!empty($this->rid)){
                $this->rid =  Session('rid');
            }
            if(!empty($this->role)){
                $this->role = Session('role');
            }
        }else{
            foreach ($this->shop->gameNames as $gameName){
                $this->rid = $gameName->RID;
                $this->role= $gameName->Name;
            }
        }
        //enchantScroll
        $this->enchantScrolls = MhEnchantScroll::get();
        //$synthesisSkillBonus
        $this->synthesisSkillBonus = MHSynthesisSkillBonus::orderBy('classrestriction', 'asc')->get();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check()){
            return redirect('/login');
        }
        if(!env('MH_OPEN')){
            return redirect('/');
        }
        $pageSize = $this->pageSize;
        $gameNames = $this->shop->gameNames;
        $role = $this->role;
        $enchantScrolls = $this->enchantScrolls;
        $synthesisSkillBonus = $this->synthesisSkillBonus;
        $gameRoleInfos = DB::connection('sqlsrv')->select("SELECT a.ID,a.ID as UID ,* from Item a left join Equippable b on a.ID=b.ID LEFT JOIN GMItem c on a.ItemClass=c.ItemID LEFT JOIN  (SELECT [Value] as ENHANCE,ItemID from ItemAttribute where Attribute='ENHANCE') d on d.ItemID=a.ID LEFT JOIN  (SELECT [Value] as PREFIX,ItemID from ItemAttribute where Attribute='PREFIX') e on e.ItemID=a.ID LEFT JOIN  (SELECT [Value] as SUFFIX,ItemID from ItemAttribute where Attribute='SUFFIX') f on f.ItemID=a.ID LEFT JOIN  (SELECT [Value] as SYNTHESISGRADE,ItemID from ItemAttribute where Attribute='SYNTHESISGRADE') g on g.ItemID=a.ID LEFT JOIN  (SELECT [Arg] as QUALITY,ItemID from ItemAttribute where Attribute='QUALITY') h on h.ItemID=a.ID where OwnerID = :rid $this->searchSql", ['rid'=>$this->rid],$this->searchArr);
        return view(
            'mh.mhrole',
            compact('pageSize','gameNames','role','enchantScrolls','choose','synthesisSkillBonus'),
            $this->pagination($gameRoleInfos)
        );
    }

    /**
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function role($name){
        foreach ($this->shop->gameNames as $gameName){
            if($name==$gameName->Name){
                $this->rid = $gameName->RID;
                $this->role= $gameName->Name;
                session(['rid'=>$gameName->RID,'role'=>$gameName->Name]);
                return $this->index();
            }
        }
    }

    /**
     * @param $gameRoleInfos
     * @return mixed
     */
    public function pagination($gameRoleInfos){
        $gameRoleInfos = json_decode(json_encode($gameRoleInfos), true);
        $item = array_slice($gameRoleInfos, ($this->current_page-1)*$this->pageSize, $this->pageSize); //注释1
        $total = count($gameRoleInfos);
        $paginator =new LengthAwarePaginator($item, $total, $this->pageSize, $this->current_page, [
            'path' => Paginator::resolveCurrentPath(),  //注释2
            'pageName' => 'page',
        ]);
        $gameRoleInfos = $paginator->toArray()['data'];
        //['gameRoleInfos'=>$gameRoleInfos,'paginator'=>$paginator]
        return compact('gameRoleInfos','paginator');
    }

    /**
     * @name 发送附魔
     * @param Request $request
     */
    public function send(Request $request){
        $scrollId = $request->scrollid;
        $scrollInfo = MhEnchantScroll::where('id',$scrollId)->first();
        $scrollCode = $scrollInfo->code;
        $scrollType = $scrollInfo->type;
        $scrollName = $scrollInfo->name;
        $scrollItem = "enchant_scroll[$scrollType:$scrollCode]";
        MhQueuedItem::insert
        (
            [
                'CID'=>$this->rid,
                'ItemClassEx'=>$scrollItem,
                'Count'=>1,
                'IsCharacterBinded'=>'0',
                'MailTitle'=>'【附魔卷轴】GM送福利啦，酷(oo)'.$scrollName,
                'MailContent'=>'GM送福利啦，酷(oo)'.$scrollName
            ]
        );
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function enhance(Request $request){
        $itemID = $request->itemid;
        $level = $request->level;
        if($level<=15&&$level>=0){
            $itemAttribute =  DB::connection('sqlsrv')->select("select * from ItemAttribute where Attribute='ENHANCE' and ItemID=:itemID ",['itemID'=>$itemID]);
            if(empty($itemAttribute)){
                DB::connection('sqlsrv')->
                insert("insert into [ItemAttribute]([ItemID],[Attribute],[Value])values(?,?,?)",[$itemID,'ENHANCE',$level]);
            }else{
                DB::connection('sqlsrv')->
                update("update [ItemAttribute] set [Value]=? where Attribute='ENHANCE' and ItemID=? ",[$level,$itemID]);
            }
        }else{
            return false;
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function enchanting(Request $request){
        $itemID = $request->itemid;
        $scrollId = $request->scrollid;
        $scrollInfo = MhEnchantScroll::where('id',$scrollId)->first();
        $scrollCode = $scrollInfo->code;
        $scrollType = $scrollInfo->type;
        $scrollName = $scrollInfo->name;
        if(!empty($itemID)&&!empty($scrollId)){
            if($scrollType=='PREFIX'){
                $itemAttribute =  DB::connection('sqlsrv')->select("select * from ItemAttribute where Attribute='PREFIX' and ItemID=:itemID ",['itemID'=>$itemID]);
                if(empty($itemAttribute)){
                    DB::connection('sqlsrv')->insert("insert into [ItemAttribute]([ItemID],[Attribute],[Value])values(?,?,?)",[$itemID,'PREFIX',$scrollCode]);

                }else{
                    DB::connection('sqlsrv')->
                    update("update [ItemAttribute] set [Value]=? where Attribute='PREFIX' and ItemID=? ",[$scrollCode,$itemID]);
                }
            }else if($scrollType=='SUFFIX'){
                $itemAttribute =  DB::connection('sqlsrv')->select("select * from ItemAttribute where Attribute='SUFFIX' and ItemID=:itemID ",['itemID'=>$itemID]);
                if(empty($itemAttribute)){
                    DB::connection('sqlsrv')->
                    insert("insert into [ItemAttribute]([ItemID],[Attribute],[Value])values(?,?,?)",[$itemID,'SUFFIX',$scrollCode]);
                }else{
                    DB::connection('sqlsrv')->
                    update("update [ItemAttribute] set [Value]=? where Attribute='SUFFIX' and ItemID=? ",[$scrollCode,$itemID]);
                }
            }
        }else{
            return false;
        }
    }
    /**
     * search
     */
    public function search(Request $request)
    {
        $this->search = $request->s;
        $this->searchSql = " and ([ItemName] like N'%$this->search%' or [ItemType] like  N'%$this->search%' or [ItemClass] like  N'%$this->search%')";
       // $this->searchArr = ['ItemName',$this->search];
        return $this->index();

    }

    /**
     * @param Request $request
     */
    public function delete(Request $request){
        $itemID = $request->itemid;
        if($this->rid!=''&&$itemID!=''){
            DB::connection('sqlsrv')->delete("delete from [ItemAttribute] where [ItemID]=?",[$itemID]);
            DB::connection('sqlsrv')->delete("delete from [Item] where [ID]=?",[$itemID]);
            DB::connection('sqlsrv')->delete("delete from [Equippable] where [ID]=?",[$itemID]);
            echo json_encode(['success'=>1]);
        }else{
            echo json_encode(['success'=>0]);
        }
    }

    /**
     * @param Request $request
     * @return mixed3
     */
    public function dyeing(Request $request){
        $color1 = ltrim($request->color1,'#');
        $color2 = ltrim($request->color2,'#');
        $color3 = ltrim($request->color3,'#');
        $itemID = $request->itemid;
        if(empty($itemID)){
            return json_encode(['success'=>0]);
        }
        if($color1!=""||$color2!=""||$color3!=""){
            $color1 = hexdec($color1);
            $color2 = hexdec($color2);
            $color3 = hexdec($color3);
            DB::connection('sqlsrv')->
            update("update [Equippable] set [Color1]=?,[Color2]=?,[Color3]=? where ID=? ",[$color1,$color2,$color3,$itemID]);
            return json_encode(['success'=>1]);
        }else{
            return json_encode(['success'=>0]);
        }
    }

    /**
     * 升级
     */
    public  function upgrade(Request $request){
        $level = $request->level;
        if($level<=90&&$level>=0&&!empty($this->rid)){
            DB::connection('sqlsrv')->
            update("update [CharacterInfo] set [Level]=? where ID=?",[$level,$this->rid]);
            return json_encode(['success'=>1,'info'=>$this->role]);
        }else{
            return json_encode(['success'=>0]);
        }
    }
    /**
     * characterInfo
     */
    public function characterInfo(Request $request){
        $type = $request->type;
        if($type=='level'){
            $editFiled = $request->level;
            if($editFiled<=90&&$editFiled>=0&&!empty($this->rid)){
                $check=true;
                $field = 'Level';
            }else{
                $check=false;
            }
        }else if($type=='ap'){
            $editFiled = $request->ap;
            if($editFiled<=1000000&&!empty($this->rid)){
                $check=true;
                $field = 'AP';
            }else{
                $check=false;
            }
        }else{
            $check=false;
        }
        if($check==true){
            DB::connection('sqlsrv')->
            update("update [CharacterInfo] set [$field]=? where ID=?",[$editFiled,$this->rid]);
            return json_encode(['success'=>1,'info'=>$this->role]);
        }else{
            return json_encode(['success'=>0]);
        }
    }
    /**
     * 记住我的选择
     */
    public function rememberClick(Request $request){
        $choose = $request->choose;
        session(['choose'=>$choose]);
    }
    /**
     *  manufacture
     */
    public function manufacture(){
        $manufacture = ['cooking','metal_weapon','heavy_armor','light_armor','sewing','workmanship','armor','armor_dc','spirit_stone','gathering','metal_weapon_dc','sewing_dc','workmanship_dc'];
        $manufacture_count = count($manufacture);
        for($i=0;$i<$manufacture_count;$i++){
            $manufacturelID = $manufacture[$i];
            $grade = 4;
            $experiencePoint = 100000000;
            $manufacture_select =  DB::connection('sqlsrv')->select("select * from Manufacture where [ManufacturelID]=? and [CID]=?",[$manufacturelID,$this->rid]);
            if(empty($manufacture_select)){
                DB::connection('sqlsrv')->
                insert("insert into [Manufacture]([CID],[ManufacturelID],[Grade],[ExperiencePoint])values(?,?,?,?)",[$this->rid,$manufacturelID,$grade,$experiencePoint]);
            }else{
                DB::connection('sqlsrv')->
                update("update [Manufacture] set [ManufacturelID]=?,[Grade]=?,[ExperiencePoint]=? where ManufacturelID=? and CID=? ",[$manufacturelID,$grade,$experiencePoint,$manufacturelID,$this->rid]);
            }
        }
        return json_encode(['success'=>1,'info'=>$this->role]);
    }
    /**
     * vocation
     */
    public function vocation(Request $request){
        $vocationClass = $request->vocationClass;
        $vocationLevel = 40;
        $vocationExp = 0;
        $lastTransform = date('Y-m-d H:i:s');
       // file_put_contents('test.txt',$vocationClass);
        if($this->rid){
            $vocation_select =  DB::connection('sqlsrv')->select("SELECT * from Vocation WHERE CID=?",[$this->rid]);
            if(empty($vocation_select)){
                DB::connection('sqlsrv')->insert("insert into [Vocation]([CID],[VocationClass],[VocationLevel],[VocationExp],[LastTransform])values(?,?,?,?,?)",[$this->rid,$vocationClass,$vocationLevel,$vocationExp,$lastTransform]);
            }else{
                DB::connection('sqlsrv')->update("update [Vocation] set [VocationClass]=?,[VocationLevel]=?,[LastTransform]=? where CID=? ",[$vocationClass,$vocationLevel,$lastTransform,$this->rid]);
            }
            return json_encode(['success'=>1,'info'=>$this->role]);
        }else{
            return json_encode(['success'=>0]);
        }
    }
    /**
     * VocationSkill 删除处理
     */
    public function vocationSkill($type){
        if($type=='delete'){
            if($this->rid){
                $vocation_select =  DB::connection('sqlsrv')->delete("delete from [VocationSkill] where CID=?",[$this->rid]);
                return json_encode(['success'=>1,'info'=>$this->role]);
            }else{
                return json_encode(['success'=>0]);
            }
        }else{
            return json_encode(['success'=>0]);
        }

    }
    /**
     * synthesisgrade S
     */
    public  function synthesisGrade(Request $request){
        $itemID = $request->itemid;
        $synthesisGrade = $request->synthesisGrade;
        $attribute = "SYNTHESISGRADE";
        $value =$synthesisGrade?$synthesisGrade:"S";
        if(!empty($itemID)){
                $itemAttribute =  DB::connection('sqlsrv')->select("select * from ItemAttribute where Attribute='$attribute' and ItemID=:itemID ",['itemID'=>$itemID]);
                if(empty($itemAttribute)){
                    DB::connection('sqlsrv')->insert("insert into [ItemAttribute]([ItemID],[Attribute],[Value])values(?,?,?)",[$itemID,$attribute,$value]);

                }else{
                    DB::connection('sqlsrv')->
                    update("update [ItemAttribute] set [Value]=? where Attribute='$attribute' and ItemID=? ",[$value,$itemID]);
                }
        }else{
            return false;
        }
    }
    /**
     * synthesisgrade S
     */
    public  function quality(Request $request){
        $itemID = $request->itemid;
        $attribute = "QUALITY";
        $value = 'Sea';
        $arg = '5';
        if(!empty($itemID)){
            $itemAttribute =  DB::connection('sqlsrv')->select("select * from ItemAttribute where Attribute='$attribute' and ItemID=:itemID ",['itemID'=>$itemID]);
            if(empty($itemAttribute)){
                DB::connection('sqlsrv')->insert("insert into [ItemAttribute]([ItemID],[Attribute],[Value],[Arg])values(?,?,?,?)",[$itemID,$attribute,$value,$arg]);

            }else{
                DB::connection('sqlsrv')->
                update("update [ItemAttribute] set [Value]=?,[Arg]=? where Attribute='$attribute' and ItemID=? ",[$value,$arg,$itemID]);
            }
        }else{
            return false;
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
     *  add mh_synthesis_skill_bonus
     */
    public function synthesisSkillBonusAdd()
    {
        $starttime = explode(' ',microtime());
        $heroes_text_chinese_2016 = file_get_contents('heroes_text_chinese_2016.txt');
        $test = explode("<br />",nl2br($heroes_text_chinese_2016));
        $db3test = DB::connection('sqlite')->select("SELECT * FROM SynthesisSkillBonus");

        for($i=0;$i<count($test);$i++){
            foreach ($db3test as $key=>$testValue){
                $SkillID = "heroes_skill_name_".$testValue->SkillID;
                if(stristr($test[$i],strtoupper($SkillID))){
                    //file_put_contents('skilltest.txt',$SkillID .PHP_EOL,FILE_APPEND);
                    $find = explode('"',$test[$i]);
                    $findSkillid = $find[1];
                    $findSkillname = $find[3];
                    $gradeArr = explode('_',$testValue->DescID);
                    $grade = "S/".$gradeArr[count($gradeArr)-1];
                    $synthesisSkillBonusCount = MHSynthesisSkillBonus::where('skillid',$testValue->SkillID)->count();
                    if(empty($synthesisSkillBonusCount)){
                        MHSynthesisSkillBonus::create(
                            [
                                'classrestriction'=>$testValue->ClassRestriction,
                                'skillid'=>$testValue->SkillID,
                                'skillname'=>$findSkillname,
                                'descid'=>$testValue->DescID,
                                'grade'=>$grade
                            ]
                        );
                    }
                }
            }
        }

        //程序运行时间
        $endtime = explode(' ',microtime());
        $thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
        $thistime = round($thistime,3);
        echo "本网页执行耗时：".$thistime." 秒。".time();

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
}
