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
use BrowserDetector\Parser\Device\MobileParser;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\Json;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class MobileParserTest extends TestCase
{
    /**
     * @var \BrowserDetector\Parser\Device\MobileParser
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
        $this->object = new MobileParser($logger, $jsonParser, $platformParser);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvokeFail(): void
    {
        self::markTestIncomplete();
        $mockLoaderFactory = $this->getMockBuilder(SpecificLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('samsung', 'mobile')
            ->willThrowException(new \Exception('error'));

        $property = new \ReflectionProperty($this->object, 'loaderFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $mockLoaderFactory);

        $object = $this->object;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('An error occured while matching rule "/samsung[is \-;\/](?!galaxy nexus)|galaxy(?! nexus)|(gt|sam|sc|sch|sec|sgh|shv|shw|sm|sph|continuum|ek|yp)-|g710[68]|n8000d|n[579]1[01]0|f031|n900\+|sc[lt]2[0-9]|isw11sc|s7562|sghi[0-9]{3}|i8910|i545|i(7110|9100|9300)|blaze|s8500/i"');

        $object('Mozilla/5.0 (Linux; Tizen 2.3; SAMSUNG SM-Z130H) AppleWebKit/537.3 (KHTML, like Gecko) Version/2.3 Mobile Safari/537.3');
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
            ->with($expectedCompany, 'mobile')
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
