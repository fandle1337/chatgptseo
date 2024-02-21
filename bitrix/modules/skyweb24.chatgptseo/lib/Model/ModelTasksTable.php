<?php
namespace Skyweb24\ChatgptSeo\Model;

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\DatetimeField,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\TextField,
    Bitrix\Main\Type\DateTime;

Loc::loadMessages(__FILE__);

/**
 * Class SeoTasksTable
 *
 * Fields:
 * <ul>
 * <li> id int mandatory
 * <li> date_create datetime optional default current datetime
 * <li> date_complete datetime optional
 * <li> status_id int optional
 * <li> operation_type text optional
 * <li> element_type text optional
 * <li> incorrect_text text optional
 * <li> operations text optional
 * </ul>
 *
 * @package Bitrix\Chatgpt
 **/

class ModelTasksTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'skyweb24_chatgpt_seo_tasks';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new IntegerField(
                'id',
                [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => Loc::getMessage('SEO_TASKS_ENTITY_ID_FIELD')
                ]
            ),
            new IntegerField(
                'user_id',
                [
                    'title' => Loc::getMessage('SEO_TASKS_ENTITY_USER_ID_FIELD')
                ]
            ),
            new IntegerField(
                'iblock_id',
                [
                    'title' => Loc::getMessage('SEO_TASKS_ENTITY_IBLOCK_ID_FIELD')
                ]
            ),
            new DatetimeField(
                'date_create',
                [
                    'default' => function()
                    {
                        return new DateTime();
                    },
                    'title' => Loc::getMessage('SEO_TASKS_ENTITY_DATE_CREATE_FIELD')
                ]
            ),
            new DatetimeField(
                'date_complete',
                [
                    'title' => Loc::getMessage('SEO_TASKS_ENTITY_DATE_COMPLETE_FIELD')
                ]
            ),
            new IntegerField(
                'status_id',
                [
                    'title' => Loc::getMessage('SEO_TASKS_ENTITY_STATUS_ID_FIELD')
                ]
            ),
            new TextField(
                'operation_type',
                [
                    'title' => Loc::getMessage('SEO_TASKS_ENTITY_OPERATION_TYPE_FIELD')
                ]
            ),
            new TextField(
                'element_type',
                [
                    'title' => Loc::getMessage('SEO_TASKS_ENTITY_ELEMENT_TYPE_FIELD')
                ]
            ),
            new TextField(
                'incorrect_text',
                [
                    'title' => Loc::getMessage('SEO_TASKS_ENTITY_INCORRECT_TEXT_FIELD')
                ]
            ),
            new TextField(
                'operations',
                [
                    'title' => Loc::getMessage('SEO_TASKS_ENTITY_OPERATIONS_FIELD')
                ]
            ),
        ];
    }
}