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

namespace BrowserDetectorTest\Header;

use BrowserDetector\Constants;
use BrowserDetector\Header\HeaderInterface;
use BrowserDetector\Header\HeaderLoader;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\NotFoundException;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\NormalizerFactory;

final class HeaderLoaderTest extends TestCase
{
    /** @throws NotFoundException */
    public function testLoadFail(): void
    {
        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $subject = new HeaderLoader(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the header with name "unknown header" was not found');

        $subject->load('unknown header', '');
    }

    /**
     * @throws Exception
     * @throws NotFoundException
     */
    public function testLoadOk(): void
    {
        $value = 'header-value';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $subject = new HeaderLoader(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        $header = $subject->load(Constants::HEADER_USERAGENT, $value);

        self::assertInstanceOf(HeaderInterface::class, $header);
        self::assertSame($value, $header->getValue());
    }

    /** @throws ExpectationFailedException */
    public function testHas(): void
    {
        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $subject = new HeaderLoader(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        self::assertTrue($subject->has(Constants::HEADER_USERAGENT));
    }
}
