<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\RimOs;
use BrowserDetector\Version\RimOsFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class RimOsFactoryTest extends TestCase
{
    /** @var \BrowserDetector\Version\RimOsFactory */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new RimOsFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        \assert($object instanceof RimOsFactory, sprintf('$object should be an instance of %s, but is %s', RimOsFactory::class, get_class($object)));
        $result = $object(new NullLogger());
        self::assertInstanceOf(RimOs::class, $result);
    }
}
