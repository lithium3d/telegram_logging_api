<?php

namespace App\Repositories;

use App\Dtos\NotifiableAppDto;
use App\Models\NotifiableApp;

class NotifiableAppRepository
{
    private NotifiableApp $notifiableApp;

    public function __construct(
        NotifiableApp $notifiableApp
    ) {
        $this->notifiableApp = $notifiableApp;
    }

    public function addNewNotifiableApp(NotifiableAppDto $notifiableAppDto): NotifiableApp
    {
        /** @var NotifiableApp $new */
        $new = $this->notifiableApp->make();
        $new->fill([
            'app_name' => $notifiableAppDto->getAppName(),
            'url' => $notifiableAppDto->getUrl(),
            'ip' => $notifiableAppDto->getIp()
        ]);
        $new->setAppKey();

        $new->save();

        return $new;
    }

    public function findByAppKey(string $key): ?NotifiableApp
    {
        return $this->notifiableApp->where('app_key', $key)->first();
    }
}
