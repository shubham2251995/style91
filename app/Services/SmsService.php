<?php

namespace App\Services;

use App\Models\SystemConfiguration;
use Illuminate\Support\Facades\Http;

class SmsService
{
    protected $authKey;
    protected $senderId;
    protected $baseUrl = 'https://api.msg91.com/api/v5/flow/';

    public function __construct()
    {
        $this->authKey = SystemConfiguration::where('key', 'msg91_auth_key')->value('value');
        $this->senderId = SystemConfiguration::where('key', 'msg91_sender_id')->value('value');
    }

    public function sendOtp($mobile, $otp)
    {
        if (!$this->authKey) {
            \Log::warning('MSG91 Auth Key not configured.');
            return false;
        }

        $templateId = SystemConfiguration::where('key', 'msg91_otp_template')->value('value');

        try {
            $response = Http::withHeaders([
                'authkey' => $this->authKey,
                'content-type' => 'application/json'
            ])->post($this->baseUrl, [
                'template_id' => $templateId,
                'short_url' => '1',
                'recipients' => [
                    [
                        'mobiles' => '91' . $mobile,
                        'otp' => $otp
                    ]
                ]
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            \Log::error('MSG91 Error: ' . $e->getMessage());
            return false;
        }
    }
}
