<?php

namespace App\Notifications;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramMessage;

class ReportToTelegram extends Notification
{
    use Queueable;

    private string $url;
    private string $appName;
    private string $message;
    private ?string $userIp;
    private string $ip;

    public function __construct(
        string $url,
        string $appName,
        string $message,
        string $ip,
        ?string $userIp = null
    ) {
        $this->url = $url;
        $this->appName = $appName;
        $this->message = $message;
        $this->userIp = $userIp;
        $this->ip = $ip;
    }

    public function via($notifiable): array
    {
        return ["telegram"];
    }

    public function toTelegram($notifiable): TelegramMessage
    {
        $ipDataKey = env('IP_DATA_KEY');
        $ipDataUrl = env('IP_DATA_URL');

        try {
            $location = json_decode(
                (new Client())
                    ->get("$ipDataUrl$this->userIp?api-key=$ipDataKey")
                    ->getBody()
                    ->getContents(),
                true
            );
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());

            try {
                $location = json_decode(
                    (new Client())
                        ->get("$ipDataUrl$this->ip?api-key=$ipDataKey")
                        ->getBody()
                        ->getContents(),
                    true
                );
            } catch (GuzzleException $e) {
                Log::error('Server ip error:  ' . $e->getMessage());
            }
        }

        $city = $location['city'] ?? null;
        $region = $location['region'] ?? null;
        $country = $location['country_name'] ?? null;
        $continent = $location['continent_name'] ?? null;


        return TelegramMessage::create()
            ->to($notifiable)
            ->content(
                "$this->message\nIp addres: $this->ip\nUser ip adress: $this->userIp\nCity: $city\nRegion: $region\nCountry: $country\nContinent: $continent"
            )
            ->options(['parse_mode' => ''])
            ->button($this->appName, $this->url);
    }
}
