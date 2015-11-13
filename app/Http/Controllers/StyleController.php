<?php

namespace App\Http\Controllers;

// use App\User;
use App\Http\Controllers\Controller;

class StyleController extends Controller {

    public function style()
    {
        return View::make('site.pages.style');
    }

}
