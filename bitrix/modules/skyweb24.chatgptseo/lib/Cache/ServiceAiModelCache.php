<?php

namespace Skyweb24\ChatgptSeo\Cache;

use Skyweb24\ChatgptSeo\Interface\InterfaceServiceAiModel;
use Skyweb24\ChatgptSeo\Service\ServiceAiModel;

class ServiceAiModelCache implements InterfaceServiceAiModel
{
    public function __construct(
        protected ServiceAiModel $serviceAiModel,
        protected int            $ttl
    )
    {
    }

    public function getList(string $key, array $proxySettings): false|array
    {
        $hash = md5($key);

        if ($data = FacadeCache::getInstance()->get($hash, $this->ttl)) {
            return $data;
        }

        $data = $this->serviceAiModel->getList(
            $key,
            $proxySettings
        );

        FacadeCache::getInstance()->set($data, $hash, $this->ttl, ["ai.models"]);

        return $data;
    }
}