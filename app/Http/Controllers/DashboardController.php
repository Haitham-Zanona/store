<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Actions
    public function index() {
        //Return response: view, json, redirect, file
        return view('dashboard');
    }
}
