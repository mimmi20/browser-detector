<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\Macos;
use BrowserDetector\Version\MacosFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class MacosFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\MacosFactory
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new MacosFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        /** @var MacosFactory $object */
        $object = $this->object;
        $result = $object(new NullLogger());
        self::assertInstanceOf(Macos::class, $result);
    }
}
