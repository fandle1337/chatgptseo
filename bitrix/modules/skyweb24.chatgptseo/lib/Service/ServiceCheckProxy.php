<?php

namespace Skyweb24\ChatgptSeo\Service;

use Bitrix\Main\Web\HttpClient;
use Skyweb24\ChatgptSeo\Interface\InterfaceServiceCheckProxy;

class ServiceCheckProxy implements InterfaceServiceCheckProxy
{
    public function __construct(
        protected HttpClient $httpClient,
    )
    {
    }

    public function check(string $address, int $port, string $login, string $password): bool
    {
        try {
            $response = $this->httpClient->setProxy($address, $port, $login, $password)->get("https://www.google.ru");
        } catch (\Exception $e) {
            return false;
        }

        return $response !== false;
    }
}