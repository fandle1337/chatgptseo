<?php
namespace Skyweb24\ChatgptSeo\Model;

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\IntegerField;

Loc::loadMessages(__FILE__);

/**
 * Class SeoTasksElementsTable
 *
 * Fields:
 * <ul>
 * <li> id int mandatory
 * <li> task_id int optional
 * <li> element_id int optional
 * <li> status_id int optional
 * </ul>
 *
 * @package Bitrix\Chatgpt
 **/

class ModelTaskElementsTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'skyweb24_chatgpt_seo_tasks_elements';
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
                    'title' => Loc::getMessage('SEO_TASKS_ELEMENTS_ENTITY_ID_FIELD')
                ]
            ),
            new IntegerField(
                'task_id',
                [
                    'title' => Loc::getMessage('SEO_TASKS_ELEMENTS_ENTITY_TASK_ID_FIELD')
                ]
            ),
            new IntegerField(
                'element_id',
                [
                    'title' => Loc::getMessage('SEO_TASKS_ELEMENTS_ENTITY_ELEMENT_ID_FIELD')
                ]
            ),
            new IntegerField(
                'status_id',
                [
                    'title' => Loc::getMessage('SEO_TASKS_ELEMENTS_ENTITY_STATUS_ID_FIELD')
                ]
            ),
        ];
    }
}