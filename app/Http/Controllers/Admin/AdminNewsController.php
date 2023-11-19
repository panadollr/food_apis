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
            return ['success' => 'Đăng bài viết thành công !'];
        } else {
            return ['error' => "Lỗi !"];
        }
    }

    public function updateNews(Request $request){
        $id = $request->id;
        News::find($id)->update([
            'content' => $request->content,
            'date' => $request->date
        ]);
        return response()->json(['success' => "Cập nhật bài viết thành công !"], 200);
    }
}
