<?php

namespace App\Dtos;

class NotifiableAppDto
{
    private string $appName;
    private ?string $url;
    private ?string $ip;

    public function __construct(
        string $appName,
        ?string $url,
        ?string $ip
    ) {
        $this->appName = $appName;
        $this->url = $url;
        $this->ip = $ip;
    }

    public function getAppName(): string
    {
        return $this->appName;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }
}
