<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Feedback;

class SmsGetWay extends Controller
{
    public function SendSMSDev($id, $sms)
    {
        return "Data Inserted with Id" . $id . " With" . $sms;
    }

    public function balance()
    {
        // Balance logic here
    }

    public function SendSMS($Feedback, $Sms)
    {
        $url    = "https://corpsms.banglalink.net/bl/api/v1/smsapigw/";
        $sender = "abcdefghijklmnopqrstuvwxyz1234567890";

        try {
            $credentials = [
                'username'      => config('services.sms.username'),
                'password'      => config('services.sms.password'),
                'apicode'       => "5",
                'msisdn'        => config('services.sms.msisdn'),
                'countrycode'   => '880',
                'cli'           => config('services.sms.sender_id'),
                'messagetype'   => '1',
                'message'       => $Sms,
                'clienttransid' => substr(str_shuffle($sender), 0, 10),
                'bill_msisdn'   => config('services.sms.sender_id'),
                'tran_type'     => 'T',
                'request_type'  => 'S',
                'rn_code'       => '91'
            ];

            $response = Http::withoutVerifying()->timeout(40)->post($url, $credentials);
            $status   = $response->json();
            if (isset($status['statusInfo']['statusCode']) && $status['statusInfo']['statusCode'] == "1000") {
                $Feedback->update(['sms_status' => 'sent']);
                return true;
            } else {
                $Feedback->update(['sms_status' => 'pending']);
                return false;
            }

        } catch (\Exception $e) {
            Log::error('SMS Gateway Error: ' . $e->getMessage());
            return false;
        }
    }
}