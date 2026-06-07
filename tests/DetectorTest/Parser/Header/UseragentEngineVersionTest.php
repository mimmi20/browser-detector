<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Parser\Header;

use BrowserDetector\Data\Engine;
use BrowserDetector\Parser\Header\UseragentEngineVersion;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use UaLoader\EngineLoaderInterface;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\EngineParserInterface;
use UaResult\Engine\EngineInterface;
use UnexpectedValueException;

#[CoversClass(UseragentEngineVersion::class)]
final class UseragentEngineVersionTest extends TestCase
{
    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     * @throws UnexpectedValueException
     */
    #[DataProvider('providerUa1')]
    public function testWithoutParsing(string $value, string $expected): void
    {
        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::never())
            ->method('loadFromEngine');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentEngineVersion(
            engineParser: $engineParser,
            engineLoader: $engineLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasEngineVersion($value));
        self::assertSame(
            $expected,
            $header->getEngineVersionWithEngine($value, Engine::unknown)->getVersion(),
        );
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerUa1(): array
    {
        return [
            ['pf(Linux);la(en-US);re(U2/1.0.0);dv(TECNO_S3);pr(UCBrowser/8.8.1.359);ov(4.2.2);pi(320*480);ss(320*480);up(U2/1.0.0);er(U);bt(GJ);pm(1);nm(0);im(0);sr(2);nt(99);', '1.0.0'],
        ];
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing(): void
    {
        $value = 'WhatsApp/2.2587.9 W';

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn(Engine::unknown);

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::never())
            ->method('loadFromEngine');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentEngineVersion(
            engineParser: $engineParser,
            engineLoader: $engineLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasEngineVersion($value));
        self::assertInstanceOf(
            ForcedNullVersion::class,
            $header->getEngineVersionWithEngine($value, Engine::unknown),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing2(): void
    {
        $value  = 'WhatsApp/2.2587.9 W';
        $engine = Engine::blink;

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn($engine);

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::once())
            ->method('loadFromEngine')
            ->with($engine, $value)
            ->willThrowException(new UnexpectedValueException('x'));

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentEngineVersion(
            engineParser: $engineParser,
            engineLoader: $engineLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasEngineVersion($value));
        self::assertInstanceOf(
            NullVersion::class,
            $header->getEngineVersionWithEngine($value, Engine::unknown),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing3(): void
    {
        $value  = 'WhatsApp/2.2587.9 W';
        $engine = Engine::blink;

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->willThrowException(new UnexpectedValueException('y'));

        $loadedEngine = $this->createMock(EngineInterface::class);
        $loadedEngine
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($version);
        $loadedEngine
            ->expects(self::never())
            ->method('getManufacturer');
        $loadedEngine
            ->expects(self::never())
            ->method('getName');
        $loadedEngine
            ->expects(self::never())
            ->method('toArray');
        $loadedEngine
            ->expects(self::never())
            ->method('withVersion');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::once())
            ->method('loadFromEngine')
            ->with($engine, $value)
            ->willReturn($loadedEngine);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentEngineVersion(
            engineParser: $engineParser,
            engineLoader: $engineLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasEngineVersion($value));
        self::assertInstanceOf(
            NullVersion::class,
            $header->getEngineVersionWithEngine($value, $engine),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing4(): void
    {
        $value  = 'WhatsApp/2.2587.9 W';
        $engine = Engine::blink;

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn(null);

        $loadedEngine = $this->createMock(EngineInterface::class);
        $loadedEngine
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($version);
        $loadedEngine
            ->expects(self::never())
            ->method('getManufacturer');
        $loadedEngine
            ->expects(self::never())
            ->method('getName');
        $loadedEngine
            ->expects(self::never())
            ->method('toArray');
        $loadedEngine
            ->expects(self::never())
            ->method('withVersion');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::once())
            ->method('loadFromEngine')
            ->with($engine, $value)
            ->willReturn($loadedEngine);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentEngineVersion(
            engineParser: $engineParser,
            engineLoader: $engineLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasEngineVersion($value));
        self::assertInstanceOf(
            NullVersion::class,
            $header->getEngineVersionWithEngine($value, $engine),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing5(): void
    {
        $value  = 'WhatsApp/2.2587.9 W';
        $engine = Engine::blink;

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn('');

        $loadedEngine = $this->createMock(EngineInterface::class);
        $loadedEngine
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($version);
        $loadedEngine
            ->expects(self::never())
            ->method('getManufacturer');
        $loadedEngine
            ->expects(self::never())
            ->method('getName');
        $loadedEngine
            ->expects(self::never())
            ->method('toArray');
        $loadedEngine
            ->expects(self::never())
            ->method('withVersion');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::once())
            ->method('loadFromEngine')
            ->with($engine, $value)
            ->willReturn($loadedEngine);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentEngineVersion(
            engineParser: $engineParser,
            engineLoader: $engineLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasEngineVersion($value));
        self::assertInstanceOf(
            NullVersion::class,
            $header->getEngineVersionWithEngine($value, $engine),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing6(): void
    {
        $value  = 'WhatsApp/2.2587.9 W';
        $engine = Engine::blink;
        $v      = '1.0.0';

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($v);

        $loadedEngine = $this->createMock(EngineInterface::class);
        $loadedEngine
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($version);
        $loadedEngine
            ->expects(self::never())
            ->method('getManufacturer');
        $loadedEngine
            ->expects(self::never())
            ->method('getName');
        $loadedEngine
            ->expects(self::never())
            ->method('toArray');
        $loadedEngine
            ->expects(self::never())
            ->method('withVersion');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::once())
            ->method('loadFromEngine')
            ->with($engine, $value)
            ->willReturn($loadedEngine);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentEngineVersion(
            engineParser: $engineParser,
            engineLoader: $engineLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasEngineVersion($value));

        $resultVersion = $header->getEngineVersionWithEngine($value, $engine);

        self::assertInstanceOf(Version::class, $resultVersion);

        self::assertSame($v, $resultVersion->getVersion());
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing7(): void
    {
        $value  = 'WhatsApp/2.2587.9 W';
        $engine = Engine::blink;
        $v      = 'x';

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($v);

        $loadedEngine = $this->createMock(EngineInterface::class);
        $loadedEngine
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($version);
        $loadedEngine
            ->expects(self::never())
            ->method('getManufacturer');
        $loadedEngine
            ->expects(self::never())
            ->method('getName');
        $loadedEngine
            ->expects(self::never())
            ->method('toArray');
        $loadedEngine
            ->expects(self::never())
            ->method('withVersion');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::once())
            ->method('loadFromEngine')
            ->with($engine, $value)
            ->willReturn($loadedEngine);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentEngineVersion(
            engineParser: $engineParser,
            engineLoader: $engineLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasEngineVersion($value));

        $resultVersion = $header->getEngineVersionWithEngine($value, $engine);

        self::assertInstanceOf(NullVersion::class, $resultVersion);
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUas(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::never())
            ->method('loadFromEngine');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException(new \UaNormalizer\Normalizer\Exception\Exception('a'));

        $header = new UseragentEngineVersion(
            engineParser: $engineParser,
            engineLoader: $engineLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasEngineVersion($value));
        self::assertInstanceOf(
            ForcedNullVersion::class,
            $header->getEngineVersionWithEngine($value, Engine::unknown),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUas2(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::never())
            ->method('loadFromEngine');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn('');

        $header = new UseragentEngineVersion(
            engineParser: $engineParser,
            engineLoader: $engineLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasEngineVersion($value));
        self::assertInstanceOf(
            ForcedNullVersion::class,
            $header->getEngineVersionWithEngine($value, Engine::unknown),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUas3(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::never())
            ->method('loadFromEngine');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException(new \UaNormalizer\Normalizer\Exception\Exception('x'));

        $header = new UseragentEngineVersion(
            engineParser: $engineParser,
            engineLoader: $engineLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasEngineVersion($value));
        self::assertInstanceOf(
            ForcedNullVersion::class,
            $header->getEngineVersionWithEngine($value, Engine::unknown),
        );
    }
}
