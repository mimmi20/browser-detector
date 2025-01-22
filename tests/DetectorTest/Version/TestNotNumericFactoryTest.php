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

use BrowserDetector\Version\TestNotNumericError;
use BrowserDetector\Version\TestNotNumericFactory;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;
use function sprintf;

#[CoversClass(TestNotNumericFactory::class)]
final class TestNotNumericFactoryTest extends TestCase
{
    private TestNotNumericFactory $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new TestNotNumericFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        assert(
            $object instanceof TestNotNumericFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                TestNotNumericFactory::class,
                $object::class,
            ),
        );
        $result = $object();
        self::assertInstanceOf(TestNotNumericError::class, $result);
    }
}
