<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShortUrl extends Model
{
    protected $fillable = ['company_id', 'created_by', 'original_url', 'short_code'];

    protected static function booted() : void
    {
        static::creating(function($url){
            do{
                $code = Str::random(7);
            } while(self::where('short_code', $code)->exists());
            $url->short_code = $code;
        });
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
