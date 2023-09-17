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

use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Parser\BrowserParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

final class BrowserParserTest extends TestCase
{
    /** @throws ExpectationFailedException */
    public function testParse(): void
    {
        $useragent = 'test-agent';
        $mode      = 'test-mode';
        $key       = 'test-key';

        $loader = $this->getMockBuilder(BrowserLoaderInterface::class)
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

        $parser       = new BrowserParser($loader, $fileParser);
        $parserResult = $parser->parse($useragent);

        self::assertSame($key, $parserResult);
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testLoad(): void
    {
        $useragent = 'test-agent';
        $key       = 'test-key';

        $result = [
            [
                'name' => null,
                'modus' => null,
                'version' => null,
                'manufacturer' => 'xyz-type',
                'bits' => null,
                'type' => 'unknown',
                'isbot' => false,
            ],
            'unknown',
        ];

        $loader = $this->getMockBuilder(BrowserLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('load')
            ->with($key, $useragent)
            ->willReturn($result);

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(self::never())
            ->method('parseFile');

        $parser       = new BrowserParser($loader, $fileParser);
        $parserResult = $parser->load($key, $useragent);

        self::assertSame($result, $parserResult);
    }
}
