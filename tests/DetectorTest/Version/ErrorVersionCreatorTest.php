<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\ErrorVersionCreator;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

final class ErrorVersionCreatorTest extends TestCase
{
    private ErrorVersionCreator $object;

    /** @throws void */
    protected function setUp(): void
    {
        $this->object = new ErrorVersionCreator();
    }

    /**
     * @throws Exception
     * @throws UnexpectedValueException
     */
    public function testDetectVersion(): void
    {
        $searches = ['xyz'];

        $result = $this->object->detectVersion('', $searches);

        self::assertInstanceOf(VersionInterface::class, $result);

        self::assertSame([], $result->toArray());
        self::assertNull($result->getMajor());
        self::assertNull($result->getMinor());
        self::assertNull($result->getMicro());
        self::assertNull($result->getPatch());
        self::assertNull($result->getMicropatch());
        self::assertNull($result->getBuild());
        self::assertNull($result->getStability());
        self::assertFalse($result->isAlpha());
        self::assertFalse($result->isBeta());

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('32::["xyz"]');

        $result->getVersion(VersionInterface::GET_ZERO_IF_EMPTY);
    }

    /** @throws Exception */
    public function testSetter(): void
    {
        $this->object->setRegex('');
        self::assertInstanceOf(NullVersion::class, $this->object->set(''));
        self::assertInstanceOf(NullVersion::class, ErrorVersionCreator::fromArray([]));
    }
}
