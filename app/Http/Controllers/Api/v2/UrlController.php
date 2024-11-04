<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\v2\UrlResource;
use App\Http\Requests\ShowLongUrlRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreShortUrlRequest;



class UrlController extends Controller
{
    public function jsonResponse($status, $message = null, $data = null,  $code){
        return response()->json([
            "status"=> $status,
            "data" => $data,
            "message"=> $message,
        ], $code);
    }
    public function index(){
        $urls = Url::where('user_id', auth()->user()->id)->get();

        return $this->jsonResponse( true, 'success', UrlResource::collection($urls), 200 );
    }

    public function storeShortUrl(StoreShortUrlRequest $request){

        $user = Auth::user();
        if(!$user){
            return $this->jsonResponse(false,  "User not authenticated", null, 401 );
        }
        $longUrl = $request->long_url;
        $existingUrl = Url::where("long_url", $longUrl)->first();

        if ($existingUrl) {
            $shortUrl = $existingUrl->short_url;

            return $this->jsonResponse(true, "ShortUrl retrieved successfully", new UrlResource($existingUrl), 200);
        }else{
            $shortUrl = Url::generateShortUrl($longUrl);

            $url = Auth::user()->urls()->create([
                "long_url"=> $longUrl,
                "short_url" => $shortUrl,
            ]);
            if (!$url) {
                return $this->jsonResponse( false,"Short_url is not created successfully", null, 404 );
            }

            return $this->jsonResponse( true,"Short_url created successfully", new UrlResource($url), 201 );
        }
    }

    public function showLongUrl(ShowLongUrlRequest $request)  {

        $shortUrl = $request->short_url;
        $url = Url::where('short_url', $shortUrl)->first();
        if(!$url){
            return $this->jsonResponse(false, "Short URL not found", null, 404);
        }
        $longUrl = $url->long_url;
        return $this->jsonResponse(true, "Long url is found", new UrlResource($url), 200 );
    }

    public function redirectShortUrl($shortUrl){
        $url = Url::where('short_url', $shortUrl)->first();
        if(!$url){
            return $this->jsonResponse(false,'This Shorten url not found in database!', null, 404 );
        }

        $url->increment('visit_count');
        $longUrl = $url->long_url;
        return redirect()->away($longUrl);
    }

}
