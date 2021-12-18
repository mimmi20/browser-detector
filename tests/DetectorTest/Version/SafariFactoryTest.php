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

use BrowserDetector\Version\Safari;
use BrowserDetector\Version\SafariFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

use function assert;
use function get_class;
use function sprintf;

final class SafariFactoryTest extends TestCase
{
    private SafariFactory $object;

    protected function setUp(): void
    {
        $this->object = new SafariFactory();
    }

    public function testInvoke(): void
    {
        $object = $this->object;
        assert($object instanceof SafariFactory, sprintf('$object should be an instance of %s, but is %s', SafariFactory::class, get_class($object)));
        $result = $object(new NullLogger());
        self::assertInstanceOf(Safari::class, $result);
    }
}
