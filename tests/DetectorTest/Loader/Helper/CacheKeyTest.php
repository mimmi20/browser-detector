<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Loader\Helper;

use BrowserDetector\Loader\Helper\CacheKey;
use PHPUnit\Framework\TestCase;

class CacheKeyTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $object = new CacheKey('test', 'testPath', 'testRules');
        self::assertSame('test_testPath_testRules_newKey', $object('newKey'));
    }
}
