<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomainPing extends Model
{
    use HasFactory;

    protected $table = 'domain_ping';

    protected $fillable = [
        'domain_id',
        'state',
        'content'
    ];

    public const SUCCESS = 'pinged';
    public const FAILED = 'failed';

    public function getId(): int
    {
        return $this->id;
    }

    public function domainId(): int
    {
        return $this->domain_id;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    public function domain(): BelongsTo
    {
        return $this->belongsTo(
            Domain::class,
            'domain_id',
            'id'
        );
    }
}
