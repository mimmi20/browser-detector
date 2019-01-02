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

use BrowserDetector\Loader\EngineLoaderFactoryInterface;
use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Parser\EngineParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\TestCase;
use UaResult\Engine\EngineInterface;

class EngineParserTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $useragent = 'test-agent';
        $mode      = 'test-mode';
        $result    = $this->createMock(EngineInterface::class);

        $loader = $this->getMockBuilder(EngineLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('__invoke')
            ->with($mode, $useragent)
            ->willReturn($result);

        $loaderFactory = $this->getMockBuilder(EngineLoaderFactoryInterface::class)
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
            ->expects(self::once())
            ->method('parseFile')
            ->willReturn($mode);

        /** @var \BrowserDetector\Loader\EngineLoaderFactoryInterface $loaderFactory */
        /** @var \BrowserDetector\Parser\Helper\RulefileParserInterface $fileParser */
        $parser       = new EngineParser($loaderFactory, $fileParser);
        $parserResult = $parser($useragent);

        self::assertSame($result, $parserResult);
    }
}
