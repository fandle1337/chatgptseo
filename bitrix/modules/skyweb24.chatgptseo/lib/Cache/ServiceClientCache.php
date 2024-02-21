<?php

namespace Skyweb24\ChatgptSeo\Cache;

use Bitrix\Main\ArgumentException;
use Skyweb24\ChatgptSeo\Exception\ExceptionHttpClient;
use Skyweb24\ChatgptSeo\Service\Api\Module\Client;
use Skyweb24\ChatgptSeo\Service\Api\Module\Dto\DtoClientInfo;

class ServiceClientCache
{
    public function __construct(
        protected Client $client,
        protected int    $ttl
    )
    {
    }

    /**
     * @throws ExceptionHttpClient
     */
    public function info(): DtoClientInfo
    {
        $hash = md5($_SERVER['SERVER_NAME']);

        if ($data = FacadeCache::getInstance()->get($hash, $this->ttl)) {
            return $data;
        }

        try {
            $data = $this->client->info();
        } catch (ArgumentException|\Exception $e) {
            throw new ExceptionHttpClient($e->getMessage(), $data);
        }

        FacadeCache::getInstance()->set($data, $hash, $this->ttl, ["api.client.info"]);

        return $data;
    }
}