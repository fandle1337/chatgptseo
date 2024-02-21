<?php

namespace Skyweb24\ChatgptSeo\Service\Api\Module;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Web\Json;
use Exception;
use Skyweb24\ChatgptSeo\Exception\ExceptionHttpClient;
use Skyweb24\ChatgptSeo\Service\Api\DtoResponse;
use Skyweb24\ChatgptSeo\Service\Api\Module\Dto\DtoClientInfo;
use Skyweb24\ChatgptSeo\Service\Api\ResponseFactory;

class Client
{
    const HTTP_API_SERVER = "https://service.api.chatgptseo.skyweb24.ru/api";

    public function __construct(
        protected HttpClient $httpClient,
        protected string     $bitrixLicenseKey,
        protected string     $moduleCode
    )
    {
    }


    /**
     * @throws ExceptionHttpClient
     */
    public function prompt(string $text, int $taskId, int $elementId, string $gptModel, bool $timeout = false): ?string
    {
        try {
            $json = $this->httpClient->post(self::HTTP_API_SERVER . "/gpt/prompt/", Json::encode([
                "license_key" => $this->bitrixLicenseKey,
                "module_code" => $this->moduleCode,
                "prompt"      => $text,
                "task_id"     => $taskId,
                "element_id"  => $elementId,
                "gpt_code"    => $gptModel,
            ]));

            if (!$dtoResponse = $this->checkResponseStatus(ResponseFactory::build($json))) {
                throw new ExceptionHttpClient($dtoResponse->data, $dtoResponse->status);
            }

            if ($timeout) {
                sleep($dtoResponse->data['timeout']);
            }

            return $dtoResponse->data['content'] ?? null;

        } catch (ArgumentException|Exception $e) {
            throw new ExceptionHttpClient($e->getMessage(), $json);
        }
    }

    /**
     * @throws ArgumentException
     * @throws Exception
     */
    public function info(): DtoClientInfo
    {
        $json = $this->httpClient->post(self::HTTP_API_SERVER . "/client/info/", Json::encode([
            "license_key" => $this->bitrixLicenseKey,
            "module_code" => $this->moduleCode,
        ]));

        $result = $this->checkResponseStatus(ResponseFactory::build($json))->data;

        return new DtoClientInfo(
            $result['balance'],
            $result['statistics'],
            $result['payment_history'],
            $result['model_options'],
        );
    }

    /**
     * @throws ArgumentException
     * @throws Exception
     */
    public function install(): bool
    {
        $json = $this->httpClient->post(self::HTTP_API_SERVER . "/client/install/", Json::encode([
            "license_key" => $this->bitrixLicenseKey,
            "module_code" => $this->moduleCode,
            "domain"      => $_SERVER['SERVER_NAME'],
        ]));

        return $this->checkResponseStatus(ResponseFactory::build($json))->status;
    }


    /**
     * @throws ExceptionHttpClient
     */
    public function checkResponseStatus(DtoResponse $dtoResponse): DtoResponse
    {
        if (!$dtoResponse->status) {
            throw new ExceptionHttpClient($dtoResponse->message, $dtoResponse->code);
        }

        return $dtoResponse;
    }
}
