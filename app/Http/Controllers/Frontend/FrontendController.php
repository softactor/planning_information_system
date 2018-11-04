<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    /**
     * Show the application Login page.
     *
     * @return login view page
     */
    public function login()
    {
        $login  =   1;
        return view('frontend.login', compact('login'));
    }
}
