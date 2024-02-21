<?php

namespace Skyweb24\ChatgptSeo\Controller;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Enum\EnumSettingApp;
use Skyweb24\ChatgptSeo\Service\ServiceAiModel;
use Skyweb24\ChatgptSeo\Service\ServiceCheckProxy;

class ControllerOptions extends ControllerAbstract
{
    public function clearLogFileAction(): ?string
    {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . EnumSettingApp::LOG_PATH, '');

        return Loc::getMessage("SKYWEB24_CHATGPTSEO_LOG_FILE_IS_CLEAN");
    }

    public function checkProxyAction(): ?string
    {
        return ServiceLocator::getInstance()->get(ServiceCheckProxy::class)
            ->check(
                $this->request->get("address"),
                (int)$this->request->get("port"),
                $this->request->get("login"),
                $this->request->get("password"),

            );
    }

    public function getModelListAction(): array|false
    {
        return ServiceLocator::getInstance()->get(ServiceAiModel::class)
            ->getList(
                $this->request->get("key"),
                $this->request->get("proxySettings")
            );
    }
}