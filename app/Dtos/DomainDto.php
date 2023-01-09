<?php

namespace App\Dtos;

class DomainDto
{
    private string $domain;
    private ?string $ipv4;
    private ?string $ipv6;

    public function __construct(
        string $domain,
        ?string $ipv4 = null,
        ?string $ipv6 = null
    ) {
        $this->domain = $domain;
        $this->ipv4 = $ipv4;
        $this->ipv6 = $ipv6;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getIpv4(): ?string
    {
        return $this->ipv4;
    }

    public function getIpv6(): ?string
    {
        return $this->ipv6;
    }
}
