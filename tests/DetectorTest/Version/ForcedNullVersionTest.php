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

use BrowserDetector\Version\ForcedNullVersion;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

#[CoversClass(ForcedNullVersion::class)]
final class ForcedNullVersionTest extends TestCase
{
    private ForcedNullVersion $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new ForcedNullVersion();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetPatch(): void
    {
        self::assertNull($this->object->getPatch());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetBuild(): void
    {
        self::assertNull($this->object->getBuild());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetStability(): void
    {
        self::assertNull($this->object->getStability());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testToArray(): void
    {
        self::assertSame(
            [
                'major' => null,
                'minor' => null,
                'micro' => null,
                'patch' => null,
                'micropatch' => null,
                'stability' => null,
                'build' => null,
            ],
            $this->object->toArray(),
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetMajor(): void
    {
        self::assertNull($this->object->getMajor());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetMicropatch(): void
    {
        self::assertNull($this->object->getMicropatch());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testIsBeta(): void
    {
        self::assertNull($this->object->isBeta());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetMicro(): void
    {
        self::assertNull($this->object->getMicro());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testIsAlpha(): void
    {
        self::assertNull($this->object->isAlpha());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetVersion(): void
    {
        self::assertNull($this->object->getVersion());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetMinor(): void
    {
        self::assertNull($this->object->getMinor());
    }
}
