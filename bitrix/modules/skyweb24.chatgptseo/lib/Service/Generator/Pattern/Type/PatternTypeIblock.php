<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblock;

class PatternTypeIblock extends PatternTypeAbstract
{
    public function __construct(
        protected RepositoryIblock $repositoryIblock,
    )
    {
    }

    public function getValue(string $pattern, DtoIblockElementAdvanced $dto): string|false
    {
        $dtoIblock = $this->repositoryIblock->getById($dto->dtoIblockElement->iblockId);

        $parameter = strtolower($this->findCodeInPattern($pattern));

        return $dtoIblock->$parameter ?: false;
    }
}