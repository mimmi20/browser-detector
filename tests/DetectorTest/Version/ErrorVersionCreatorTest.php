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

use BrowserDetector\Version\ErrorVersionCreator;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionInterface;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

#[CoversClass(className: ErrorVersionCreator::class)]
final class ErrorVersionCreatorTest extends TestCase
{
    private ErrorVersionCreator $errorVersionCreator;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->errorVersionCreator = new ErrorVersionCreator();
    }

    /**
     * @throws Exception
     * @throws UnexpectedValueException
     */
    public function testDetectVersion(): void
    {
        $searches = ['xyz'];

        $version = $this->errorVersionCreator->detectVersion('', $searches);

        self::assertInstanceOf(VersionInterface::class, $version);

        self::assertSame([], $version->toArray());
        self::assertNull($version->getMajor());
        self::assertNull($version->getMinor());
        self::assertNull($version->getMicro());
        self::assertNull($version->getPatch());
        self::assertNull($version->getMicropatch());
        self::assertNull($version->getBuild());
        self::assertNull($version->getStability());
        self::assertFalse($version->isAlpha());
        self::assertFalse($version->isBeta());

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessageIsOrContains('32::["xyz"]');

        $version->getVersion(VersionInterface::GET_ZERO_IF_EMPTY);
    }

    /** @throws Exception */
    public function testSetter(): void
    {
        $this->errorVersionCreator->setRegex('');
        self::assertInstanceOf(NullVersion::class, $this->errorVersionCreator->set(''));
        self::assertInstanceOf(NullVersion::class, ErrorVersionCreator::fromArray([]));
    }
}
