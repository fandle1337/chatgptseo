<?php

namespace Skyweb24\Chatgptseo\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Skyweb24\ChatgptSeo\Interface\InterfaceResourceQueryBuilderRule;

class ControllerAbstract extends Controller
{
    public function response(mixed $data): mixed
    {
        if ($data instanceof InterfaceResourceQueryBuilderRule) {
            return $data->toArray();
        }
        return $data;
    }

    public static function showError(string $message): AjaxJson
    {
        $errorCollection = new ErrorCollection();
        $errorCollection->setError(new Error($message));
        return new AjaxJson(null, AjaxJson::STATUS_ERROR, $errorCollection);
    }

}