<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /***
     * render the home page
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Home');
    }
}
