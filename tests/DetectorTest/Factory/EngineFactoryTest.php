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
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\EngineFactory;
use BrowserDetector\Loader\EngineLoaderFactory;
use BrowserDetector\Loader\GenericLoader;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

class EngineFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Factory\EngineFactory
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        /** @var NullLogger $logger */
        $logger = $this->createMock(NullLogger::class);

        $this->object = new EngineFactory($logger);
    }

    /**
     * @dataProvider providerInvoke
     *
     * @param string          $useragent
     * @param EngineInterface $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return void
     */
    public function testInvoke(string $useragent, EngineInterface $expectedResult): void
    {
        $mockLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $mockLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(EngineLoaderFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
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
        return [
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                new Engine(),
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
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return void
     */
    public function testLoad(string $useragent, string $key, EngineInterface $expectedResult): void
    {
        $mockLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();
        $mockLoader
            ->expects(self::once())
            ->method('load')
            ->with($key, $useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(EngineLoaderFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
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
        return [
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'trident',
                new Engine(),
            ],
        ];
    }
}
