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

namespace BrowserDetectorTest\Parser\Header;

use BrowserDetector\Data\Engine;
use BrowserDetector\Data\Os;
use BrowserDetector\Parser\Header\CrawledByClientCode;
use BrowserDetector\Parser\Header\CrawledByClientVersion;
use BrowserDetector\Parser\Header\CrawledByEngineCode;
use BrowserDetector\Parser\Header\CrawledByEngineVersion;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\ClientHeader;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;
use UnexpectedValueException;

use function sprintf;

#[CoversClass(className: CrawledByClientCode::class)]
#[CoversClass(className: CrawledByClientVersion::class)]
#[CoversClass(className: CrawledByEngineCode::class)]
#[CoversClass(className: CrawledByEngineVersion::class)]
final class CrawledByTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider(methodName: 'providerUa')]
    public function testData(
        string $ua,
        bool $hasClientInfo,
        string | null $clientCode,
        bool $hasClientVersion,
        string | null $clientVersion,
    ): void {
        $clientHeader = new ClientHeader(
            value: $ua,
            clientCode: new CrawledByClientCode(),
            clientVersion: new CrawledByClientVersion(),
            engineCode: new CrawledByEngineCode(),
            engineVersion: new CrawledByEngineVersion(),
        );

        self::assertSame($ua, $clientHeader->getValue(), sprintf('value mismatch for ua "%s"', $ua));
        self::assertSame(
            $ua,
            $clientHeader->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $clientHeader->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Architecture::unknown,
            $clientHeader->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $clientHeader->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Bits::unknown,
            $clientHeader->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $clientHeader->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $clientHeader->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $clientHeader->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $clientHeader->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientInfo,
            $clientHeader->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $clientCode,
            $clientHeader->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientVersion,
            $clientHeader->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );

        if ($clientVersion === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $clientHeader->getClientVersion(),
                sprintf('browser info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $clientVersion,
                $clientHeader->getClientVersion()->getVersion(),
                sprintf('browser info mismatch for ua "%s"', $ua),
            );
        }

        self::assertFalse(
            $clientHeader->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );

        try {
            $clientHeader->getPlatformCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertFalse(
            $clientHeader->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $clientHeader->getPlatformVersionWithOs(Os::unknown),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $clientHeader->hasEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );

        self::assertSame(
            Engine::unknown,
            $clientHeader->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );

        self::assertTrue(
            $clientHeader->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            ForcedNullVersion::class,
            $clientHeader->getEngineVersionWithEngine(Engine::unknown),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }

    /**
     * @return array<int, array<int, bool|string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['RecordedFuture-ASI-Crawl', true, null, true, null],
        ];
    }
}
