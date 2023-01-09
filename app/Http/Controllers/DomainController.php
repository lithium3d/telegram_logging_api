<?php

namespace App\Http\Controllers;

use App\Dtos\DomainDto;
use App\Dtos\NotifiableAppDto;
use App\Repositories\DomainRepository;
use App\Repositories\NotifiableAppRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DomainController extends Controller
{
    private Request $request;
    private NotifiableAppRepository $notifiableAppRepository;
    private DomainRepository $domainRepository;

    public function __construct(
        Request $request,
        NotifiableAppRepository $notifiableAppRepository,
        DomainRepository $domainRepository
    ) {
        $this->request = $request;
        $this->notifiableAppRepository = $notifiableAppRepository;
        $this->domainRepository = $domainRepository;
    }

    public function addReportDomain(): JsonResponse
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

    public function addPingDomain(): JsonResponse
    {
        $this->request->validate([
            'domain' => 'required|string|unique:domains,domain',
            'ipv_4' => 'nullable',
            'ipv_6' => 'nullable'
        ]);

        $domain = $this->domainRepository->create(
            new DomainDto(
                $this->request->input('domain')
            )
        );

        return response()->json([
            'id' => $domain->getId(),
            'domain' => $domain->getDomain()
        ], Response::HTTP_CREATED);
    }
}
