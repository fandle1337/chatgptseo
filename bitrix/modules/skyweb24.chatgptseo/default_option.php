<?php

use Skyweb24\ChatgptSeo\Enum\EnumSettingApp;

\Bitrix\Main\Loader::includeModule("skyweb24.chatgptseo");

$skyweb24_chatgptseo_default_option = [
    EnumSettingApp::PERSONAL_CHAT_GPT_KEY_ACTIVE => "N",
    EnumSettingApp::PERSONAL_CHAT_GPT_KEY => "",
    EnumSettingApp::GPT_MODEL => "gpt-3.5-turbo",
    EnumSettingApp::PERSONAL_GPT_MODEL => "gpt-3.5-turbo-16k",
];