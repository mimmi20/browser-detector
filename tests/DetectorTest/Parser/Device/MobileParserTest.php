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

namespace BrowserDetectorTest\Parser\Device;

use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Loader\DeviceLoaderInterface;
use BrowserDetector\Parser\Device\MobileParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

final class MobileParserTest extends TestCase
{
    /** @throws ExpectationFailedException */
    public function testParse(): void
    {
        $useragent    = 'test-useragent';
        $expectedMode = 'test-mode';
        $genericMode  = 'genericMode';

        $mockLoader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoader
            ->expects(self::never())
            ->method('load');

        $mockLoaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoaderFactory
            ->expects(self::never())
            ->method('__invoke');

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(self::exactly(2))
            ->method('parseFile')
            ->willReturn($genericMode, $expectedMode);

        $object = new MobileParser($fileParser, $mockLoaderFactory);

        self::assertSame($genericMode . '=' . $expectedMode, $object->parse($useragent));
    }

    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testLoad(): void
    {
        $company = 'unknown';
        $key     = 'unknown';

        $result = [
            [
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => 'loaded-type-1',
                'brand' => 'loaded-type-2',
                'dualOrientation' => null,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => 'device-type',
                'ismobile' => true,
            ],
            null,
        ];

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(self::never())
            ->method('parseFile');

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('load')
            ->with($key)
            ->willReturn($result);

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($company)
            ->willReturn($loader);

        $object       = new MobileParser($fileParser, $loaderFactory);
        $parserResult = $object->load($company, $key);

        self::assertSame($result, $parserResult);
    }
}
