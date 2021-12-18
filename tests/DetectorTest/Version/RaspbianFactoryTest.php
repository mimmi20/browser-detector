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

use BrowserDetector\Version\Raspbian;
use BrowserDetector\Version\RaspbianFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

use function assert;
use function sprintf;

final class RaspbianFactoryTest extends TestCase
{
    private RaspbianFactory $object;

    protected function setUp(): void
    {
        $this->object = new RaspbianFactory();
    }

    public function testInvoke(): void
    {
        $object = $this->object;
        assert($object instanceof RaspbianFactory, sprintf('$object should be an instance of %s, but is %s', RaspbianFactory::class, $object::class));
        $result = $object(new NullLogger());
        self::assertInstanceOf(Raspbian::class, $result);
    }
}
