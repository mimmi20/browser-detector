<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\PlatformLoaderFactoryInterface;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use BrowserDetector\Parser\PlatformParser;
use PHPUnit\Framework\TestCase;
use UaResult\Os\OsInterface;

final class PlatformParserTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $useragent = 'test-agent';
        $mode      = 'test-mode';
        $key       = 'test-key';
        $result    = $this->createMock(OsInterface::class);

        $loader = $this->getMockBuilder(PlatformLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(static::once())
            ->method('load')
            ->with($key, $useragent)
            ->willReturn($result);

        $loaderFactory = $this->getMockBuilder(PlatformLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(static::once())
            ->method('__invoke')
            ->willReturn($loader);

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(static::exactly(2))
            ->method('parseFile')
            ->willReturnOnConsecutiveCalls($mode, $key);

        /** @var \BrowserDetector\Loader\PlatformLoaderFactoryInterface $loaderFactory */
        /** @var \BrowserDetector\Parser\Helper\RulefileParserInterface $fileParser */
        $parser       = new PlatformParser($loaderFactory, $fileParser);
        $parserResult = $parser->parse($useragent);

        static::assertSame($result, $parserResult);
    }
}
