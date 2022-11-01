<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Notifications\AccountApproved;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Notification;

class PushController extends Controller
{
    public function store(Request $request){
        $this->validate($request,[
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $guest = Guest::firstOrCreate([
            'endpoint' => $endpoint
        ]);

        // return $guest;
        $guest->updatePushSubscription($endpoint, $key, $token);
        // 
        return response()->json(['success' => true],200);
    }


    public function push(){

        
        Notification::send(Guest::all(),new AccountApproved);
        return 'radwa';
    }
}
