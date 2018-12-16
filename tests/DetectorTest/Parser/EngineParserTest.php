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
namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\SpecificLoaderFactoryInterface;
use BrowserDetector\Loader\SpecificLoaderInterface;
use BrowserDetector\Parser\EngineParser;
use JsonClass\Json;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use UaResult\Engine\EngineInterface;

class EngineParserTest extends TestCase
{
    /**
     * @var \BrowserDetector\Parser\EngineParser
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        self::markTestIncomplete();
        $logger        = $this->createMock(NullLogger::class);
        $jsonParser    = $this->createMock(JsonInterface::class);
        $companyLoader = $this->createMock(SpecificLoaderInterface::class);

        /* @var NullLogger $logger */
        /* @var Json $jsonParser */
        /* @var \BrowserDetector\Loader\CompanyLoader $companyLoader */
        $this->object = new EngineParser($logger, $jsonParser, $companyLoader);
    }

    /**
     * @dataProvider providerInvoke
     *
     * @param string          $useragent
     * @param EngineInterface $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvoke(string $useragent, EngineInterface $expectedResult): void
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
    public function providerInvoke(): array
    {
        $engine = $this->createMock(EngineInterface::class);

        return [
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                $engine,
            ],
        ];
    }

    /**
     * @dataProvider providerLoad
     *
     * @param string          $useragent
     * @param EngineInterface $expectedResult
     * @param string          $key
     *
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testLoad(string $useragent, string $key, EngineInterface $expectedResult): void
    {
        self::markTestIncomplete();
        $mockLoader = $this->getMockBuilder(SpecificLoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $mockLoader
            ->expects(self::once())
            ->method('load')
            ->with($key, $useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(SpecificLoaderFactoryInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $mockLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->willReturn($mockLoader);

        $property = new \ReflectionProperty($this->object, 'loaderFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $mockLoaderFactory);

        $object = $this->object;

        self::assertSame($expectedResult, $object->load($key, $useragent));
    }

    /**
     * @return array[]
     */
    public function providerLoad(): array
    {
        $engine = $this->createMock(EngineInterface::class);

        return [
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'trident',
                $engine,
            ],
        ];
    }
}
