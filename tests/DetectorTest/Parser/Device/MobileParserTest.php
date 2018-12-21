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
use BrowserDetector\Parser\Device\MobileParser;
use ExceptionalJSON\DecodeErrorException;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;

class MobileParserTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvokeFail(): void
    {
        $useragent = 'Mozilla/5.0 (Linux; Tizen 2.3; SAMSUNG SM-Z130H) AppleWebKit/537.3 (KHTML, like Gecko) Version/2.3 Mobile Safari/537.3';

        $mockLoader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoader
            ->expects(self::never())
            ->method('__invoke')
            ->with('mobile', $useragent)
            ->willReturn(null);

        $mockLoaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoaderFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('zte')
            ->willReturn($mockLoader);

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->willThrowException(new DecodeErrorException(1, 'fail', ''));

        /* @var \JsonClass\Json $jsonParser */
        /* @var \BrowserDetector\Loader\DeviceLoaderFactory $mockLoaderFactory */
        $object = new MobileParser($jsonParser, $mockLoaderFactory);

        $this->expectException(DecodeErrorException::class);
        $this->expectExceptionMessage('fail');

        $object($useragent);
    }

    /**
     * @dataProvider providerUseragents
     *
     * @param string $useragent
     * @param string $expectedCompany
     * @param array  $expectedResult
     *
     * @return void
     */
    public function testInvoke(string $useragent, string $expectedCompany, array $expectedResult): void
    {
        $mockLoader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('mobile', $useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($expectedCompany)
            ->willReturn($mockLoader);

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::exactly(2))
            ->method('decode')
            ->willReturnOnConsecutiveCalls(['generic' => $expectedCompany, 'rules' => []], ['generic' => 'mobile', 'rules' => []]);

        /* @var \JsonClass\Json $jsonParser */
        /* @var \BrowserDetector\Loader\DeviceLoaderFactory $mockLoaderFactory */
        $object = new MobileParser($jsonParser, $mockLoaderFactory);

        self::assertSame($expectedResult, $object($useragent));
    }

    /**
     * @return array[]
     */
    public function providerUseragents(): array
    {
        return [
            [
                'Mozilla/5.0 (Linux; Tizen 2.3; SAMSUNG SM-Z130H) AppleWebKit/537.3 (KHTML, like Gecko) Version/2.3 Mobile Safari/537.3',
                'samsung',
                [],
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.2.2; ru; GT-A7100 Build/MocorDroid2.3.5) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.8.0.435 U3/0.8.0 Mobile Safari/533.1',
                'htm',
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
