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

use BrowserDetector\Parser\Header\SetVersionTrait;
use BrowserDetector\Parser\Header\UseragentClientVersion;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use UaLoader\BrowserLoaderInterface;
use UaLoader\Data\ClientDataInterface;
use UaLoader\Exception\NotFoundException;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\BrowserParserInterface;
use UaResult\Browser\BrowserInterface;
use UnexpectedValueException;

#[CoversClass(UseragentClientVersion::class)]
#[CoversTrait(SetVersionTrait::class)]
final class UseragentClientVersionTest extends TestCase
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
        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertSame(
            $expected,
            $header->getClientVersion($value, 'unknown')->getVersion(),
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
            ['pf(Linux);la(en-US);re(U2/1.0.0);dv(TECNO_S3);pr(UCBrowser/8.8.1.359);ov(4.2.2);pi(320*480);ss(320*480);up(U2/1.0.0);er(U);bt(GJ);pm(1);nm(0);im(0);sr(2);nt(99);', '8.8.1.359'],
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
        $code  = 'unknown';
        $v     = 'x';

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($v);

        $loadedClient = $this->createMock(BrowserInterface::class);
        $loadedClient
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($version);
        $loadedClient
            ->expects(self::never())
            ->method('getManufacturer');
        $loadedClient
            ->expects(self::never())
            ->method('getName');
        $loadedClient
            ->expects(self::never())
            ->method('getModus');
        $loadedClient
            ->expects(self::never())
            ->method('getBits');
        $loadedClient
            ->expects(self::never())
            ->method('getType');
        $loadedClient
            ->expects(self::never())
            ->method('toArray');
        $loadedClient
            ->expects(self::never())
            ->method('withVersion');

        $loadedClientData = $this->createMock(ClientDataInterface::class);
        $loadedClientData
            ->expects(self::once())
            ->method('getClient')
            ->willReturn($loadedClient);
        $loadedClientData
            ->expects(self::never())
            ->method('getEngine');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($code, $value)
            ->willReturn($loadedClientData);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertInstanceOf(
            NullVersion::class,
            $header->getClientVersion($value, 'unknown'),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing2(): void
    {
        $value = 'WhatsApp/2.2587.9 W';
        $code  = 'unknown';

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($code, $value)
            ->willThrowException(new NotFoundException('b'));

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertInstanceOf(
            NullVersion::class,
            $header->getClientVersion($value, 'unknown'),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing3(): void
    {
        $value = 'WhatsApp/2.2587.9 W';
        $code  = 'unknown';

        $loadedClient = $this->createMock(BrowserInterface::class);
        $loadedClient
            ->expects(self::once())
            ->method('getVersion')
            ->willThrowException(new UnexpectedValueException('c'));
        $loadedClient
            ->expects(self::never())
            ->method('getManufacturer');
        $loadedClient
            ->expects(self::never())
            ->method('getName');
        $loadedClient
            ->expects(self::never())
            ->method('getModus');
        $loadedClient
            ->expects(self::never())
            ->method('getBits');
        $loadedClient
            ->expects(self::never())
            ->method('getType');
        $loadedClient
            ->expects(self::never())
            ->method('toArray');
        $loadedClient
            ->expects(self::never())
            ->method('withVersion');

        $loadedClientData = $this->createMock(ClientDataInterface::class);
        $loadedClientData
            ->expects(self::once())
            ->method('getClient')
            ->willReturn($loadedClient);
        $loadedClientData
            ->expects(self::never())
            ->method('getEngine');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($code, $value)
            ->willReturn($loadedClientData);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertInstanceOf(
            NullVersion::class,
            $header->getClientVersion($value, 'unknown'),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing4(): void
    {
        $value = 'WhatsApp/2.2587.9 W';
        $code  = 'unknown';
        $v     = '';

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($v);

        $loadedClient = $this->createMock(BrowserInterface::class);
        $loadedClient
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($version);
        $loadedClient
            ->expects(self::never())
            ->method('getManufacturer');
        $loadedClient
            ->expects(self::never())
            ->method('getName');
        $loadedClient
            ->expects(self::never())
            ->method('getModus');
        $loadedClient
            ->expects(self::never())
            ->method('getBits');
        $loadedClient
            ->expects(self::never())
            ->method('getType');
        $loadedClient
            ->expects(self::never())
            ->method('toArray');
        $loadedClient
            ->expects(self::never())
            ->method('withVersion');

        $loadedClientData = $this->createMock(ClientDataInterface::class);
        $loadedClientData
            ->expects(self::once())
            ->method('getClient')
            ->willReturn($loadedClient);
        $loadedClientData
            ->expects(self::never())
            ->method('getEngine');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($code, $value)
            ->willReturn($loadedClientData);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertInstanceOf(
            NullVersion::class,
            $header->getClientVersion($value, 'unknown'),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing5(): void
    {
        $value = 'WhatsApp/2.2587.9 W';
        $code  = 'unknown';
        $v     = null;

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($v);

        $loadedClient = $this->createMock(BrowserInterface::class);
        $loadedClient
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($version);
        $loadedClient
            ->expects(self::never())
            ->method('getManufacturer');
        $loadedClient
            ->expects(self::never())
            ->method('getName');
        $loadedClient
            ->expects(self::never())
            ->method('getModus');
        $loadedClient
            ->expects(self::never())
            ->method('getBits');
        $loadedClient
            ->expects(self::never())
            ->method('getType');
        $loadedClient
            ->expects(self::never())
            ->method('toArray');
        $loadedClient
            ->expects(self::never())
            ->method('withVersion');

        $loadedClientData = $this->createMock(ClientDataInterface::class);
        $loadedClientData
            ->expects(self::once())
            ->method('getClient')
            ->willReturn($loadedClient);
        $loadedClientData
            ->expects(self::never())
            ->method('getEngine');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($code, $value)
            ->willReturn($loadedClientData);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertInstanceOf(
            NullVersion::class,
            $header->getClientVersion($value, 'unknown'),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing6(): void
    {
        $value = 'WhatsApp/2.2587.9 W';
        $code  = 'unknown';
        $v     = 'x';

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($v);

        $loadedClient = $this->createMock(BrowserInterface::class);
        $loadedClient
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($version);
        $loadedClient
            ->expects(self::never())
            ->method('getManufacturer');
        $loadedClient
            ->expects(self::never())
            ->method('getName');
        $loadedClient
            ->expects(self::never())
            ->method('getModus');
        $loadedClient
            ->expects(self::never())
            ->method('getBits');
        $loadedClient
            ->expects(self::never())
            ->method('getType');
        $loadedClient
            ->expects(self::never())
            ->method('toArray');
        $loadedClient
            ->expects(self::never())
            ->method('withVersion');

        $loadedClientData = $this->createMock(ClientDataInterface::class);
        $loadedClientData
            ->expects(self::once())
            ->method('getClient')
            ->willReturn($loadedClient);
        $loadedClientData
            ->expects(self::never())
            ->method('getEngine');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn($code);

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($code, $value)
            ->willReturn($loadedClientData);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertInstanceOf(
            NullVersion::class,
            $header->getClientVersion($value),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing7(): void
    {
        $value = 'WhatsApp/2.2587.9 W';

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn('');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertInstanceOf(
            ForcedNullVersion::class,
            $header->getClientVersion($value),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithParsing8(): void
    {
        $value = 'WhatsApp/2.2587.9 W';

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willThrowException(new UnexpectedValueException('e'));

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertInstanceOf(
            NullVersion::class,
            $header->getClientVersion($value),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUas(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException(new \UaNormalizer\Normalizer\Exception\Exception('b'));

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertInstanceOf(
            ForcedNullVersion::class,
            $header->getClientVersion($value, 'unknown'),
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

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn('');

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertInstanceOf(
            ForcedNullVersion::class,
            $header->getClientVersion($value, 'unknown'),
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

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException(new \UaNormalizer\Normalizer\Exception\Exception('x'));

        $header = new UseragentClientVersion(
            browserParser: $browserParser,
            browserLoader: $browserLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasClientVersion($value));
        self::assertInstanceOf(
            ForcedNullVersion::class,
            $header->getClientVersion($value, 'unknown'),
        );
    }
}
