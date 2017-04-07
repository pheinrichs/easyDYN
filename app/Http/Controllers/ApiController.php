<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain;
use App\Helper;
use Validator;
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
        Validator::make($request->all(), [
            'token' => 'required',
            'name'=> 'required'
        ])->validate();

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

    /**
    * @param string $token Unique token entered into database
    * @param string $domain subdomain to update bind address
    *
    * @return response 200
    **/
    public function update_ip_url(Request $request, $name = null,$token = null) {
        if ($name == null ||$token == null) {
            return response('Name, and token are required', 200);
        }

        $line = null;
        $status = '';
        $domain = Domain::where('name',$name)->where('token',$token)->first();
        if($domain->active == 0) {
            return response('Entry disabled', 200);
        }

        $line = $this->cpanel->lookup_zone($name);
        $status = $this->cpanel->edit_record($line,$name,$request->ip());

        $domain->ip = $request->ip();
        $domain->save();


        return response('Success', 200);
    }
}
