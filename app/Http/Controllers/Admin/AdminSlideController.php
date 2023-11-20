<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Models\Slide;

class AdminSlideController 
{
    public function getSlides(){
    $slides = [
        "https://firebasestorage.googleapis.com/v0/b/spotify-clone-3a9fc.appspot.com/o/slides%2F1.jpg?alt=media&token=bc4d1435-0a4f-402d-a338-935c2418185a",
        "https://firebasestorage.googleapis.com/v0/b/spotify-clone-3a9fc.appspot.com/o/slides%2F2.jpg?alt=media&token=99d3a435-0fb6-4ae8-98e9-bb276392ae33",
        "https://firebasestorage.googleapis.com/v0/b/spotify-clone-3a9fc.appspot.com/o/slides%2F3.jpg?alt=media&token=433c94d5-23e9-452e-97c6-d605fc68fec1",
        "https://firebasestorage.googleapis.com/v0/b/spotify-clone-3a9fc.appspot.com/o/slides%2F4.jpg?alt=media&token=f170b290-1de8-4f10-a642-bb7c5217c026",
        "https://firebasestorage.googleapis.com/v0/b/spotify-clone-3a9fc.appspot.com/o/slides%2F5.jpg?alt=media&token=fa88ee3c-b00a-4efe-bafd-bcadb48285ef",
        "https://firebasestorage.googleapis.com/v0/b/spotify-clone-3a9fc.appspot.com/o/slides%2F6.jpg?alt=media&token=4c4483c8-310e-4696-964c-500fd28251f5",
        "https://firebasestorage.googleapis.com/v0/b/spotify-clone-3a9fc.appspot.com/o/slides%2F7.jpg?alt=media&token=5e93fefd-3597-44ed-aeba-170a5e9b9d54"
    ];
     
    $slidesCollection = collect($slides)->map(function ($slide, $key) {
        return [
            'id' => $key + 1,
            'image' => $slide
        ];
    });
    
    $randomSlides = $slidesCollection->shuffle();
    return response()->json($randomSlides, 200);
    }

}
