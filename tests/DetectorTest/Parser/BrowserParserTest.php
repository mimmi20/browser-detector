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

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Parser\BrowserParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

#[CoversClass(BrowserParser::class)]
final class BrowserParserTest extends TestCase
{
    /** @throws ExpectationFailedException */
    public function testParse(): void
    {
        $useragent = 'test-agent';
        $mode      = 'test-mode';
        $key       = 'test-key';

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(self::exactly(2))
            ->method('parseFile')
            ->willReturn($mode, $key);

        $parser       = new BrowserParser($fileParser);
        $parserResult = $parser->parse($useragent);

        self::assertSame($key, $parserResult);
    }
}
