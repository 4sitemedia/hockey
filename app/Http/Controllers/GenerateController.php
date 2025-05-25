<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class GenerateController extends Controller
{
    /***
     * TODO
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return to_route('home');
    }
}
