<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Parser\EngineParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;

final class EngineParserTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParse(): void
    {
        $useragent = 'test-agent';
        $mode      = 'test-mode';

        $loader = $this->getMockBuilder(EngineLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::never())
            ->method('load');

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(self::once())
            ->method('parseFile')
            ->willReturn($mode);

        assert($fileParser instanceof RulefileParserInterface);
        $parser       = new EngineParser($loader, $fileParser);
        $parserResult = $parser->parse($useragent);

        self::assertSame($mode, $parserResult);
    }
}
