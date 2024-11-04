<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Url extends Model
{
    use HasFactory;

    protected $fillable = [ "long_url" , "user_id", "short_url"];

    public static function generateShortUrl($longUrl){
        $existingUrl = Url::where("long_url", $longUrl)->first();
        if($existingUrl){
            return $existingUrl->$existingUrl;
        }

        do {
            $shortUrl = Str::random(6);
        } while (self::where("short_url", $shortUrl)->exists());
        return $shortUrl;
    }


}
