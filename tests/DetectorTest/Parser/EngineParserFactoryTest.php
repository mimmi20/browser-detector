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

use BrowserDetector\Parser\EngineParser;
use BrowserDetector\Parser\EngineParserFactory;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaParser\EngineParserInterface;

#[CoversClass(className: EngineParserFactory::class)]
final class EngineParserFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $ruleFileParser = $this->createMock(RulefileParserInterface::class);
        $ruleFileParser
            ->expects(self::never())
            ->method('parseFile');

        $engineParserFactory = new EngineParserFactory(rulefileParser: $ruleFileParser);

        $engineParser = $engineParserFactory();

        self::assertInstanceOf(EngineParserInterface::class, $engineParser);
        self::assertInstanceOf(EngineParser::class, $engineParser);
    }
}
