<?php

namespace Frank\Cloudflare\Http\Controllers;

use App\Http\Controllers\Controller;
use Frank\Cloudflare\Helpers\Http;
use Illuminate\Http\Request;
use Config;
use Response;

class ZoneController extends SuperController
{
  
    /**
     * Gets all sites added to account on cloudflare
     * @param mixed $request
     * @return json
     */
    public function getMyZones(Request $request){
        $params = '';
        /** 
         * processes all the parameters sent along with the request
         * and skips the per_page option
        */
        foreach($request->all() as $key => $value){
            if($key == 'per_page') continue;
            $params .= "$key=$value&";
        }

        // Ensures that the result per page is set
        $params .= trim($this->perPage($request), '?');

        $url = $this->getApiUrl()."zones?$params";
        return Http::get($url, ['headers' => $this->getHeaders()]);
    }

    /**
     * Gets all sites added to account on cloudflare
     * @param mixed $request
     * @return json
     */
    public function addZone(Request $request){
        
        $data = $this->getUserAccount();
        $data['name'] = $request->name;
        $data['jump_start'] = true;

        $per_page = $this->perPage($request);
        $url = $this->getApiUrl()."zones";
       
        return Http::post($url, ['headers' => $this->getHeaders(),'json' => $data]);
    }

}