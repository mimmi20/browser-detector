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

use BrowserDetector\Version\Gecko;
use BrowserDetector\Version\GeckoFactory;
use Override;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

use function assert;
use function sprintf;

final class GeckoFactoryTest extends TestCase
{
    private GeckoFactory $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new GeckoFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        assert(
            $object instanceof GeckoFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                GeckoFactory::class,
                $object::class,
            ),
        );
        $result = $object(new NullLogger());
        self::assertInstanceOf(Gecko::class, $result);
    }
}
