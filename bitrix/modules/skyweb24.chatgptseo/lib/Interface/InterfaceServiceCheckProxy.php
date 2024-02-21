<?php

namespace Skyweb24\ChatgptSeo\Interface;

interface InterfaceServiceCheckProxy
{
    public function check(string $address, int $port, string $login, string $password): bool;
}