<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class Notification extends Controller
{
    public function notification()
    {
        $response = Http::get('http://localhost:3030/notification');
        $collection = $response->collect();

        return view('notification', ['collection' => $collection]);
    }
}