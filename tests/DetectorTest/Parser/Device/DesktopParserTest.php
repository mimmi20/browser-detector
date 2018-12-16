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
use BrowserDetector\Parser\Device\DesktopParser;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;

class DesktopParserTest extends TestCase
{
    /**
     * @var \BrowserDetector\Parser\Device\DesktopParser
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        self::markTestIncomplete();
        $jsonParser    = $this->createMock(JsonInterface::class);
        $loaderFactory = $this->createMock(SpecificLoaderFactoryInterface::class);

        /* @var \JsonClass\Json $jsonParser */
        /* @var \BrowserDetector\Loader\DeviceLoaderFactory $loaderFactory */
        $this->object = new DesktopParser($jsonParser, $loaderFactory);
    }

    /**
     * @dataProvider providerUseragents
     *
     * @param string $useragent
     * @param string $expectedCompany
     * @param array  $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvoke(string $useragent, string $expectedCompany, array $expectedResult): void
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
            ->with($expectedCompany, 'desktop')
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
                'Mozilla/5.0 (Macintosh; ARM Mac OS X) AppleWebKit/538.15 (KHTML, like Gecko) Safari/538.15 Version/6.0 Debian/7.8 (3.8.2.0-0rpi18rpi1) Epiphany/3.8.2',
                'raspberry pi foundation',
                [],
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; MASP)',
                'sony',
                [],
            ],
            [
                'this is a fake ua to trigger the fallback',
                'unknown',
                [],
            ],
        ];
    }
}
