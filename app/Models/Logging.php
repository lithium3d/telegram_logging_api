<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Logging extends Model
{
    use HasFactory;

    protected $table = 'logging';

    protected $fillable = [
        'id',
        'ip',
        'content',
        'state',
        'notifiable_app_id'
    ];

    public function getId(): int
    {
        return $this->id;
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

    public function getNotifiableAppId(): ?int
    {
        return $this->notifiable_app_id;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    public function notifiableApp(): BelongsTo
    {
        return $this->belongsTo(NotifiableApp::class, 'notifiable_app_id', 'id');
    }
}
