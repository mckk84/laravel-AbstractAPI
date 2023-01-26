<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\Http;

class AbstractAPI
{
	public function make_request(string $url)
    {
    	$api_url = env('ABSTRACT_API_URL', '');
    	$api_key = env('ABSTRACT_KEY', '');
    	$api_url = trim($api_url);
    	$api_key = trim($api_key);

    	if( $api_url == "" || $api_key == "" )
    	{
    		return "Error Occured: ABSTRACT API configuration error.";
    	}

    	try
    	{
	    	$request_url = $api_url."?api_key=".$api_key."&url=".$url;
	        $res = Http::withHeaders([
	            "Content-Type" => "application/plain-text",
	        ])->get($url);

	        return $res;
    	} 
    	catch (Exception $e)
    	{
    		throw new ErrorException($e->getMessage());
    	}
    }

}