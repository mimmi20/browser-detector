<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\ChromeOs;
use BrowserDetector\Version\ChromeOsFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class ChromeOsFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\ChromeOsFactory
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new ChromeOsFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        /** @var ChromeOsFactory $object */
        $object = $this->object;
        $result = $object(new NullLogger());
        self::assertInstanceOf(ChromeOs::class, $result);
    }
}
