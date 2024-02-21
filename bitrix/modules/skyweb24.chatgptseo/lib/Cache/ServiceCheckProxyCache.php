<?php

namespace Skyweb24\ChatgptSeo\Cache;

use Skyweb24\ChatgptSeo\Interface\InterfaceServiceCheckProxy;
use Skyweb24\ChatgptSeo\Service\ServiceCheckProxy;

class ServiceCheckProxyCache implements InterfaceServiceCheckProxy
{
    public function __construct(
        protected ServiceCheckProxy $serviceCheckProxy,
        protected int               $ttl,
    )
    {
    }

    public function check(string $address, int $port, string $login, string $password): bool
    {
        $hash = md5($address . $port . $login . $password);

        if ($data = FacadeCache::getInstance()->get($hash, $this->ttl)) {
            return $data;
        }

        $data = $this->serviceCheckProxy->check(
            $address,
            $port,
            $login,
            $password,
        );

        FacadeCache::getInstance()->set($data, $hash, $this->ttl, ["proxy.settings"]);

        return $data;
    }
}