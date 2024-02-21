<?php

namespace Skyweb24\ChatgptSeo\Interface;

interface InterfaceServiceAiModel
{
    public function getList(string $key, array $proxySettings): array|false;
}