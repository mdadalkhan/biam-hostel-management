<?php
/**
 * @author: MD. ADAL KAHN <mdadalkhan@gmail.com>
 * @created_at 29/01/2026
 * @updated_at 10/02/2026
 * */

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Feedback;
use Exception;

class SmsGetWay extends Controller
{
    public function SendSMSDev(int|string $id, string $sms): string
    {
        return "Data Inserted with Id " . $id . " With " . $sms;
    }

    public function balance(): void
    {
    }

    public function SendSMS(Feedback $feedback, string $sms): bool
    {
        $url = "https://corpsms.banglalink.net/bl/api/v1/smsapigw/";
        $senderChars = "abcdefghijklmnopqrstuvwxyz1234567890";

        try {
            $credentials = [
                'username'      => config('services.sms.username'),
                'password'      => config('services.sms.password'),
                'apicode'       => "5",
                'msisdn'        => config('services.sms.msisdn'),
                'countrycode'   => '880',
                'cli'           => config('services.sms.sender_id'),
                'messagetype'   => '1',
                'message'       => $sms,
                'clienttransid' => substr(str_shuffle($senderChars), 0, 10),
                'bill_msisdn'   => config('services.sms.sender_id'),
                'tran_type'     => 'T',
                'request_type'  => 'S',
                'rn_code'       => '91'
            ];

            $response = Http::withoutVerifying()
                ->timeout(40)
                ->post($url, $credentials);

            $status = $response->json() ?? [];

            if (isset($status['statusInfo']['statusCode']) && (string)$status['statusInfo']['statusCode'] === "1000") {
                $feedback->update(['sms_status' => 'sent']);
                return true;
            }

            $feedback->update(['sms_status' => 'failed']);
            return false;

        } catch (Exception $e) {
            Log::error('SMS Gateway Error: ' . $e->getMessage());
            return false;
        }
    }
}