<?php
session_start();
use App\Article;
use App\Daily;
use App\Album;
use App\Music;
use App\Video;
use App\MyTest;
use App\MhGmItem;
use App\MhUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

# ------------------ welcome ------------------------

Route::get('/welcome','IndexController@welcomeIndex');

# ------------------ 主页路由 ------------------------
Route::get('/home','IndexController@home');

# ------------------ 个人主页 ------------------------

Route::group(['middleware' => 'auth'], function () {
    Route::get('/i','CenterController@index');
    Route::get('/i/edit','CenterController@edit');
    Route::post('/i/edit/{id}','CenterController@editUserInfo');
});
Route::get('/i/people/{id}','CenterController@people');
Route::post('/i/follow','CenterController@follow');
Route::post('/i/unfollow','CenterController@unFollow');

# ------------------ 默认 ------------------------
Route::get('/', 'IndexController@index');

# ------------------ 瀑布流主页 ------------------------

Route::post('/cloudealbumflow/bg','AlbumController@flowCloudeAlbumIndex');

# ------------------ 后台管理理由 ------------------------

Route::get('/adminc', function () {
    return view('admin.admin');
});

# ------------------ 控制白天夜晚事件 ------------------------

Route::post('/daynight', 'IndexController@dayNight');
/**
 * 用户路由
 */
Route::get('user/{id}', 'UserController@showProfile');

// 认证路由...
Route::get('/login', 'Auth\AuthController@getLogin');
Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');

// 注册路由...
Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'Auth\AuthController@postRegister');
//
Route::get('profile','UserController@profile');

# ------------------ 密码重置 ------------------------

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

# ------------------ 文章路由 ------------------------

Route::get('/addarticle','ArticleController@addArticleIndex');
Route::get('/showarticle/{id}','ArticleController@showArticle');
Route::get('/article/{id}','ArticleController@article' );
Route::get('/upload', function () {
    return view('article.upload');
});
Route::get('refresher','ArticleController@getArticleAll');
Route::get('article','ArticleController@index');
Route::get('/searcharticle','ArticleController@search');
Route::get('/test', 'ArticleController@test');

# ------------------ 需要登录才能进行操作 ------------------------

Route::group(['middleware' => 'auth'], function () {
    Route::post('article/create','ArticleController@store');
    Route::post('article/upload','ArticleController@upload');
    Route::post('article/edit','ArticleController@edit');
    Route::get('article/editshow/{id}','ArticleController@editShow');
    Route::post('addArticle/add','ArticleController@addArticle');
});
Route::post('refresher/refresher','ArticleController@refresher');
/**
 * 社工库
 */
Route::get('/libary', function () {
    return view('libary.libary');
});
Route::post('/libary/search','LibaryController@search');
Route::post('/libary/searchCsdn','LibaryController@searchCsdn');
Route::post('/libary/searchMi','LibaryController@searchMi');
/**
 * 音乐路由
 */
Route::get('/addMusic', function () {
    return view('admin.music.addMusic');
});
Route::post('addMusic/add','MusicController@store');
//展示音乐
Route::get('/cloudemusic', function (Request $request) {
    return view('cloude.cloudemusic',['music' => music::skip(0)->take(20)->get()]);
});
Route::post('/cloudemusic/showmusic','MusicController@showmusic');
/**
 * 视频路由
 */
Route::get('/addVideo', function () {
    return view('admin.video.addVideo');
});
Route::post('addVideo/add','VideoController@store');
//展示视频
Route::get('/cloudevideo', function (Request $request) {
    return view(
        'cloude.cloudevideo',
        [
            'videos'
                => video::orderBy('created_at', 'desc')
                -> paginate(20)
        ]
    );
});
//VIP视频
Route::get('/vipvideo','VideoController@vipvideo');
Route::post('/cloudevideo/showvideo','VideoController@showvideo');

# ------------------ 日志路由 ------------------------

Route::get('/addDaily', function () {
    return view('admin.job.addDaily');
});
Route::get('/daily', function () {
    return view('daily.daily',['daily'=>daily::skip(0)->take(20)->get()]);
});
Route::post('/daily','DailyController@search');
Route::post('/daily/search','DailyController@search');
Route::post('addDaily/add','DailyController@store');

# ------------------ 云服务 ------------------------

Route::get('/cloudealbum', function (Request $request) {
    if(!Auth::check()){
        return redirect('/login');
    }
    $user = $request->user();
    $email = $user['email'];
    return view('cloude.cloudealbum',[
        'albums'
         => album::where('email',$email)
         -> orderBy('created_at', 'desc')
         -> paginate(45)
    ]);
});

# ------------------ 云相册（瀑布流） ------------------------

Route::get('/cloudealbumflow', function (Request $request) {
    if(!Auth::check()){
        return redirect('/login');
    }
    $user = $request->user();
    $email = $user['email'];
    return view('cloude.cloudealbumflow',[
        'albums'
        => album::where('email',$email)
            -> orderBy('created_at', 'desc')
            -> paginate(20)
    ]);
});
//瀑布流分页算法
Route::post('/cloudealbumflow/algorithm','AlbumController@flowAalgorithm');
//大图展示
Route::get('/cloudealbum/maxpic/{id}','AlbumController@showMaxAlbum');
//图片分享
Route::get('/cloudealbum/share/{id}','AlbumController@share');
//图片删除
Route::get('/cloudealbum/delete/{id}','AlbumController@delete');
//后台相册
Route::get('/addPhoto', function () {
    return view('admin.cloude.addPhoto');
});
//上传相册
Route::post('/server/fileupload','AlbumController@store');
//图片点赞
Route::post('/album/like','AlbumController@albumLike');

# ------------------ 视频路由 ------------------------

Route::get('/video', function () {
    return view('video.video');
});

# ------------------ 错误路由 ------------------------

Route::any('error', function () {
    return view('errors/503');
});
Route::get('505', function () {
    return redirect('/error');
});
Route::get('/foo', function () {
    abort(404);
});

# ------------------ MH ------------------------

//mhshop index
Route::get('/mhshop', 'MhShopController@index');
//右侧分类搜索
Route::get('/mhshop/group/{id}', 'MhShopController@searchTypeNormol');
//解决 指环/戒指 问题
Route::get('/mhshop/group/{id}/{id2}', 'MhShopController@searchType2');
//物品搜索
Route::get('/mhshop/search','MhShopController@search');
//购买物品
Route::post('/mhshop/buy','MhShopController@buy');

# ------------------ MH Role------------------------

//index
Route::get('/mhrole','MhRoleController@index');
//role
Route::get('/mhrole/role/{name}', 'MhRoleController@role');
//send
Route::post('/mhrole/send','MhRoleController@send');
//enhance
Route::post('/mhrole/enhance','MhRoleController@enhance');
//enchanting
Route::post('/mhrole/enchanting','MhRoleController@enchanting');
//search
Route::get('/mhrole/search','MhRoleController@search');
//delete
Route::post('/mhrole/delete','MhRoleController@delete');
//dyeing
Route::post('/mhrole/dyeing','MhRoleController@dyeing');
//upgrade
Route::post('/mhrole/upgrade','MhRoleController@characterInfo');
//ap
Route::post('/mhrole/editAP','MhRoleController@characterInfo');
//remenber click tools
Route::post('/mhrole/remenber','MhRoleController@rememberClick');
//Manufacture
Route::post('/mhrole/manufacture','MhRoleController@manufacture');
//Vocation
Route::post('/mhrole/vocation','MhRoleController@vocation');
//vocationSkill
Route::post('/mhrole/vocationSkill/{type}','MhRoleController@vocationSkill');
//synthesisgrade
Route::post('/mhrole/synthesisGrade','MhRoleController@synthesisGrade');
//quality
Route::post('/mhrole/quality','MhRoleController@quality');
//mhReference
Route::get('/mhreference', function () {
    return view('mh.mhreference');
});
Route::get('/mhreference/search','MhReferenceController@search');
//mhReference add
Route::get('/synthesisSkillBonusAdd','MhRoleController@synthesisSkillBonusAdd');

# ------------------ 洛英后台------------------------

Route::get('/mhadmin','MhAdminController@index');
//add
Route::post('/mhadmin/add','MhAdminController@store');

# ------------------ 聊天室 ------------------------
Route::get('/chat','ChatController@index');
post('send-message', 'ChatController@sendMessage'); // 發送訊息
# ------------------ 测试------------------------

Route::get('/test/flow','AlbumController@flowCloudeAlbumIndex');

Route::get('/test-hash1', function(Request $request) {
    $user = $request->user();
    $ise = 'test';
    echo $ise;
});
Route::get('/redis_put', function(Request $request) {
    $minutes = 10;
    Cache::store('redis')->put('key', 'value', 10);
});
Route::get('/redis_get', function(Request $request) {
    print $value = Redis::get('key');
});
Route::get('/setsession', function(Request $request) {
    $testSession = Session(['test'=>'test2017']);
});
Route::get('/getsession', function(Request $request) {
   echo Session('test');
});
Route::get('/testsqlite', function(Request $request) {
    $heroes_text_chinese_2016 = file_get_contents('heroes_text_chinese_2016.txt');
    $test = explode("<br />",nl2br($heroes_text_chinese_2016));
    $db3test = DB::connection('sqlite')->select("SELECT * FROM SynthesisSkillBonus");

    for($i=0;$i<count($test);$i++){
        foreach ($db3test as $key=>$testValue){
            $SkillID = "heroes_skill_name_".$testValue->SkillID;
            if(stristr($test[$i],$SkillID)){
                file_put_contents('skilltest.txt',$SkillID .PHP_EOL,FILE_APPEND);
                $find = explode('"',$test[$i]);
                $find_arr[] = $find;
            }
        }
    }
});

//websoket
Route::get('/event', function(){
    Event::fire(new \App\Events\SomeEvent(3,22));
    return "hello world";
});
