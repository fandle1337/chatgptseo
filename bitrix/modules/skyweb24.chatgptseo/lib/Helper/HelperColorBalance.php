<?php

namespace Skyweb24\ChatgptSeo\Helper;

class HelperColorBalance
{
    public static function getColor(int $balance): string
    {
        if ($balance >= 100) {
            return 'ui-alert-success';
        } elseif ($balance >= 0) {
            return 'ui-alert-warning';
        }
        return 'ui-alert-danger';
    }
}