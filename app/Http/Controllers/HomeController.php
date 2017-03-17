<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the all domains.
     *
     * @return \Illuminate\Http\Response
     */
    public function domains()
    {
        $domains = Domain::all();
        return view('home')->with(['domains'=>$domains]);
    }
}
