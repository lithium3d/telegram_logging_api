<?php

namespace App\Repositories;

use App\Dtos\LoggingDto;
use App\Models\Logging;

class LoggingRepository
{
    private Logging $logging;

    public function __construct(
        Logging $logging
    ) {
        $this->logging = $logging;
    }

    public function addLogging(
        LoggingDto $loggingDto,
        int $notifiableAppId = null
    ): Logging {
        return $this->logging->create([
            'ip' => $loggingDto->getIp(),
            'content' => $loggingDto->getContent(),
            'state' => $loggingDto->getState(),
            'notifiable_app_id' => $notifiableAppId
        ]);
    }
}
