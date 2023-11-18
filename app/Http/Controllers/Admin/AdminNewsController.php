<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\News;

class AdminNewsController 
{
    public function getNews(){
       $news = News::all();
       return $news;
    }

    public function addNews(Request $request){
        $content = $request->content;
        $date = $request->date;
        $result = News::create([
            'content' => $content,
            'date' => $date
        ]);
        if($result){
            return ['success' => 'Đăng bài thành công !'];
        } else {
            return ['error' => "Lỗi !"];
        }
    }
}
