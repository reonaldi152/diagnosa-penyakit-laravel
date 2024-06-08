<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function user()
    {
        return view("admin.index");
    }

    public function admin()
    {
        return view("admin.index");
    }
}
