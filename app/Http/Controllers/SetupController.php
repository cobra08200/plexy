<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SetupController extends Controller
{
    public function firstRun()
    {
        return view('installer.welcome');
    }
}
