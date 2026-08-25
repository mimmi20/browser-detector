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

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\ScreamingFrog;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function assert;

#[CoversClass(className: ScreamingFrog::class)]
final class ScreamingFrogTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     * @throws Exception
     */
    #[DataProvider(methodName: 'providerVersion')]
    public function testTestdetectVersion(string $useragent, string | null $expectedVersion): void
    {
        $screamingFrog = new ScreamingFrog(new VersionBuilder());

        $detectedVersion = $screamingFrog->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerVersion(): array
    {
        return [
            [
                'Screaming Frog SEO Spider/2,22',
                '2.22.0',
            ],
        ];
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testDetectVersionFail(): void
    {
        $notNumericException = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('detectVersion')
            ->with('Screaming Frog SEO Spider/2.22', ['Screaming Frog SEO Spider'])
            ->willThrowException($notNumericException);

        assert($versionBuilder instanceof VersionFactoryInterface);
        $screamingFrog = new ScreamingFrog($versionBuilder);

        $detectedVersion = $screamingFrog->detectVersion('Screaming Frog SEO Spider/2,22');

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }
}
