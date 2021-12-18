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

use BrowserDetector\Version\WindowsPhoneOs;
use BrowserDetector\Version\WindowsPhoneOsFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

use function assert;
use function sprintf;

final class WindowsPhoneOsFactoryTest extends TestCase
{
    private WindowsPhoneOsFactory $object;

    protected function setUp(): void
    {
        $this->object = new WindowsPhoneOsFactory();
    }

    public function testInvoke(): void
    {
        $object = $this->object;
        assert($object instanceof WindowsPhoneOsFactory, sprintf('$object should be an instance of %s, but is %s', WindowsPhoneOsFactory::class, $object::class));
        $result = $object(new NullLogger());
        self::assertInstanceOf(WindowsPhoneOs::class, $result);
    }
}
