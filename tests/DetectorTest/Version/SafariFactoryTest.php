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

use BrowserDetector\Version\Safari;
use BrowserDetector\Version\SafariFactory;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;
use function sprintf;

#[CoversClass(SafariFactory::class)]
final class SafariFactoryTest extends TestCase
{
    private SafariFactory $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new SafariFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        assert(
            $object instanceof SafariFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                SafariFactory::class,
                $object::class,
            ),
        );
        $result = $object();
        self::assertInstanceOf(Safari::class, $result);
    }
}
