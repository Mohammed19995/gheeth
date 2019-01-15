<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestSend extends Controller
{


    public function sendNotify(Request $request) {
        $body = [];
        $arr = [];
        $body['Call_Status'] = $request->Call_Status;
        $body['Channel_ID'] = $request->Channel_ID;
        $body['End_Time'] = $request->End_Time;
        $body['InviteSender'] = $request->InviteSender;
        $body['InviteStatus'] = $request->InviteStatus;
        $body['Key'] = $request->Key;
        $body['Start_Time'] =$request->Start_Time;
        $body['Status'] = $request->Status;
        $body['TimeStamp'] = $request->TimeStamp;
        $body['Type'] = $request->Type;
        $body['UserInvited'] =$request->UserInvited;
        $body['UserReceiver'] = $request->UserReceiver;
        $body['UserSender'] = $request->UserSender;


        $arr['token'] = $request->token;
        $arr['body'] = $body;
        $this->pushNotification($arr);
    }

    public function pushNotification($arr)
    {

        $deviceToken = $arr['token'];

       //Server stuff
        $passphrase = '';

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'ipad_sandbox.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        $fp = stream_socket_client(
            'ssl://gateway.sandbox.push.apple.com:2195', $err,
            $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        echo 'Connected to APNS' . PHP_EOL;

        $payload = json_encode($arr['body']);

// Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        if (!$result)
            //  echo 'Message not delivered' . PHP_EOL;
           // echo responseJson(false, 'Message not delivered' . PHP_EOL);
            return response()->json('Message not delivered' );
        else
           // echo responseJson(true, 'Message successfully delivered' . PHP_EOL);
        //  echo 'Message successfully delivered' . PHP_EOL;
            return response()->json('Message successfully delivered' );

        fclose($fp);

    }
}
