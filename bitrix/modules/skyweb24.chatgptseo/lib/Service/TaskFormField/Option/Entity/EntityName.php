<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Feature\FeatureHtml;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Feature\FeatureSmile;

class EntityName extends EntityAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "NAME",
    ){
        parent::__construct($name, $code, [
            new FeatureHtml(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_FEATURE_HTML")),
            new FeatureSmile(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_FEATURE_SMILE")),
        ]);
    }
}