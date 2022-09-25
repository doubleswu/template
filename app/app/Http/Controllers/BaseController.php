<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function ruleForParams(Request $request, array $rules)
    {
        $request -> validate($rules);
    }
}
