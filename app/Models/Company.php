<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Company extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function booted() : void
    {
        static::creating(function($company){
            $company->slug = Str::slug($company->name) . '-' . Str::random(5);
        });
    }

    public function user(){
        return $this->hasMany(User::class);
    }

    public function shortUrls(){
        return $this->hasMany(ShortUrl::class);
    }

    public function invitations(){
        return $this->hasMany(ShortUrl::class);
    }
}
