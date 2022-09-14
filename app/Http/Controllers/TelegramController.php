<?php

namespace App\Http\Controllers;

use App\Dtos\LoggingDto;
use App\Notifications\ReportToTelegram;
use App\Repositories\LoggingRepository;
use App\Repositories\NotifiableAppRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class TelegramController extends Controller
{
    private Request $request;
    private NotifiableAppRepository $notifiableAppRepository;
    private LoggingRepository $loggingRepository;

    public function __construct(
        Request $request,
        NotifiableAppRepository $notifiableAppRepository,
        LoggingRepository $loggingRepository
    ) {
        $this->request = $request;
        $this->notifiableAppRepository = $notifiableAppRepository;
        $this->loggingRepository = $loggingRepository;
    }

    public function postToTelegram(): JsonResponse
    {
        $this->request->validate([
            'url' => 'required|url',
            'app_name' => 'required|string',
            'message' => 'required|string',
            'app_key' => 'required|string',
            'user_ip' => 'nullable'
        ]);

        $notifiableApp = $this->notifiableAppRepository->findByAppKey($this->request->input('app_key'));

        $url = 'https://' . filter_var(
            parse_url(
                $this->request->input('url'),
                PHP_URL_HOST
            ),
                FILTER_SANITIZE_URL);

        if (
            !strrpos($url, '.') &&
            filter_var($url, FILTER_VALIDATE_URL)
        ) {
            $url = env('APP_URL');
        }

        if (!is_null($notifiableApp)) {
            Notification::send(env('TELEGRAM_USER_ID'), new ReportToTelegram(
                $url,
                $this->request->input('app_name'),
                $this->request->input('message'),
                $this->request->ip(),
                $this->request->input('user_ip')
            ));
        }

        $this->loggingRepository->addLogging(
            new LoggingDto(
                $this->request->ip(),
                json_encode($this->request->all()),
                is_null($notifiableApp) ? 'disallowed' : 'allowed'
            ),
            $notifiableApp?->getId()
        );

        return response()->json('', Response::HTTP_ACCEPTED);
    }
}
