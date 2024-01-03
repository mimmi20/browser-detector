<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Parser\EngineParser;
use BrowserDetector\Parser\EngineParserFactory;
use BrowserDetector\Parser\EngineParserInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class EngineParserFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $logger = $this->createMock(LoggerInterface::class);

        $factory = new EngineParserFactory($logger);

        $parser = $factory();

        self::assertInstanceOf(EngineParserInterface::class, $parser);
        self::assertInstanceOf(EngineParser::class, $parser);
    }
}
