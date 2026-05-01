<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function create(Request $request){
        $user = $request->user();
        $companies = $user->isSuperAdmin() ? Company::all() : collect([$user->company]);
        $roles = $user->isSuperAdmin() ? ['Admin'] : ['Admin','Member'];
        
        return view('invitations.create',compact('companies', 'roles'));
    }

    public function store(Request $request){
        $user = $request->user();

        $validated = $request->validate([
            'email' => ['required','email'],
            'role' => ['required','in:Admin,Member'],
            'company_id' => ['required','exists:companies,id'],
        ]);

        // Super Admin can invite admin
        if($user->isSuperAdmin() && $validated['role'] != 'Admin'){
            return back()->withErrors(['role' => 'SuperAdmin can only invite Admins.']);
        }

        // Admin can invite in own company
        if($user->isAdmin() && $validated['company_id'] != $user->company_id){
            return back()->withErrors(['company_id' => 'Admin can only invite to their own company.']);
        }

        Invitation::create([
            'company_id' => $validated['company_id'],
            'invited_by' => $user->id,
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        // invite link
        $link = route('invitations.accept', Invitation::where('email',$validated['email'])->latest()->first()->token);

        return back()->with('success', "Invitation sent! Link: {$link}");
    }

    public function accept(string $token){
        $invitation = Invitation::where('token',$token)->whereNull('accepted_at')->firstOrFail();
        return view('invitations.accept',compact('invitation'));
    }

    public function register(Request $request, string $token){
        $invitation = Invitation::where('token',$token)->whereNull('accepted_at')->firstOrFail();

        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'password' => ['required','min:8','confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $invitation->email,
            'password' => $validated['password'],
            'role' => $invitation->role,
            'company_id' => $invitation->company_id,
        ]);

        $invitation->update(['accepted_at' => now()]);
        auth()->login($user);

        return redirect()->route('dashboard');
    }
}
