<?php
/**
 * @author: MD. ADAL KAHN 
 * <mdadalkhan@gmail.com>
 * */

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Feedback;
use Exception;

class SmsGetWay extends Controller
{
    /**
     * Development helper for testing SMS output.
     */
    public function SendSMSDev(int|string $id, string $sms): string
    {
        return "Data Inserted with Id " . $id . " With " . $sms;
    }

    /**
     * Placeholder for checking API balance.
     */
    public function balance(): void
    {
        // To be implemented
    }

    /**
     * Send SMS via Banglalink Corporate Gateway.
     */
    public function SendSMS(Feedback $feedback, string $sms): bool
    {
        $url    = "https://corpsms.banglalink.net/bl/api/v1/smsapigw/";
        $senderChars = "abcdefghijklmnopqrstuvwxyz1234567890";

        try {
            /** @var array<string, string|null> $credentials */
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

            /** @var array<string, mixed> $status */
            $status = $response->json() ?? [];

            if (isset($status['statusInfo']['statusCode']) && (string)$status['statusInfo']['statusCode'] === "1000") {
                $feedback->update(['sms_status' => 'sent']);
                return true;
            }

            $feedback->update(['sms_status' => 'pending']);
            return false;

        } catch (Exception $e) {
            Log::error('SMS Gateway Error: ' . $e->getMessage());
            return false;
        }
    }
}