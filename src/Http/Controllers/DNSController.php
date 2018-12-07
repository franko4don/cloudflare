<?php

namespace Frank\Cloudflare\Http\Controllers;

use App\Http\Controllers\Controller;
use Frank\Cloudflare\Helpers\Http;
use Illuminate\Http\Request;
use Config;
use Response;

class DNSController extends SuperController
{
  
    /**
     * Gets all sites added to account on cloudflare
     * @param mixed $request
     * @return json
     */
    public function getDNSRecordsForZone(Request $request, $zone){
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

        $url = $this->getApiUrl()."zones/$zone/dns_records?$params";
        return Http::get($url, ['headers' => $this->getHeaders()]);
    }

    /**
     * Creates a record for a given zone
     * @param mixed $request
     * @param string $zone
     * @return json
     */
    public function createDNSRecordForZone(Request $request, $zone){
        $request = $request->all();

        foreach($request as $key => $value){

            if($key == 'proxied'){
                $request[$key] = $value == 'true' || $value == 1 ? true : false;
            }

            if($key == 'ttl'){
                $request[$key] = (int)$value;
            }

            if($key == 'priority'){
                $request[$key] = (int)$value;
            }
        }

        $url = $this->getApiUrl()."zones/$zone/dns_records";
        return Http::post($url, ['headers' => $this->getHeaders(), 'json' => $request]);
    }

}