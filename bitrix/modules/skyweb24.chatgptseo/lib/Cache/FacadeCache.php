<?php

namespace Skyweb24\ChatgptSeo\Cache;


use Bitrix\Main\Application;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\Data\TaggedCache;

class FacadeCache
{
    private static ?self $instance = null;
    protected string $path;
    protected Cache $cache;
    protected TaggedCache $tagManager;

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->path = "/test/";
        $this->cache = Cache::createInstance();
        $this->tagManager = Application::getInstance()->getTaggedCache();
    }

    public function set(mixed $data, string $hash, int $ttl = 86400, array $tags = []): bool
    {
        if($this->cache->initCache($ttl, $hash, $this->path)) {
            $this->cache->clean($hash, $this->path);
        }

        if(!empty($tags)) {
            $this->tagManager->startTagCache($this->path);

            foreach ($tags as $tag) {
                $this->tagManager->registerTag($tag);
            }

            $this->tagManager->endTagCache();
        }

        $this->cache->startDataCache();
        $this->cache->endDataCache($data);

        return true;
    }

    public function get(string $hash, int $ttl)
    {
        if ($this->cache->initCache($ttl, $hash, $this->path)) {
            return $this->cache->getVars();
        }

        return false;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function clearInstance()
    {
        self::$instance = null;
    }

    public function clearTag(string $tag)
    {
        $this->tagManager->clearByTag($tag);
    }


}