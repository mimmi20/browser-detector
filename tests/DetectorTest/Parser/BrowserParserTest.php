<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\BrowserLoaderFactoryInterface;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Parser\BrowserParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\TestCase;

final class BrowserParserTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $useragent = 'test-agent';
        $mode      = 'test-mode';
        $key       = 'test-key';
        $result    = ['test-result'];

        $loader = $this->getMockBuilder(BrowserLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('__invoke')
            ->with($key, $useragent)
            ->willReturn($result);

        $loaderFactory = $this->getMockBuilder(BrowserLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->willReturn($loader);

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(self::exactly(2))
            ->method('parseFile')
            ->willReturnOnConsecutiveCalls($mode, $key);

        /** @var \BrowserDetector\Loader\BrowserLoaderFactoryInterface $loaderFactory */
        /** @var \BrowserDetector\Parser\Helper\RulefileParserInterface $fileParser */
        $parser       = new BrowserParser($loaderFactory, $fileParser);
        $parserResult = $parser($useragent);

        self::assertSame($result, $parserResult);
    }
}
