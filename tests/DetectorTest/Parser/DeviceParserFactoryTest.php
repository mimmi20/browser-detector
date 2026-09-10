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

use BrowserDetector\Parser\DeviceParser;
use BrowserDetector\Parser\DeviceParserFactory;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaParser\DeviceParserInterface;

#[CoversClass(className: DeviceParserFactory::class)]
final class DeviceParserFactoryTest extends TestCase
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

        $deviceParserFactory = new DeviceParserFactory(rulefileParser: $ruleFileParser);

        $deviceParser = $deviceParserFactory();

        self::assertInstanceOf(DeviceParserInterface::class, $deviceParser);
        self::assertInstanceOf(DeviceParser::class, $deviceParser);
    }
}
