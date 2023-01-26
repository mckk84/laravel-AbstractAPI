<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use App\Http\Helpers\AbstractAPI;

class WebscrapeController extends Controller
{
    public function index()
    {
        return view('webscrape');
    }

    public function requestapi(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $url = $request->request->get('url');
            if( $url == "" )
            {
                return response("Invalid Url", 400)->header('Content-Type', 'text/plain');
            } 
            $url_valid = filter_var($url, FILTER_VALIDATE_URL);
            if( !$url_valid )
            {
                return response("Bad Request", 400)->header('Content-Type', 'text/plain');  
            }
            try{
                $response = (new AbstractAPI())->make_request($url);
                return $response;
            }
            catch(ConnectionException $e)
            {
                return response("Host could not be resolved", 400)->header('Content-Type', 'text/plain');
            }
            catch(Exception $e)
            {
                return response("Error : ".$e->getMessage(), 400)->header('Content-Type', 'text/plain');   
            }
        } 
        else 
        {
            return response("Invalid Method", 400)->header('Content-Type', 'text/plain');
        }        
    }
}
