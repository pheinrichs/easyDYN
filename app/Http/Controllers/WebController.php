<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain;
use App\Helper;

class WebController extends Controller
{
    private $cpanel;

    function __construct(){
        $this->cpanel = new Helper;
    }

    /**
     * Show the new domain form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (env('CPANEL_DOMAIN') !== null ||
        env('CPANEL_URL') !== null
        || env('CPANEL_USER') !== null
        || env('CPANEL_PASS') !== null ) {
            return view('new');
        }
        else {
            return redirect('/domains')->with('errors',"Some of your cPanel variables are not set, check the .env file and run  'php artisan config:cache' in the command line");
        }

    }

    /**
     * Show the all domains.
     *
     * @return \Illuminate\Http\Response
     */
    public function domains()
    {
        $domains = Domain::paginate(15);
        return view('all')->with(['domains'=>$domains]);
    }
    /**
     * Delete a domain.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $domain = Domain::find($request->id);
        $line = $this->cpanel->lookup_zone($domain->name);
        if ($line == null) {
            $remove = Domain::find($request->id);
            $remove->delete();
            return redirect('/')->with('status', 'Unable to find zone entry in cPanel, Deleting from local db.');
        }
        $data = $this->cpanel->delete_record($line);
        if($data->cpanelresult->data[0]->result->status == 1) {
            $domain->delete();
            $request->session()->flash('status', 'Removed Entry!');
            return redirect('/');
        }
        else {
            return redirect('/')->with('status', $data->cpanelresult->data[0]->reason);
        }
    }

    /**
     * Toggle a domains status.
     *
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request)
    {
        $domain = Domain::find($request->id);
        $domain->active = !$domain->active;
        $domain->save();
        if($domain->active == 1) {
            $request->session()->flash('status', 'Enabled entry!');
        }
        else {
            $request->session()->flash('status', 'Disabled Entry!');
        }

        return redirect('/');

    }

    /**
     * Add a new Domain entry
     *
     * @return \Illuminate\Http\Response
     */
    public function new(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:Domain|max:50'
        ]);
        $request->name = str_slug($request->name);
        $data = $this->cpanel->add_record($request->name,$request->ip());
        if ($data == null) {
            $domain = new Domain;
            $domain->name = $request->name;
            $domain->token = str_random(30);
            $domain->ip = $request->ip();
            $domain->save();
            return redirect('/domains')->with('status', 'Entry was already found in cPanel, added to local DB.');
        }
        if($data->cpanelresult->data[0]->result->status == 1) {
            $domain = new Domain;
            $domain->name = $request->name;
            $domain->token = str_random(30);
            $domain->ip = $request->ip();
            $domain->save();
            return redirect('/domains')->with('status', 'Added entry!');
        }
        else {
            return redirect('/domains')->with('status', $data->cpanelresult->data[0]->reason);
        }
    }

    /**
     * Toggle a domains status.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_ip(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'domain'=> 'required'
        ]);
        $status = '';

        $line = $this->cpanel->lookup_zone($domain);
        $status = $this->cpanel->edit_record($line,$domain,$request->ip());

        $domain->ip = $request->ip();
        $domain->save();

        return redirect('/domains')->with('status', $status);
    }
}
