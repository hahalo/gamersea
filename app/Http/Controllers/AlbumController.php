<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Album;
use App\AlbumLike;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

class AlbumController extends Controller
{
    public $defautPage = 20;//第一次加载默认数据为20
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
     * 分享照片
     */
    public  function share(Request $request){
        $id = $request->id;
        $id_arr = explode('&&',$id);
        $id = $id_arr[0];
        $share = $id_arr[1];
        //判断是否分享
        if(empty($share)){
            $isorshare = 1;
        }else{
            $isorshare = 0;
        }
        $user = $request->user();
        $email = $user['email'];
        album::where('email',$email)->where('id',$id)->update(['share'=>$isorshare]);
       // return view('cloude.cloudealbummax',['albums' => album::where('email',$email)->where('id',$id)->get()]);
        return back()->withInput();
    }
    /**
     * 点赞
     */
    public function  albumLike(Request $request){
        $albumid =  $request->picid;
        if (Auth::check()) {
            $user = $request->user();
            $userid = $user['id'];
            $userLikeCount = AlbumLike::where('userid',$userid)->where('albumid',$albumid)->count();
           
            if($userLikeCount>0){
                return false;
            }else{
                $album =  Album::where('id',$albumid)->first();
                $albumLikeMax =  $album->like+1;
                Album::where('id',$albumid)->update(['like'=>$albumLikeMax]);
                AlbumLike::create(['albumid' =>$albumid, 'userid' => $userid]);
                return 1;
            }
        }else{
            return 0;
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
        if (Auth::check()) {
            $user = $request->user();
            $filename = $_POST['name'];
            $extarray = explode('.',$filename);
            $ext = $extarray['1'];

            // Make sure file is not cached (as it happens for example on iOS devices)
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");


            // Support CORS
            // header("Access-Control-Allow-Origin: *");
            // other CORS headers if any...
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                exit; // finish preflight CORS requests here
            }


            if ( !empty($_REQUEST[ 'debug' ]) ) {
                $random = rand(0, intval($_REQUEST[ 'debug' ]) );
                if ( $random === 0 ) {
                    header("HTTP/1.0 500 Internal Server Error");
                    exit;
                }
            }

            // header("HTTP/1.0 500 Internal Server Error");
            // exit;


            // 5 minutes execution time
            @set_time_limit(5 * 60);

            // Uncomment this one to fake upload time
            // usleep(5000);

            // Settings
            // $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
            $targetDir = 'upload_tmp';
            $uploadDir = 'upload';

            $cleanupTargetDir = true; // Remove old files
            $maxFileAge = 5 * 3600; // Temp file age in seconds


            // Create target dir
            if (!file_exists($targetDir)) {
                @mkdir($targetDir);
            }

            // Create target dir
            if (!file_exists($uploadDir)) {
                @mkdir($uploadDir);
            }

            // Get a file name
            if (isset($_REQUEST["name"])) {
                $fileName = $_REQUEST["name"];
            } elseif (!empty($_FILES)) {
                $fileName = $_FILES["file"]["name"];
            } else {
                $fileName = uniqid("file_");
            }

            $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
            $dateRand = date('YmdHis').rand(1,9999);
            $maxFilename = 'Max_'.$dateRand.'.'.$ext;
            $minFilename = 'Min_'.$dateRand.'.'.$ext;
            $uploadPath = $uploadDir . DIRECTORY_SEPARATOR .$maxFilename;


            // Chunking might be enabled
            $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
            $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


            // Remove old temp files
            if ($cleanupTargetDir) {
                if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
                }

                while (($file = readdir($dir)) !== false) {
                    $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                    // If temp file is current file proceed to the next
                    if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                        continue;
                    }


                    // Remove temp file if it is older than the max age and is not the current file
                    if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                        @unlink($tmpfilePath);
                    }
                }
                closedir($dir);
            }


            // Open temp file
            if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if (!empty($_FILES)) {
                if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
                }

                // Read binary input stream and append it to temp file
                if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                }
            } else {
                if (!$in = @fopen("php://input", "rb")) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                }
            }

            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }

            @fclose($out);
            @fclose($in);

            rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

            $index = 0;
            $done = true;
            for( $index = 0; $index < $chunks; $index++ ) {
                if ( !file_exists("{$filePath}_{$index}.part") ) {
                    $done = false;
                    break;
                }
            }
            if ( $done ) {
                if (!$out = @fopen($uploadPath, "wb")) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
                }

                if ( flock($out, LOCK_EX) ) {
                    for( $index = 0; $index < $chunks; $index++ ) {
                        if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                            break;
                        }

                        while ($buff = fread($in, 4096)) {
                            fwrite($out, $buff);
                        }

                        @fclose($in);
                        @unlink("{$filePath}_{$index}.part");
                    }

                    flock($out, LOCK_UN);
                }
                @fclose($out);
            }

            @$exif = exif_read_data($uploadPath);
            @$dateTime = $exif['DateTime'];

            $this->removeExif($uploadPath);

            Image::make($uploadPath)->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save('upload/'.$minFilename);

            Album::create(['title'=>$filename,'maxpic'=>$maxFilename,'email'=>$user['email'],'lastmodefieddate'=>$dateTime,'minpic'=>$minFilename]);
            // Return Success JSON-RPC response
            die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
        }else{

        }


    }
    //测试
    public function test(){
        file_put_contents('test.txt','test...');
    }

    //IOS照片转正
    public function removeExif($imgFile) {
        if (!function_exists('exif_read_data')) {
            return;
        }
        $img  = @imagecreatefromjpeg($imgFile);
        if($img === false){
            return;
        }
        $exif = exif_read_data($imgFile);
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 8:
                    $image = imagerotate($img, 90, 0);
                    break;
                case 3:
                    $image = imagerotate($img, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($img, -90, 0);
                    break;
            }
        }
        imagedestroy($img);
        if (isset($image)) {
            imagejpeg($image, $imgFile);
            imagedestroy($image);
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
     * 删除照片
     */
    public  function delete(Request $request){
        $id = $request->id;
        $user = $request->user();
        $email = $user['email'];
        Album::where('email',$email)->where('id',$id)->delete();
        return redirect('/cloudealbum');
    }
    /**
     * 主页相册 （瀑布流）
     */
    public  function flowCloudeAlbumIndex(Request $request){
        $pageSize = $request->pageSize;
        $page     = $request->page;
        $skip =  $this->defautPage + $page*$pageSize;
        $albums =
            Album::where('album.share','1')
                ->orderBy('album.like','desc')
                ->orderBy('album.created_at','desc')
                ->leftJoin('users','album.email','=','users.email')
                ->select('album.*', 'users.id as uid', 'users.name','users.nick_name')
                -> skip($skip)
                -> take($pageSize)
                -> get()
                -> toArray();
        if(Auth::check()){
            $user = $request->user();
            $userid = $user['id'];
            $album_like = \App\AlbumLike::where('userid',$userid)->get()->toArray();
        }else{
            $album_like = '';
        }
        //点过赞的图片集合
        if(empty($album_like)){
            $album_id[] = "";
        }else{
            foreach ($album_like as $album_value){
                $album_id[] = $album_value['albumid'];
            }
        }
        //是否点赞
        foreach ($albums as $albumKey => $albumValue){
            $date = strtotime($albumValue['created_at']);
            $albums[$albumKey]['title']=date('Y-m-d',$date);
            if(in_array($albumValue['id'],$album_id)){
                $albums[$albumKey]['info']=1;
            }else{
                $albums[$albumKey]['info']=0;
            }
        }
        if(empty($albums)) {
            echo false;
        }else{
            echo json_encode($albums);
        }
    }
    /**
     * 瀑布流分页
     */
    public  function flowAalgorithm(Request $request){
        $pageSize = $request->pageSize;
        $page     = $request->page;
        $skip =  $this->defautPage + $page*$pageSize;
        if(!Auth::check()){
            return false;
        }
        $user = $request->user();
        $email = $user['email'];
        $albums =
            album::where('email',$email)
                //-> orderByRaw("date_format(`lastmodefieddate`,'%m-%d') desc")
                //-> orderBy('like', 'desc')
                -> orderBy('created_at', 'desc')
                -> skip($skip)
                -> take($pageSize)
                -> get()
                -> toArray();
        if(empty($albums)) {
            echo false;
        }else{
            echo json_encode($albums);
        }
    }
    /**
     * 大图展示
     */
    public  function showMaxAlbum(Request $request){
        $albumId = $request->id;
        $user = $request->user();
        $email = $user['email'];
        $albums = album::where('email',$email)->where('id',$albumId)->get();
        $nextAlumId = album::where('email',$email)->where('id','<',$albumId)->max('id');
        $lastAlumId = album::where('email',$email)->where('id','>',$albumId)->min('id');
        return view('cloude.cloudealbummax',compact('albums','nextAlumId','lastAlumId'));
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
