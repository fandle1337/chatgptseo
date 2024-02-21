<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

class FactoryField
{
    public static function makeByCode($code, array $fieldList = []): ?FieldAbstract
    {
        foreach ($fieldList as $field) {
            if ($field->getCode() === $code) {
                return $field;
            }
        }
        return null;
    }
}