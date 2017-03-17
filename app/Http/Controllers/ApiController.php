<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain;
use App\Helper;
class ApiController extends Controller
{
    private $cpanel;

    function __construct(){
        $this->cpanel = new Helper;
    }

    /**
    * @param string $token Unique token entered into database
    * @param string $domain subdomain to update bind address
    *
    * @return response 200
    **/
    public function update_ip(Request $request) {
        $this->validate($request, [
            'token' => 'required',
            'name'=> 'required'
        ]);
        $line = null;
        $status = '';
        $domain = Domain::where('name',$request->name)->where('token',$request->token)->first();
        if($domain->active == 0) {
            return response('Entry disabled', 200);
        }

        $line = $this->cpanel->lookup_zone($request->name);
        $status = $this->cpanel->edit_record($line,$request->name,$request->ip());

        $domain->ip = $request->ip();
        $domain->save();


        return response('Success', 200);
    }
}
