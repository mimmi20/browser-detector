<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\ScreamingFrog;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;

final class ScreamingFrogTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\ScreamingFrog
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new ScreamingFrog();
    }

    /**
     * @dataProvider providerVersion
     *
     * @param string $useragent
     * @param string $expectedVersion
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testTestdetectVersion(string $useragent, string $expectedVersion): void
    {
        $detectedVersion = $this->object->detectVersion($useragent);

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array[]
     */
    public function providerVersion(): array
    {
        return [
            [
                'Screaming Frog SEO Spider/2,22',
                '2.22.0',
            ],
        ];
    }
}
