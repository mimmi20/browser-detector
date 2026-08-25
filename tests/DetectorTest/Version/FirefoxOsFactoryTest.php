<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\FirefoxOs;
use BrowserDetector\Version\FirefoxOsFactory;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;
use function sprintf;

#[CoversClass(className: FirefoxOsFactory::class)]
final class FirefoxOsFactoryTest extends TestCase
{
    private FirefoxOsFactory $firefoxOsFactory;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->firefoxOsFactory = new FirefoxOsFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->firefoxOsFactory;
        assert(
            $object instanceof FirefoxOsFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                FirefoxOsFactory::class,
                $object::class,
            ),
        );
        $firefoxOs = $object();
        self::assertInstanceOf(FirefoxOs::class, $firefoxOs);
    }
}
