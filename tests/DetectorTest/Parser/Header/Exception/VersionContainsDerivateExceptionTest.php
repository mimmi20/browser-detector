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

namespace BrowserDetectorTest\Parser\Header\Exception;

use BrowserDetector\Parser\Header\Exception\VersionContainsDerivateException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

#[CoversClass(VersionContainsDerivateException::class)]
final class VersionContainsDerivateExceptionTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testSetGet(): void
    {
        $ex = new VersionContainsDerivateException('x', 0, null);

        self::assertSame('', $ex->getDerivate());

        $derivate = 'abc';

        $ex->setDerivate($derivate);

        self::assertSame($derivate, $ex->getDerivate());
    }
}
