<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
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
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UaResult\Engine\EngineInterface;
use UnexpectedValueException;

use function assert;

final class EngineParserTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     * @throws \InvalidArgumentException
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
            ->method('load')
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

        assert($loaderFactory instanceof EngineLoaderFactoryInterface);
        assert($fileParser instanceof RulefileParserInterface);
        $parser       = new EngineParser($loaderFactory, $fileParser);
        $parserResult = $parser->parse($useragent);

        self::assertSame($result, $parserResult);
    }
}
