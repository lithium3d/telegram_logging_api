<?php

namespace App\Dtos;

class DomainPingDto
{
    private string $state;
    private ?string $content;

    public function __construct(
        string $state,
        ?string $content = null
    ) {
        $this->state = $state;
        $this->content = $content;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
}
