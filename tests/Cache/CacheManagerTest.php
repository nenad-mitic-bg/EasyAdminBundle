<?php

/*
 * This file is part of the EasyAdminBundle.
 *
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EasyCorp\Bundle\EasyAdminBundle\Tests\Cache;

use EasyCorp\Bundle\EasyAdminBundle\Cache\CacheManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class CacheManagerTest extends TestCase
{
    public function testCachePersistsValuesAndDistinguishesFalseFromMisses()
    {
        $directory = __DIR__.'/../../build/cache/cache_manager_test_'.uniqid();

        try {
            $cache = new CacheManager($directory);
            $this->assertFalse($cache->hasItem('missing'));
            $this->assertFalse($cache->getItem('missing'));
            $this->assertTrue($cache->save('config', array('enabled' => false)));
            $this->assertTrue($cache->save('false_value', false));

            $cache = new CacheManager($directory);
            $this->assertTrue($cache->hasItem('config'));
            $this->assertSame(array('enabled' => false), $cache->getItem('config'));
            $this->assertTrue($cache->hasItem('false_value'));
            $this->assertFalse($cache->getItem('false_value'));

            $this->assertTrue($cache->save('expired', 'value', -1));
            $this->assertFalse($cache->hasItem('expired'));
            $this->assertFalse($cache->getItem('expired'));
        } finally {
            (new Filesystem())->remove($directory);
        }
    }
}