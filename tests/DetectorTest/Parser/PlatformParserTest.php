<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
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
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function assert;

final class PlatformParserTest extends TestCase
{
    private const USERAGENT = 'test-agent';
    private const MODE      = 'test-mode';
    private const KEY       = 'test-key';

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     * @throws \InvalidArgumentException
     */
    public function testInvoke(): void
    {
        $result = $this->createMock(OsInterface::class);

        $loader = $this->getMockBuilder(PlatformLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('load')
            ->with(self::KEY, self::USERAGENT)
            ->willReturn($result);

        $loaderFactory = $this->getMockBuilder(PlatformLoaderFactoryInterface::class)
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
            ->willReturnOnConsecutiveCalls(self::MODE, self::KEY);

        assert($loaderFactory instanceof PlatformLoaderFactoryInterface);
        assert($fileParser instanceof RulefileParserInterface);
        $parser       = new PlatformParser($loaderFactory, $fileParser);
        $parserResult = $parser->parse(self::USERAGENT);

        self::assertSame($result, $parserResult);
    }
}
