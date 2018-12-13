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
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\EngineFactory;
use PHPUnit\Framework\TestCase;

class EngineFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Factory\EngineFactory
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new EngineFactory();
    }

    /**
     * @return void
     */
    public function testToArray(): void
    {
        self::markTestIncomplete();
    }
}
