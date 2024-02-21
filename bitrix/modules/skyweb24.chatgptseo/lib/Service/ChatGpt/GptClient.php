<?php

namespace Skyweb24\ChatgptSeo\Service\ChatGpt;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Web\Json;
use ErrorException;
use Skyweb24\ChatgptSeo\Exception\ExceptionHttpClient;


class GptClient
{
    public function __construct(protected HttpClient $httpClient, protected string $token)
    {
        $this->httpClient->setHeader('Authorization', 'Bearer ' . $this->token);
    }


    /**
     * @throws ExceptionHttpClient
     */
    public function prompt(ContextMessageCollection $contextMessageCollection, string $gptModel): ?string
    {
        try {
            $json = $this->httpClient->post('https://api.openai.com/v1/chat/completions', Json::encode([
                "model"    => $gptModel,
                "messages" => array_reverse($contextMessageCollection->toArray())
            ]));

            if (empty($json)) {
                throw new ExceptionHttpClient(
                    'Wrong settings',
                    Loc::getMessage("SKYWEB24_CHATGPTSEO_WRONG_SETTINGS")
                );
            }

            $json = preg_replace('/\n\s+/', ' ', $json);

            $result = Json::decode($json);

            if (empty($result['choices'][0]['message']['content'])) {
                throw new ErrorException($result['error']['message']);
            }

            return $result['choices'][0]['message']['content'];

        } catch (ArgumentException|ErrorException $e) {
            throw new ExceptionHttpClient($e->getMessage(), $json);
        }
    }


}