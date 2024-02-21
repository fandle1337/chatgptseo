<?php

namespace Skyweb24\ChatgptSeo\Exception;


class ExceptionHttpClient extends \Exception
{
    protected string $context;

    public function __construct(string $message, string $context)
    {
        parent::__construct($message, 0, null);
        $this->context = $context;
    }

    /**
     * @return string
     */
    public function getContext(): string
    {
        return $this->context;
    }
}