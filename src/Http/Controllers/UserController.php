<?php

namespace Frank\Cloudflare\Http\Controllers;

use Frank\Cloudflare\Helpers\Http;
use Illuminate\Http\Request;
use Config;
use Response;

class UserController extends SuperController
{
 
    /**
     * Gets a user account from cloudflare
     * @return json
     */
    public function getUserAccount(){
       return parent::getUserAccount();
    }

}