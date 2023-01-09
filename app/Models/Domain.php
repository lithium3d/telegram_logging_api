<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domain extends Model
{
    use HasFactory;

    protected $table = 'domains';

    protected $fillable = [
        'domain',
        'ipv_4',
        'ipv_6'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getIpv4(): ?string
    {
        return $this->ipv_4;
    }

    public function getIpv6(): ?string
    {
        return $this->ipv_6;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    public function domainPing(): HasMany
    {
        return $this->hasMany(
            DomainPing::class,
            'domain_id',
            'id'
        );
    }
}
