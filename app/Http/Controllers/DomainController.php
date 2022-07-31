<?php

namespace App\Http\Controllers;

use App\Dtos\NotifiableAppDto;
use App\Repositories\NotifiableAppRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DomainController extends Controller
{
    private Request $request;
    private NotifiableAppRepository $notifiableAppRepository;

    public function __construct(
        Request $request,
        NotifiableAppRepository $notifiableAppRepository
    ) {
        $this->request = $request;
        $this->notifiableAppRepository = $notifiableAppRepository;
    }

    public function addDomain(): JsonResponse
    {
        $this->request->validate([
            'app_name' => 'required|string|unique:notifiable_apps,app_name',
            'url' => 'nullable|url',
            'ip' => 'nullable'
        ]);

        $notifiableApp = $this->notifiableAppRepository->addNewNotifiableApp(
            new NotifiableAppDto(
                $this->request->input('app_name'),
                $this->request->input('url'),
                $this->request->input('ip')
            )
        );

        return response()->json(
            [
                'id' => $notifiableApp->getId(),
                'app_name' => $notifiableApp->getAppName(),
                'app_key' => $notifiableApp->getAppKey(),
                'url' => $notifiableApp->getUrl(),
                'ip' => $notifiableApp->getIp()
            ]
            , Response::HTTP_CREATED);
    }
}
