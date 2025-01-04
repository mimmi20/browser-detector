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

use BrowserDetector\Version\Test;
use BrowserDetector\Version\TestFactory;
use Override;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;
use function sprintf;

final class TestFactoryTest extends TestCase
{
    private TestFactory $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new TestFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        assert(
            $object instanceof TestFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                TestFactory::class,
                $object::class,
            ),
        );
        $result = $object();
        self::assertInstanceOf(Test::class, $result);
    }
}
