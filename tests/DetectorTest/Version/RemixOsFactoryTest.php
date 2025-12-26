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

namespace Version;

use BrowserDetector\Version\RemixOs;
use BrowserDetector\Version\RemixOsFactory;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;
use function sprintf;

#[CoversClass(RemixOsFactory::class)]
final class RemixOsFactoryTest extends TestCase
{
    private RemixOsFactory $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new RemixOsFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        assert(
            $object instanceof RemixOsFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                RemixOsFactory::class,
                $object::class,
            ),
        );
        $result = $object();
        self::assertInstanceOf(RemixOs::class, $result);
    }
}
