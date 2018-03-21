<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Cache;
use App\Article;
use Intervention\Image\ImageManagerStatic as Image;

class ArticleController extends Controller
{
    protected $user ;
    public function __construct(Request $request)
    {
        if (Auth::check()) {
            $this->user = $request->user();
            Session('userid')?Session('userid'):Session(['userid'=>$request->user()->id]);
        }else{
            Session(['userid'=>'']);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::fetchAll();
        $navs = Article::fetchTypeNameAll();
        return view('article.article',compact('articles','navs'));
    }
    /**
     * 搜索文章
     */
    public function search(Request $request){
        $articles = Article::allBySearch($request->s);
        $navs = Article::fetchTypeNameAll();
        return view('article.article',compact('articles','navs'));
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
    public  function  getArticleAll()
    {
        return view('article.refresher',['articles' => Article::skip(0)->take(9)->get()]);
    }
    public  function  refresher(Request $request)
    {
        $x = $request->x;
        $y = $request->y;
        $articles =  Article::skip($x)->take($y)->get()->toArray();
        if(empty($articles)) {
            echo false;
        }else{
            echo json_encode($articles);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userid = $request->user()->id;
        $this->validate($request,['title'=>'required|max:255','typename'=>'required']);
        $articleTypeCount = Article::where('typename',$request->typename)->count();
        Article::create(['title'=>$request->title,'content'=>$request->summernote,'typename'=>$request->typename,'userid'=>$userid]);
        if(empty($articleTypeCount)){
           Cache::forget('navs');
           Article::fetchTypeNameAll();
        }
        return back()->withInput();
    }
    public function upload(Request $request)
    {
        $destinationPath= "pic";
        $request->file('photo')->move($destinationPath,rand(0,9999).'.jpg');
        return redirect('/upload');
    }
    /**
     * 显示文章
     */
    public  function article($id,Request $request){
        if(is_numeric($id)){
            $article = Article::leftJoin('users','articles.userid','=','users.id')->select('articles.*','users.nick_name','users.name','users.id as userid')->find($id);
            $click =  $article->click+1;
            Article::where('id',$id)->update(['click'=>$click]);
            return view('article.showArticle',['article' => $article,'click'=>$click]);
        }else{
            $userid = Session('userid');
            $articles = Article::where('typename', $id)->orderBy('id','desc')->get();
            $navs = Article::fetchTypeNameAll();
            return view('article.article',compact('userid','articles','navs'));
        }
    }
    /**
     *  添加文章界面
     */
    public function addArticleIndex(){
        $navs = Article::fetchTypeNameAll();
        return view('article.addArticle',compact('navs'));
    }
    public function addArticle(Request $request)
    {
       // $this->wrongTokenAjax();
        $getExtension = $request->file('photo')->getClientOriginalExtension();
        $rules = ['jpeg','jpg', 'png', 'gif', 'bmp', 'svg'];
        //验证图片
        if(in_array($getExtension,$rules)){
            $destinationPath= "pic";
            $picName = date("YmdHis").'.'.$getExtension;
            $request->file('photo')->move($destinationPath,$picName);
            Image::make('pic/'.$picName)->resize(300, 200)->save('pic/'.'mini_'.$picName);
            echo '/pic/'.$picName;
        }

     //   return redirect('/upload');
    }

    /**
     *  showarticle
     */
    public function showArticle($id){
        return view('article.showArticle',['article' => Article::find($id)]);
    }

    /**
     * 测试
     */
    public function  test()
    {
        echo "test";
      //  Image::make('pic/20160605175720.jpg')->resize(300,200)->save('pic/mini_20160605175720.jpg');
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
    public function edit(Request $request)
    {
        $articleid = $request->articleid ;
        $userid = $request->user()->id;
        $this->validate($request,['title'=>'required|max:255']);
        $success = Article::where('id',$articleid)
            ->where('userid',$userid)
            ->update(['title'=>$request->title,'content'=>$request->summernote,'typename'=>$request->typename]);
        if($success){
            return back()->with('status', '修改成功！☺');
        }else{
            return back()->with('status', '修改失败！%~%');
        }
    }
    //发送编辑的内容
    public function editShow(Request $request)
    {
        $id = $request->id;
        $user = $this->user;
        $article = Article::where('id',$id)->first();
        if(!empty($article)){
            $articleUserid = $article->userid;
            if($articleUserid==$user->id){
                return view(
                    'article.editArticle',
                    [
                        'editArticle'
                        => $article,
                        'articles'
                        =>
                            Article::groupby('typename')->get()
                    ]
                );
            }else{
                return redirect('/article');
            }
        }else{
            return redirect('/article');
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
