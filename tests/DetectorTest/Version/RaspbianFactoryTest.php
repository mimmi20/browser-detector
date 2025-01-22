<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\Raspbian;
use BrowserDetector\Version\RaspbianFactory;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;
use function sprintf;

#[CoversClass(RaspbianFactory::class)]
final class RaspbianFactoryTest extends TestCase
{
    private RaspbianFactory $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new RaspbianFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        assert(
            $object instanceof RaspbianFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                RaspbianFactory::class,
                $object::class,
            ),
        );
        $result = $object();
        self::assertInstanceOf(Raspbian::class, $result);
    }
}
