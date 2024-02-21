<?php

namespace Skyweb24\ChatgptSeo\Enum;

class EnumOptionTask
{
    const PREFIX = 'agent_task_';
    const POSTFIX_WORK = '_is_working';
    const POSTFIX_TIME = '_timestamp_start';

    public static function isWorking(int $taskId): string
    {
        return self::PREFIX . $taskId . self::POSTFIX_WORK;
    }
    public static function timestampStart(int $taskId): string
    {
        return self::PREFIX . $taskId . self::POSTFIX_TIME;
    }
}