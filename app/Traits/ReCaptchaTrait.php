<?php

namespace App\Traits;

trait ReCaptchaTrait {

    // Docs:
    // https://developers.google.com/recaptcha/docs/verify
    public function recaptchaCheck($data)
    {
        // reCAPTCHA params
        $secret = env('RECAPTCHA_SECRET');
        $response = $data['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init($url);
        $params = [
            'secret' => $secret,
            'response' => $response,
            'remoteip' => $remoteip
        ];
        curl_setopt($ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );

        try {
            // Reponse format:
            // {
            //   "success": true|false,
            //   "challenge_ts": timestamp,  // timestamp of the challenge load (ISO format yyyy-MM-dd'T'HH:mm:ssZZ)
            //   "hostname": string,         // the hostname of the site where the reCAPTCHA was solved
            //   "error-codes": [...]        // optional
            // }
            $recaptcha = curl_exec($ch);
            $recaptcha = json_decode($recaptcha);
        } catch (Exception $e) {
            curl_close($ch);
            return 0;
        }
        curl_close($ch);

        return $recaptcha->success ? 1 : 0;
    }

}
