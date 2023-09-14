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

use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use BrowserDetector\Parser\PlatformParser;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;

final class PlatformParserTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParse(): void
    {
        $useragent = 'test-agent';
        $mode      = 'test-mode';
        $key       = 'test-key';

        $loader = $this->getMockBuilder(PlatformLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::never())
            ->method('load');

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(self::exactly(2))
            ->method('parseFile')
            ->willReturn($mode, $key);

        assert($fileParser instanceof RulefileParserInterface);
        $parser       = new PlatformParser($loader, $fileParser);
        $parserResult = $parser->parse($useragent);

        self::assertSame($key, $parserResult);
    }
}
