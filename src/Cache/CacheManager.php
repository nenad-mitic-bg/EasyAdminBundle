<?php

/*
 * This file is part of the EasyAdminBundle.
 *
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EasyCorp\Bundle\EasyAdminBundle\Cache;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * It provides a file system based cache for the processed configuration.
 */
class CacheManager
{
    private $cache;

    public function __construct($cacheDir)
    {
        $this->cache = new FilesystemAdapter('', 0, $cacheDir);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getItem($key)
    {
        $item = $this->cache->getItem($key);

        return $item->isHit() ? $item->get() : false;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasItem($key)
    {
        return $this->cache->hasItem($key);
    }

    /**
     * @param string $key
     * @param mixed  $item
     * @param int    $lifetime
     *
     * @return bool
     */
    public function save($key, $item, $lifetime = 0)
    {
        $cacheItem = $this->cache->getItem($key);
        $cacheItem->set($item);
        $cacheItem->expiresAfter(0 === $lifetime ? null : $lifetime);

        return $this->cache->save($cacheItem);
    }
}

class_alias('EasyCorp\Bundle\EasyAdminBundle\Cache\CacheManager', 'JavierEguiluz\Bundle\EasyAdminBundle\Cache\CacheManager', false);
