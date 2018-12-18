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

use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Loader\DeviceLoaderInterface;
use BrowserDetector\Parser\Device\DarwinParser;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;

class DarwinParserTest extends TestCase
{
    /**
     * @dataProvider providerUseragents
     *
     * @param string $useragent
     * @param string $expectedMode
     * @param array  $expectedResult
     *
     * @return void
     */
    public function testInvoke(string $useragent, string $expectedMode, array $expectedResult): void
    {
        $mockLoader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with($expectedMode, $useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('apple')
            ->willReturn($mockLoader);

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::exactly(2))
            ->method('decode')
            ->willReturnOnConsecutiveCalls(['generic' => $expectedMode, 'rules' => []], ['generic' => $expectedMode, 'rules' => []]);

        /* @var \JsonClass\Json $jsonParser */
        /* @var \BrowserDetector\Loader\DeviceLoaderFactory $mockLoaderFactory */
        $object = new DarwinParser($jsonParser, $mockLoaderFactory);

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
