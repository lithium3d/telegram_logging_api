<?php

namespace App\Dtos;

class LoggingDto
{
    private string $ip;
    private string $content;
    private string $state;

    public function __construct(
        string $ip,
        string $content,
        string $state
    ) {
        $this->ip = $ip;
        $this->content = $content;
        $this->state = $state;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getState(): string
    {
        return $this->state;
    }
}
