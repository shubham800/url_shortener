<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    // Show All URLs to Super Admin 
    public function allUrls(Request $request){
        $urls = ShortUrl::with(['company','creator'])->latest()->paginate(20);
        return view('urls.all',compact('urls'));
    }

    // Show own company's URLs to Admin
    public function index(Request $request){
        $urls = ShortUrl::with('creator')->where('company_id',$request->user()->company_id)->latest()->paginate(20);
        return view('urls.index',compact('urls'));
    }

    // Show own URLs to Member
    public function myUrls(Request $request){
        $urls = ShortUrl::where('created_by',$request->user()->id)->latest()->paginate(20);
        return view('urls.mine',compact('urls'));
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

    // Resolve Short URLs
    public function resolve(string $code){
        $url = ShortUrl::where('short_code',$code)->firstOrFail();
        $url->increment('hits');
        return redirect()->away($url->original_url);
    }
}
