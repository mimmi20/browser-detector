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
namespace BrowserDetectorTest\Parser\Device;

use BrowserDetector\Loader\SpecificLoaderFactoryInterface;
use BrowserDetector\Loader\SpecificLoaderInterface;
use BrowserDetector\Parser\Device\DarwinParser;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\Json;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class DarwinParserTest extends TestCase
{
    /**
     * @var \BrowserDetector\Parser\Device\DarwinParser
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $logger         = $this->createMock(NullLogger::class);
        $jsonParser     = $this->createMock(JsonInterface::class);
        $platformParser = $this->createMock(PlatformParserInterface::class);

        /* @var NullLogger $logger */
        /* @var Json $jsonParser */
        /* @var PlatformParserInterface $platformParser */
        $this->object = new DarwinParser($logger, $jsonParser, $platformParser);
    }

    /**
     * @dataProvider providerUseragents
     *
     * @param string $useragent
     * @param string $expectedMode
     * @param array  $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvoke(string $useragent, string $expectedMode, array $expectedResult): void
    {
        self::markTestIncomplete();
        $mockLoader = $this->getMockBuilder(SpecificLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(SpecificLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('apple', $expectedMode)
            ->willReturn($mockLoader);

        $property = new \ReflectionProperty($this->object, 'loaderFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $mockLoaderFactory);

        $object = $this->object;

        self::assertSame($expectedResult, $object($useragent));
    }

    /**
     * @return array[]
     */
    public function providerUseragents(): array
    {
        return [
            [
                'Safari/13604.1.38.1.6 CFNetwork/887 Darwin/17.0.0 (x86_64)',
                'desktop',
                [],
            ],
            [
                'Safari/6534.59.10 CFNetwork/454.12.4 Darwin/10.8.0 (i386) (MacBook5%2C1)',
                'desktop',
                [],
            ],
            [
                'Reeder/3.0.50 CFNetwork/887 Darwin/17.0.0',
                'mobile',
                [],
            ],
            [
                'this is a fake ua to trigger the fallback',
                'desktop',
                [],
            ],
        ];
    }
}
