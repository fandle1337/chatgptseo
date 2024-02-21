<?php

namespace Skyweb24\ChatgptSeo\Repository;

use Skyweb24\ChatgptSeo\Enum\EnumSettingApp;

class RepositorySetting
{
    public function getValue(string $code)
    {
        return \COption::GetOptionString(EnumSettingApp::MODULE_CODE, $code);
    }

    public function getIntValue(string $code): int
    {
        return \COption::GetOptionInt(EnumSettingApp::MODULE_CODE, $code);
    }

    public function setValue(string $code, string $value)
    {
        return \COption::SetOptionString(EnumSettingApp::MODULE_CODE, $code, $value);
    }

    public function removeOption($name)
    {
        \COption::RemoveOption(EnumSettingApp::MODULE_CODE, $name);
    }
}