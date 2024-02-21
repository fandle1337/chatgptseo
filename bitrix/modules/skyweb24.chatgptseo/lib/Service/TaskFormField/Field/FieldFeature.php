<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Feature\FeatureHtml;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Feature\FeatureSmile;

class FieldFeature extends FieldAbstract
{
    public function __construct(
        ?string $name = 'feature',
        ?string $code = 'feature',
    )
    {
        parent::__construct($name, $code, [
            new FeatureSmile(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_FEATURE_SMILE")),
            new FeatureHtml(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_FEATURE_HTML")),
            ]);
    }

    /** @param array $value */
    public function getValueForTemplate(mixed $value): string
    {
        foreach ($value as $item) {
            $listOption[] = $this->getOptionByCode($item);
        }
        foreach ($listOption ?? [] as $option) {
            $rows[] = $option->getName();
        }
        return implode(', ', $rows ?? []);

    }
}