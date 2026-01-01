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

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\TestNotNumericError;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TestNotNumericError::class)]
final class TestNotNumericErrorTest extends TestCase
{
    /** @throws NotNumericException */
    public function testDetectVersion(): void
    {
        $object = new TestNotNumericError();

        $this->expectException(NotNumericException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('error');

        $object->detectVersion(
            'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
        );
    }
}
