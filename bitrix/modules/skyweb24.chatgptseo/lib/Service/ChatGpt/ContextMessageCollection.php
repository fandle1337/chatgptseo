<?php

namespace Skyweb24\ChatgptSeo\Service\ChatGpt;

class ContextMessageCollection
{
    /** @var ContextMessage[] */
    protected array $messages = [];

    public function push(ContextMessage $message): self
    {
        $this->messages[] = $message;
        return $this;
    }

    public function getList(): array
    {
        return $this->messages;
    }

    public function toArray(): array
    {
        foreach ($this->messages as $message) {
            $rows[] = $message->toArray();
        }

        return $rows ?? [];
    }

    public function getTotalToken(): int
    {
        $counter = 0;

        foreach ($this->messages as $message) {
            $counter += $message->getCountToken();
        }

        return $counter;
    }

    public function deleteByIndex($i)
    {
        unset($this->messages[$i]);
    }
}