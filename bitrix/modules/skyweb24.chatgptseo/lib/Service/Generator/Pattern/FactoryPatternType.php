<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Pattern;

use Bitrix\Main\DI\ServiceLocator;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type\PatternTypeAbstract;

class FactoryPatternType
{
    public static function makeByCode(string $code): PatternTypeAbstract|false
    {

        $classList = ServiceLocator::getInstance()->get('pattern_list_related_class');

        foreach ($classList as $patternCode => $class) {
            if ($code === $patternCode) {
                return $class;
            }
        }
        return false;
    }

}