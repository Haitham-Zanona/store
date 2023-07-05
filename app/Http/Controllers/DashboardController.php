<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct(){
        //$this->middleware(['auth','verified']); #Authenticates user and verified email address before
    }
    //Actions
    public function index() {
        $title = 'Store';
        $user = Auth::user();
        //Return response: view, json, redirect, file
        return view('dashboard.index', [
            "title" => $title,
            "user"  => $user
        ]);
    }
}
