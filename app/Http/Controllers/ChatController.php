<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Redis\Connections\PredisConnection;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendMessage(Request $request)
    {
        $redis = PredisConnection::connection();

        $data = ['message' => Request::input('message'), 'user' => Request::input('user')];

        $redis->publish('message', json_encode($data));

        return response()->json(['success' => true]);
    }
}
