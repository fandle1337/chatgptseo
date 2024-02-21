<?php

namespace Skyweb24\ChatgptSeo\Resource;

use Skyweb24\ChatgptSeo\Interface\InterfaceResourceQueryBuilderRule;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldAbstract;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityAbstract;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Feature\FeatureAbstract;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\OptionAbstract;
use Skyweb24\ChatgptSeo\Service\TaskFormField\OptionGroup\OptionGroup;

class ResourceQueryBuilderRule implements InterfaceResourceQueryBuilderRule
{
    /** @param FieldAbstract[] $entityList */
    public function __construct(protected array $entityList)
    {
    }

    // TODO REFACTORING необходимо чтобы каждый $entity мог сам отдавать список
    public function toArray(): array
    {
        foreach ($this->entityList as $entity) {
            foreach ($entity->getOptionList() as $option) {
                if($option instanceof OptionGroup) {

                    $rows = [];

                    /** @var OptionAbstract $groupOption */
                    foreach ($option->getOptionList() as $groupOption) {
                        $rows[] = [
                            "code" => $groupOption->getCode(),
                            "name" => $groupOption->getName(),
                        ];
                    }

                    $result[$entity->getCode()][] = [
                        "code" => $option->getCode(),
                        "name" =>  $option->getName(),
                        "option_list" => $rows ?? [],
                    ];

                } else if ($option instanceof EntityAbstract) {

                    $rows = [];
                    /** @var FeatureAbstract $featureOption */
                    foreach ($option->getFeatureList() as $featureOption) {
                        $rows[] = [
                            "code" => $featureOption->getCode(),
                            "name" => $featureOption->getName(),
                        ];
                    }

                    $result[$entity->getCode()][] = [
                        "code" => $option->getCode(),
                        "name" =>  $option->getName(),
                        "feature_list" => $rows ?? [],
                    ];

                } else {
                    $result[$entity->getCode()][] = [
                        "code" => $option->getCode(),
                        "name" =>  $option->getName(),
                    ];
                }
            }
        }

        return $result ?? [];
    }
}