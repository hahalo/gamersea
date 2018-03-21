<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $table = 'articles';
    protected $fillable = ['title','content','author','typename','userid'];

    public static function fetchAll(){
        return self::orderBy('id', 'DESC')->paginate(100);
    }
    //mysql 5.7自然语言全文搜索模式
    public static function allBySearch($s){
        $query = "MATCH (title,content) AGAINST ('".$s."' IN NATURAL LANGUAGE MODE )";
        return self::whereRaw($query)
            ->paginate(100);
    }
    //文章类型缓存
    public static function fetchTypeNameAll(){
        $data = Cache::rememberForever('navs', function() {
            return self::groupby('typename')->get();
        });
        return $data;
    }
    
}
