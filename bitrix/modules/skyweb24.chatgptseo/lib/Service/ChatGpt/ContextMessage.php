<?php

namespace Skyweb24\ChatgptSeo\Service\ChatGpt;

class ContextMessage
{
    public function __construct(
        public string $text,
        public string $role,
        public int $countToken,
    ) {
    }

    public function toArray(): array
    {
        return [
            "role" => $this->role,
            "content" => $this->text
        ];
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return ContextMessage
     */
    public function setText(string $text): ContextMessage
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return ContextMessage
     */
    public function setRole(string $role): ContextMessage
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return int
     */
    public function getCountToken(): int
    {
        return $this->countToken;
    }

    /**
     * @param int $countToken
     * @return ContextMessage
     */
    public function setCountToken(int $countToken): ContextMessage
    {
        $this->countToken = $countToken;
        return $this;
    }




}