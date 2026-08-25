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

use BrowserDetector\Version\SmartisanOs;
use BrowserDetector\Version\SmartisanOsFactory;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;
use function sprintf;

#[CoversClass(className: SmartisanOsFactory::class)]
final class SmartisanOsFactoryTest extends TestCase
{
    private SmartisanOsFactory $smartisanOsFactory;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->smartisanOsFactory = new SmartisanOsFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->smartisanOsFactory;
        assert(
            $object instanceof SmartisanOsFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                SmartisanOsFactory::class,
                $object::class,
            ),
        );
        $smartisanOs = $object();
        self::assertInstanceOf(SmartisanOs::class, $smartisanOs);
    }
}
