<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class NotifiableApp extends Model
{
    use HasFactory;

    protected $table = 'notifiable_apps';

    protected $fillable = [
        'app_name',
        'app_key',
        'url',
        'ip'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getAppName(): string
    {
        return $this->app_name;
    }

    public function setAppKey(): self
    {
        $this->app_key = Uuid::uuid4()->toString();

        return $this;
    }

    public function getAppKey(): string
    {
        return $this->app_key;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }
}
