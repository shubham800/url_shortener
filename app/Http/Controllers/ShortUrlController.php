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

    public function create(){
        return view('urls.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'original_url' => ['required','string','max:2048'],
        ]);

        ShortUrl::create([
            'company_id' => $request->user()->company_id,
            'created_by' => $request->user()->id,
            'original_url' => $validated['original_url'],
        ]);

        return redirect()->back()->with('success', 'Short URL created!');
    }
}
