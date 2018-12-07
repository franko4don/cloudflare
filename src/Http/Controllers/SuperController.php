<?php

namespace Frank\Cloudflare\Http\Controllers;

use App\Http\Controllers\Controller;
use Frank\Cloudflare\Helpers\Http;
use Illuminate\Http\Request;
use Config;
use Response;

class SuperController extends Controller
{
    private $headers;
    private $api_url;

    public function __construct(){
        $this->headers = [
            'X-Auth-Key' => Config::get('cloudflare.key'),
            'X-Auth-Email' => Config::get('cloudflare.email')
        ];
        $this->api_url = Config::get('cloudflare.url');
    }


    /**
     * Gets the headers for requests
     * @return mixed
     */
    public function getHeaders(){
        return $this->headers;
    }

    /**
     * Gets the headers for requests
     * @param array $array
     * @return mixed
     */
    public function setHeaders(Array $array){
        $this->headers = $array;
    }

    /**
     * Gets the api request url
     * @return string
     */
    public function getApiUrl(){
        return $this->api_url;
    }

    /**
     * Sets the api request url
     * @param string $url 
     * @return string
     */
    public function setApiUrl(string $url){
        $this->api_url = $url;
    }


    /**
     * Gets the headers for requests
     * @param array $array
     * @return mixed
     */
    public function addHeader(Array $array){
        foreach($array as $key => $value){
            $this->headers[$key] = $value; 
        }
        return $this->headers;
    }

    /**
     * Checks if pagination is specified in request
     * if it is specified and the parameter not an integer
     * the default value set in the config is used
     * @param mixed
     * @return string
     */
    public function perPage(Request $request){
        $per_page = isset($request->per_page) 
                    && is_numeric($request->per_page)
                    ? "?per_page=$request->per_page" 
                    : "?per_page=".Config::get('cloudflare.per_page');
        return $per_page;
    }

    /**
     * Gets all sites added to account on cloudflare
     * @param mixed $request
     * @return json
     */
    public function getUserAccount(){
        $url = $this->api_url."accounts";
        $response = Http::get($url, ['headers' => $this->getHeaders()]);
        $data = [
                "name" => $response['result'][0]['name'], 
                "id" => $response['result'][0]['id']
            ];
    
        $account = ["account" => $data];
        
        return $account;
    }


}