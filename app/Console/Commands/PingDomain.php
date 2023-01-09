<?php

namespace App\Console\Commands;

use App\Services\PingService;
use Illuminate\Console\Command;

class PingDomain extends Command
{
    protected $signature = 'domain:ping-domain';
    protected $description = 'Ping domains';

    private PingService $pingService;

    public function __construct(
        PingService $pingService
    ) {
        $this->pingService = $pingService;
        parent::__construct();
    }

    public function handle(): void
    {
        $this->pingService->pingDomains();
    }
}
