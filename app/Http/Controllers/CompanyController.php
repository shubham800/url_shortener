<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request){
        $companies = Company::withCount('user')->latest()->paginate(20);
        return view('companies.index', compact('companies'));
    }

    public function create(){
        return view('companies.create');
    }

    public function store(Request $request){
        $request->validate(['name' => ['required','string','max:255']]);
        Company::create(['name' => $request->name]);
        return redirect()->route('companies.index')->with('success', 'Company created!');
    }
}
