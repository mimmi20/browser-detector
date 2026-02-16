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

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Parser\PlatformParser;
use BrowserDetector\Parser\PlatformParserFactory;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaParser\PlatformParserInterface;

#[CoversClass(PlatformParserFactory::class)]
final class PlatformParserFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvoke(): void
    {
        $factory = new PlatformParserFactory();

        $parser = $factory();

        self::assertInstanceOf(PlatformParserInterface::class, $parser);
        self::assertInstanceOf(PlatformParser::class, $parser);
    }
}
