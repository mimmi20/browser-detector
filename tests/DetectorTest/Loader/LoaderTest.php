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

use BrowserDetector\Cache\Cache;
use BrowserDetector\Loader\GenericLoader;
use BrowserDetector\Loader\Helper\CacheKey;
use BrowserDetector\Loader\Helper\InitData;
use BrowserDetector\Loader\Helper\InitRules;
use BrowserDetector\Loader\SpecificLoaderInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class LoaderTest extends TestCase
{
    /**
     * @throws \ReflectionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeEmptyData(): void
    {
        $logger = $this->createMock(NullLogger::class);

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();

        $cache
            ->expects(self::once())
            ->method('setItem')
            ->with('browser_default__initialized', true)
            ->will(self::returnValue(true));

        $map = [
            ['browser_default__initialized', true],
            ['browser_default__generic-browser', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $map = [
            ['browser_default__initialized', false],
            ['browser_default__rules', []],
            ['browser_default__generic', 'generic-browser'],
            ['browser_default__generic-browser', null],
        ];

        $cache
            ->expects(self::exactly(3))
            ->method('getItem')
            ->will(self::returnValueMap($map));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['initialized', 'browser_default__initialized'],
            ['rules', 'browser_default__rules'],
            ['generic', 'browser_default__generic'],
            ['generic-browser', 'browser_default__generic-browser'],
        ];

        $cacheKey
            ->expects(self::exactly(3))
            ->method('__invoke')
            ->will(self::returnValueMap($map));

        $initRules      = $this->createMock(InitRules::class);
        $initData       = $this->createMock(InitData::class);
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

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var InitRules $initRules */
        /** @var InitData $initData */
        /** @var SpecificLoaderInterface $specificLoader */
        $object = new GenericLoader(
            $cache,
            $logger,
            $cacheKey,
            $initRules,
            $initData,
            $specificLoader
        );

        self::assertSame('abc-test', $object($useragent));
    }

    /**
     * @throws \ReflectionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeWithData(): void
    {
        $logger = $this->createMock(NullLogger::class);

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();

        $cache
            ->expects(self::once())
            ->method('setItem')
            ->with('browser_default__initialized', true)
            ->will(self::returnValue(true));

        $map = [
            ['browser_default__initialized', true],
            ['browser_default__generic-browser', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $map = [
            ['browser_default__initialized', false],
            [
                'browser_default__rules',
                [
                    '/sm\-/i' => [
                        '/sm\-s/i' => [
                            '/sm\-s820l/i' => 'samsung sm-s820l',
                        ],
                        '/sm\-z/i' => [
                            '/sm\-z130h/i' => 'samsung sm-z130h',
                        ],
                    ],
                ],
            ],
            ['browser_default__generic', 'generic-browser'],
            ['browser_default__generic-browser', null],
        ];

        $cache
            ->expects(self::exactly(3))
            ->method('getItem')
            ->will(self::returnValueMap($map));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['initialized', 'browser_default__initialized'],
            ['rules', 'browser_default__rules'],
            ['generic', 'browser_default__generic'],
            ['generic-browser', 'browser_default__generic-browser'],
        ];

        $cacheKey
            ->expects(self::exactly(3))
            ->method('__invoke')
            ->will(self::returnValueMap($map));

        $initRules      = $this->createMock(InitRules::class);
        $initData       = $this->createMock(InitData::class);
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

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var InitRules $initRules */
        /** @var InitData $initData */
        /** @var SpecificLoaderInterface $specificLoader */
        $object = new GenericLoader(
            $cache,
            $logger,
            $cacheKey,
            $initRules,
            $initData,
            $specificLoader
        );

        self::assertSame('abc-test', $object($useragent));
    }

    /**
     * @throws \ReflectionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeWithoutDataMatch(): void
    {
        $logger = $this->createMock(NullLogger::class);

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();

        $cache
            ->expects(self::once())
            ->method('setItem')
            ->with('browser_default__initialized', true)
            ->will(self::returnValue(true));

        $map = [
            ['browser_default__initialized', true],
            ['browser_default__generic-browser', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $map = [
            ['browser_default__initialized', false],
            [
                'browser_default__rules',
                [
                    '/sm\-/i' => [
                        '/sm\-s/i' => [
                            '/sm\-s820l/i' => 'samsung sm-s820l',
                        ],
                        '/sm\-z/i' => [
                            '/sm\-z130h/i' => 'samsung sm-z130h',
                        ],
                    ],
                ],
            ],
            ['browser_default__generic', 'generic-browser'],
            ['browser_default__generic-browser', null],
        ];

        $cache
            ->expects(self::exactly(3))
            ->method('getItem')
            ->will(self::returnValueMap($map));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['initialized', 'browser_default__initialized'],
            ['rules', 'browser_default__rules'],
            ['generic', 'browser_default__generic'],
            ['generic-browser', 'browser_default__generic-browser'],
        ];

        $cacheKey
            ->expects(self::exactly(3))
            ->method('__invoke')
            ->will(self::returnValueMap($map));

        $initRules      = $this->createMock(InitRules::class);
        $initData       = $this->createMock(InitData::class);
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

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var InitRules $initRules */
        /** @var InitData $initData */
        /** @var SpecificLoaderInterface $specificLoader */
        $object = new GenericLoader(
            $cache,
            $logger,
            $cacheKey,
            $initRules,
            $initData,
            $specificLoader
        );

        self::assertSame('abc-test', $object($useragent));
    }

    /**
     * @throws \ReflectionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeSecondRun(): void
    {
        $logger = $this->createMock(NullLogger::class);

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();

        $cache
            ->expects(self::never())
            ->method('setItem')
            ->with('browser_default__initialized', true)
            ->will(self::returnValue(true));

        $map = [
            ['browser_default__initialized', true],
            ['browser_default__generic-browser', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $map = [
            ['browser_default__initialized', true],
            [
                'browser_default__rules',
                [
                    '/sm\-/i' => [
                        '/sm\-s/i' => [
                            '/sm\-s820l/i' => 'samsung sm-s820l',
                        ],
                        '/sm\-z/i' => [
                            '/sm\-z130h/i' => 'samsung sm-z130h',
                        ],
                    ],
                ],
            ],
            ['browser_default__generic', 'generic-browser'],
            ['browser_default__generic-browser', null],
        ];

        $cache
            ->expects(self::exactly(3))
            ->method('getItem')
            ->will(self::returnValueMap($map));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['initialized', 'browser_default__initialized'],
            ['rules', 'browser_default__rules'],
            ['generic', 'browser_default__generic'],
            ['generic-browser', 'browser_default__generic-browser'],
        ];

        $cacheKey
            ->expects(self::exactly(3))
            ->method('__invoke')
            ->will(self::returnValueMap($map));

        $initRules      = $this->createMock(InitRules::class);
        $initData       = $this->createMock(InitData::class);
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

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var InitRules $initRules */
        /** @var InitData $initData */
        /** @var SpecificLoaderInterface $specificLoader */
        $object = new GenericLoader(
            $cache,
            $logger,
            $cacheKey,
            $initRules,
            $initData,
            $specificLoader
        );

        self::assertSame('abc-test', $object($useragent));
    }
}
