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

use BrowserDetector\Version\FirefoxOs;
use BrowserDetector\Version\FirefoxOsFactory;
use PHPUnit\Framework\TestCase;

use function assert;
use function get_class;
use function sprintf;

final class FirefoxOsFactoryTest extends TestCase
{
    private FirefoxOsFactory $object;

    protected function setUp(): void
    {
        $this->object = new FirefoxOsFactory();
    }

    public function testInvoke(): void
    {
        $object = $this->object;
        assert($object instanceof FirefoxOsFactory, sprintf('$object should be an instance of %s, but is %s', FirefoxOsFactory::class, get_class($object)));
        $result = $object();
        self::assertInstanceOf(FirefoxOs::class, $result);
    }
}
