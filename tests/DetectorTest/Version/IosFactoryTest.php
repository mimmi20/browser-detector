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

use BrowserDetector\Version\Ios;
use BrowserDetector\Version\IosFactory;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;
use function sprintf;

#[CoversClass(className: IosFactory::class)]
final class IosFactoryTest extends TestCase
{
    private IosFactory $iosFactory;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->iosFactory = new IosFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->iosFactory;
        assert(
            $object instanceof IosFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                IosFactory::class,
                $object::class,
            ),
        );
        $ios = $object();
        self::assertInstanceOf(Ios::class, $ios);
    }
}
