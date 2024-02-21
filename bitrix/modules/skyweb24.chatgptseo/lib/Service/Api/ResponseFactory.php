<?php

namespace Skyweb24\ChatgptSeo\Service\Api;


use Bitrix\Main\ArgumentException;
use Bitrix\Main\Web\Json;
use Skyweb24\ChatgptSeo\Exception\ExceptionHttpClient;

class ResponseFactory
{

    /**
     * @throws ExceptionHttpClient
     */
    public static function build(string $json): DtoResponse
    {
        $json = preg_replace('/\n\s+/', ' ', $json);

        try {
            $object = Json::decode($json);
        } catch (ArgumentException $e) {
            throw new ExceptionHttpClient($e->getMessage(), $json);
        }

        return new DtoResponse(
            $object['status'],
            $object['data'],
            $object['code'] ?? 200,
            $object['message'],
        );
    }
}