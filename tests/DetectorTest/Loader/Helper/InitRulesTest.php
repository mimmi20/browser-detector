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
namespace BrowserDetectorTest\Loader\Helper;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Loader\Helper\CacheKey;
use BrowserDetector\Loader\Helper\InitRules;
use PHPUnit\Framework\TestCase;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Finder\SplFileInfo;

class InitRulesTest extends TestCase
{
    /**
     * @throws \ReflectionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeFail(): void
    {
        $cache      = $this->createMock(Cache::class);
        $jsonParser = $this->getMockBuilder(JsonParser::class)
            ->disableOriginalConstructor()
            ->setMethods(['parse'])
            ->getMock();

        $jsonParser
            ->expects(self::once())
            ->method('parse')
            ->will(self::throwException(new ParsingException('error')));

        $cacheKey = $this->createMock(CacheKey::class);
        $file     = $this->createMock(SplFileInfo::class);

        /** @var Cache $cache */
        /** @var JsonParser $jsonParser */
        /** @var CacheKey $cacheKey */
        /** @var SplFileInfo $file */
        $object = new InitRules($cache, $jsonParser, $cacheKey, $file);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('file "" contains invalid json');
        $object();
    }

    /**
     * @throws \ReflectionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeSuccess(): void
    {
        $cache      = $this->createMock(Cache::class);
        $jsonParser = $this->getMockBuilder(JsonParser::class)
            ->disableOriginalConstructor()
            ->setMethods(['parse'])
            ->getMock();

        $jsonParser
            ->expects(self::once())
            ->method('parse')
            ->will(self::returnValue(['rules' => 'abc', 'generic' => 'test']));

        $cacheKey = $this->createMock(CacheKey::class);
        $file     = $this->createMock(SplFileInfo::class);

        /** @var Cache $cache */
        /** @var JsonParser $jsonParser */
        /** @var CacheKey $cacheKey */
        /** @var SplFileInfo $file */
        $object = new InitRules($cache, $jsonParser, $cacheKey, $file);

        $object();

        self::assertTrue(true);
    }
}
