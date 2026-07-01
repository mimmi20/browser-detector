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

namespace Version;

use BrowserDetector\Version\Webos;
use BrowserDetector\Version\WebosFactory;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;
use function sprintf;

#[CoversClass(WebosFactory::class)]
final class WebosFactoryTest extends TestCase
{
    private WebosFactory $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new WebosFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        assert(
            $object instanceof WebosFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                WebosFactory::class,
                $object::class,
            ),
        );
        $result = $object();
        self::assertInstanceOf(Webos::class, $result);
    }
}
