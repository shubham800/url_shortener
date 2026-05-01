<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    public function allUrls(Request $request){
        $urls = ShortUrl::with(['company','creator'])->latest()->paginate(20);
        return view('urls.all',compact('urls'));
    }
}
