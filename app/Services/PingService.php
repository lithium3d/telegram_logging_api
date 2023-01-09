<?php

namespace App\Services;

use App\Dtos\DomainPingDto;
use App\Models\Domain;
use App\Models\DomainPing;
use App\Notifications\ReportToTelegram;
use App\Repositories\DomainRepository;
use Exception;
use Illuminate\Support\Facades\Notification;

class PingService
{
    private DomainRepository $domainRepository;

    public function __construct(
        DomainRepository $domainRepository
    ) {
        $this->domainRepository = $domainRepository;
    }

    public function pingDomains(): void
    {
        $domains = $this->domainRepository->get();

        /** @var Domain $domain */
        foreach ($domains as $domain) {
            if (self::checkDomainExistance($domain->getDomain())) {
                $this->domainRepository->addDomainPing(
                    $domain->getId(),
                    new DomainPingDto(
                        DomainPing::SUCCESS
                    )
                );

                continue;
            }

            $this->domainRepository->addDomainPing(
                $domain->getId(),
                new DomainPingDto(
                    DomainPing::FAILED
                )
            );

            $this->report($domain);
        }
    }

    public static function checkDomainExistance(string $domain): bool
    {
        $extension = 'http';

        if (self::checkSslCertificateForDomain($domain)) {
            $extension = 'https';
        }
        try {
            if (!strpos('http', $domain)) {
                $domain = "$extension://$domain";
            }

            if (str_contains(get_headers($domain)[0], 'HTTP/1.1')) {
                return true;
            }
        } catch (Exception $e) {
            //
        }

        return false;
    }

    public static function checkSslCertificateForDomain(string $domain): bool
    {
        try {
            $cert = stream_context_get_params(
                stream_socket_client(
                    "ssl://" . $domain . ":443",
                    $errno,
                    $errStr,
                    30,
                    STREAM_CLIENT_CONNECT,
                    stream_context_create([
                            'ssl' => [
                                'capture_peer_cert' => TRUE,
                            ],
                        ]
                    )
                )
            );

            $certInfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);

            if (!empty($certInfo)) {
                if (
                    isset($certInfo['name']) && !empty($certInfo['name']) &&
                    isset($certInfo['issuer']) && !empty($certInfo['issuer'])
                ) {
                    return true;
                }
            }
        } catch (Exception $e) {
            //
        }

        return false;
    }

    public function report(Domain $domain): void
    {
        Notification::send(env('TELEGRAM_USER_ID'), new ReportToTelegram(
            $domain->getDomain(),
            'Check on website',
            'Ping failed',
            '1234',
            '1234'
        ));
    }
}
