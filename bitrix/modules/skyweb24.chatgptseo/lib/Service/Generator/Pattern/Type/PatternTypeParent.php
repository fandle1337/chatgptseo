<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockSection;

class PatternTypeParent extends PatternTypeAbstract
{
    public function __construct(
        protected RepositoryIblockSection $repositoryIblockSection,
    )
    {
    }

    public function getValue(string $pattern, DtoIblockElementAdvanced $dto): string|false
    {
        if (!$dtoIblockSection = $this->repositoryIblockSection->getById($dto->dtoIblockElement->iblockSectionId)) {
            return false;
        }

        $parameter = strtolower($this->findCodeInPattern($pattern));

        return $dtoIblockSection->$parameter ?: false;
    }
}