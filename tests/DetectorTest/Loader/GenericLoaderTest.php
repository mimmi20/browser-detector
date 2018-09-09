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
namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\GenericLoader;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\Rules;
use BrowserDetector\Loader\SpecificLoaderInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class GenericLoaderTest extends TestCase
{
    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeEmptyData(): void
    {
        $logger = $this->createMock(NullLogger::class);

        $initRules = $this->getMockBuilder(Rules::class)
            ->disableOriginalConstructor()
            ->setMethods(['isInitialized', '__invoke', 'getRules', 'getDefault'])
            ->getMock();

        $initRules
            ->expects(self::once())
            ->method('isInitialized')
            ->will(self::returnValue(false));

        $initRules
            ->expects(self::once())
            ->method('__invoke')
            ->will(self::returnValue(true));

        $initRules
            ->expects(self::once())
            ->method('getRules')
            ->will(self::returnValue([]));

        $initRules
            ->expects(self::once())
            ->method('getDefault')
            ->will(self::returnValue('generic-browser'));

        $initData = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->setMethods(['isInitialized', '__invoke'])
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('isInitialized')
            ->will(self::returnValue(false));

        $initData
            ->expects(self::once())
            ->method('__invoke')
            ->will(self::returnValue(true));

        $specificLoader = $this->getMockBuilder(SpecificLoaderInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $useragent = 'test-ua';

        $specificLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('generic-browser', $useragent)
            ->will(self::returnValue('abc-test'));

        /** @var NullLogger $logger */
        /** @var Rules $initRules */
        /** @var Data $initData */
        /** @var SpecificLoaderInterface $specificLoader */
        $object = new GenericLoader(
            $logger,
            $initRules,
            $initData,
            $specificLoader
        );

        self::assertSame('abc-test', $object($useragent));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeWithData(): void
    {
        $logger = $this->createMock(NullLogger::class);

        $initRules = $this->getMockBuilder(Rules::class)
            ->disableOriginalConstructor()
            ->setMethods(['isInitialized', '__invoke', 'getRules', 'getDefault'])
            ->getMock();

        $initRules
            ->expects(self::once())
            ->method('isInitialized')
            ->will(self::returnValue(true));

        $initRules
            ->expects(self::never())
            ->method('__invoke')
            ->will(self::returnValue(true));

        $initRules
            ->expects(self::once())
            ->method('getRules')
            ->will(self::returnValue([
                                         '/sm\-/i' => [
                                             '/sm\-s/i' => [
                                                 '/sm\-s820l/i' => 'samsung sm-s820l',
                                             ],
                                             '/sm\-z/i' => [
                                                 '/sm\-z130h/i' => 'samsung sm-z130h',
                                             ],
                                         ],
                                     ]));

        $initRules
            ->expects(self::once())
            ->method('getDefault')
            ->will(self::returnValue('generic-browser'));

        $initData = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->setMethods(['isInitialized', '__invoke'])
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('isInitialized')
            ->will(self::returnValue(true));

        $initData
            ->expects(self::never())
            ->method('__invoke')
            ->will(self::returnValue(true));

        $specificLoader = $this->getMockBuilder(SpecificLoaderInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $useragent = 'Mozilla/5.0 (Linux; Tizen 2.3; SAMSUNG SM-Z130H) AppleWebKit/537.3 (KHTML, like Gecko) Version/2.3 Mobile Safari/537.3';

        $specificLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('samsung sm-z130h', $useragent)
            ->will(self::returnValue('abc-test'));

        /** @var NullLogger $logger */
        /** @var Rules $initRules */
        /** @var Data $initData */
        /** @var SpecificLoaderInterface $specificLoader */
        $object = new GenericLoader(
            $logger,
            $initRules,
            $initData,
            $specificLoader
        );

        self::assertSame('abc-test', $object($useragent));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeWithoutDataMatch(): void
    {
        $logger = $this->createMock(NullLogger::class);

        $initRules = $this->getMockBuilder(Rules::class)
            ->disableOriginalConstructor()
            ->setMethods(['isInitialized', '__invoke', 'getRules', 'getDefault'])
            ->getMock();

        $initRules
            ->expects(self::once())
            ->method('isInitialized')
            ->will(self::returnValue(true));

        $initRules
            ->expects(self::never())
            ->method('__invoke')
            ->will(self::returnValue(true));

        $initRules
            ->expects(self::once())
            ->method('getRules')
            ->will(self::returnValue([
                                         '/sm\-/i' => [
                                             '/sm\-s/i' => [
                                                 '/sm\-s820l/i' => 'samsung sm-s820l',
                                             ],
                                             '/sm\-z/i' => [
                                                 '/sm\-z130h/i' => 'samsung sm-z130h',
                                             ],
                                         ],
                                     ]));

        $initRules
            ->expects(self::once())
            ->method('getDefault')
            ->will(self::returnValue('generic-browser'));

        $initData = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->setMethods(['isInitialized', '__invoke'])
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('isInitialized')
            ->will(self::returnValue(true));

        $initData
            ->expects(self::never())
            ->method('__invoke')
            ->will(self::returnValue(true));

        $specificLoader = $this->getMockBuilder(SpecificLoaderInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $useragent = 'test-ua';

        $specificLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('generic-browser', $useragent)
            ->will(self::returnValue('abc-test'));

        /** @var NullLogger $logger */
        /** @var Rules $initRules */
        /** @var Data $initData */
        /** @var SpecificLoaderInterface $specificLoader */
        $object = new GenericLoader(
            $logger,
            $initRules,
            $initData,
            $specificLoader
        );

        self::assertSame('abc-test', $object($useragent));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeSecondRun(): void
    {
        $logger = $this->createMock(NullLogger::class);

        $initRules = $this->getMockBuilder(Rules::class)
            ->disableOriginalConstructor()
            ->setMethods(['isInitialized', '__invoke', 'getRules', 'getDefault'])
            ->getMock();

        $initRules
            ->expects(self::once())
            ->method('isInitialized')
            ->will(self::returnValue(true));

        $initRules
            ->expects(self::never())
            ->method('__invoke')
            ->will(self::returnValue(true));

        $initRules
            ->expects(self::once())
            ->method('getRules')
            ->will(self::returnValue([
                                         '/sm\-/i' => [
                                             '/sm\-s/i' => [
                                                 '/sm\-s820l/i' => 'samsung sm-s820l',
                                             ],
                                             '/sm\-z/i' => [
                                                 '/sm\-z130h/i' => 'samsung sm-z130h',
                                             ],
                                         ],
                                     ]));

        $initRules
            ->expects(self::once())
            ->method('getDefault')
            ->will(self::returnValue('generic-browser'));

        $initData = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->setMethods(['isInitialized', '__invoke'])
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('isInitialized')
            ->will(self::returnValue(true));

        $initData
            ->expects(self::never())
            ->method('__invoke')
            ->will(self::returnValue(true));

        $specificLoader = $this->getMockBuilder(SpecificLoaderInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $useragent = 'test-ua';

        $specificLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('generic-browser', $useragent)
            ->will(self::returnValue('abc-test'));

        /** @var NullLogger $logger */
        /** @var Rules $initRules */
        /** @var Data $initData */
        /** @var SpecificLoaderInterface $specificLoader */
        $object = new GenericLoader(
            $logger,
            $initRules,
            $initData,
            $specificLoader
        );

        self::assertSame('abc-test', $object($useragent));
    }
}
