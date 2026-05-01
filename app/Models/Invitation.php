<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    protected $fillable = ['company_id', 'invited_by', 'email', 'role', 'token', 'accepted_at'];

    protected function casts(): array
    {
        return [
            'accepted_at' => 'datetime',
        ];
    }

    public static function booted() : void
    {
        static::creating(function($inv){
            $inv->token = Str::random(40);
        });
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function invitedBy(){
        return $this->belongsTo(User::class, 'invited_by');
    }
}
