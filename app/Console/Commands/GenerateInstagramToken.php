<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateInstagramToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:instagram-token {code?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an Instagram token.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $code = $this->argument('code');

        if (empty($code)) {
            echo "Go to this URL to retrieve code:\n";
            echo "https://api.instagram.com/oauth/authorize/?client_id=bbaedac506744cd08c70056e23352e1f&redirect_uri=https%3A%2F%2Fsportsbusiness.solutions%2F&response_type=code\n\n";
            echo "Then, run: php artisan generate:instagram-token {code}\n";
            return;
        }

        $url = "https://api.instagram.com/oauth/access_token";
        $ch = curl_init($url);
        $params = [
            'client_id' => env('INSTAGRAM_CLIENT_ID'),
            'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'https://sportsbusiness.solutions/',
            'code' => $code
        ];
        curl_setopt($ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );

        try {
            $json = curl_exec($ch);
            $response = json_decode($json);
            $token = $response->access_token;
            if (!$token) {
                throw new \Exception("Response (" . $json . ") does not include access token");
            }
        } catch (\Exception $e) {
            curl_close($ch);
            echo "Failed to get access token.\n";
            echo $e->getMessage();
            return;
        }
        curl_close($ch);

        echo "Set INSTAGRAM_ACCESS_TOKEN environment variable: " . $token . "\n";
    }
}
