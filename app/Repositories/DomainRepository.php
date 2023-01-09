<?php

namespace App\Repositories;

use App\Dtos\DomainDto;
use App\Dtos\DomainPingDto;
use App\Models\Domain;
use App\Models\DomainPing;
use Illuminate\Support\Collection;

class DomainRepository
{
    private Domain $domain;
    private DomainPing $domainPing;

    public function __construct(
        Domain $domain,
        DomainPing $domainPing
    ) {
        $this->domain = $domain;
        $this->domainPing = $domainPing;
    }

    public function find(int $id): ?Domain
    {
        return $this->domain->find($id);
    }

    public function get(): Collection
    {
        return $this->domain->get();
    }

    public function create(DomainDto $domainDto): Domain
    {
        return $this->domain->create([
            'domain' => $domainDto->getDomain(),
            'ipv_4' => $domainDto->getIpv4(),
            'ipv_6' => $domainDto->getIpv6()
        ]);
    }

    public function findLastDomainPing(int $domainId): ?Domain
    {
        return $this->domainPing->where('domain_id', $domainId)->first();
    }

    public function addDomainPing(
        int $domainId,
        DomainPingDto $domainPingDto
    ): DomainPing {
        return $this->domainPing->create([
            'domain_id' => $domainId,
            'state' => $domainPingDto->getState(),
            'content' => $domainPingDto->getContent()
        ]);
    }
}
