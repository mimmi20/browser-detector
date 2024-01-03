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

namespace BrowserDetectorTest\Bits;

use BrowserDetector\Bits\Os;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

final class OsTest extends TestCase
{
    private Os $object;

    /** @throws void */
    protected function setUp(): void
    {
        $this->object = new Os();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    #[DataProvider('providerGetBits')]
    public function testGetBits(string $useragent, int | null $expected): void
    {
        $result = $this->object->getBits($useragent);
        self::assertSame($expected, $result);

        $secondResult = $this->object->getBits($useragent);
        self::assertSame($expected, $secondResult);
        self::assertSame($result, $secondResult);
    }

    /**
     * @return array<int, array<string, int|string|null>>
     *
     * @throws void
     */
    public static function providerGetBits(): array
    {
        return [
            [
                'ua' => 'Mozilla/5.0 (X11; Linux i686 on x86_64; rv:38.0) Gecko/20100101 Firefox/38.0 Iceweasel/38.5.0',
                'expected' => 64,
            ],
            [
                'ua' => 'Mozilla/5.0 (X11; U; Linux x86_64; C) AppleWebKit/533.3 (KHTML, like Gecko) Qt/4.7.1 Safari/533.3',
                'expected' => 64,
            ],
            [
                'ua' => 'Mozilla/2.0 (Compatible; MSIE 3.02; AOL 4.0; Windows 3.1)',
                'expected' => 16,
            ],
            [
                'ua' => 'ShitScript/1.0 (CP/M; 8-bit)',
                'expected' => 8,
            ],
            [
                'ua' => 'Mozilla/5.0 Galeon/1.2.6 (X11; Linux i686; U;) Gecko/20020830',
                'expected' => null,
            ],
            [
                'ua' => 'Mozilla/5.0 (X11; U; Linux i686 (x86_64); en-US; rv:1.9.2.19) Gecko WebThumb/1.0',
                'expected' => 64,
            ],
            [
                'ua' => 'Mozilla/5.0 (Linux; arm_64; Android 9; I4213) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.143 YaBrowser/19.7.5.90.00 Mobile Safari/537.36',
                'expected' => 64,
            ],
            [
                'ua' => 'Mozilla/5.0 (Linux; ARM_64; Android 9; I4213) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.143 YaBrowser/19.7.5.90.00 Mobile Safari/537.36',
                'expected' => 64,
            ],
            [
                'ua' => 'Mozilla/5.0 (X11; U; Linux i686 (x86_64); en-US; rv:1.8.1.4) Gecko/20080721 BonEcho/2.0.0.4',
                'expected' => 64,
            ],
            [
                'ua' => 'Mozilla/5.0 (X11; U; Linux I686 (X86_64); en-US; rv:1.8.1.4) Gecko/20080721 BonEcho/2.0.0.4',
                'expected' => 64,
            ],
            [
                'ua' => 'ShitScript/1.0 (CP/M; 8-BIT)',
                'expected' => 8,
            ],
            [
                'ua' => 'Mozilla/5.0 (X11; U; Linux X86_64; C) AppleWebKit/533.3 (KHTML, like Gecko) Qt/4.7.1 Safari/533.3',
                'expected' => 64,
            ],
            [
                'ua' => 'Mozilla/5.0 (X11; Linux I686 on x86_64; rv:38.0) Gecko/20100101 Firefox/38.0 Iceweasel/38.5.0',
                'expected' => 64,
            ],
            [
                'ua' => 'ELinks (0.4.3; NetBSD 3.0.2_PATCH sparc64; 80x25)',
                'expected' => 64,
            ],
            [
                'ua' => 'Mozilla/5.0 (X11; U; Linux sparc64; en-GB; rv:1.8.1.11) Gecko/20071217 Galeon/2.0.3 Firefox/2.0.0.11',
                'expected' => 64,
            ],
            [
                'ua' => 'WordPress/3.2.1; http://www.sparcampus.de/blog',
                'expected' => null,
            ],
            [
                'ua' => 'WordPress/3.2.1; http://sparcheck-24.net',
                'expected' => null,
            ],
            [
                'ua' => 'Mozilla/5.0 (X11; U; Linux sparc; en-US; rv:1.5) Gecko/20041129',
                'expected' => 32,
            ],
            [
                'ua' => 'Mozilla/3.0 (X11; I; OSF1 V4.0 alpha)',
                'expected' => 64,
            ],
            [
                'ua' => 'Mozilla/5.0 (X11; U; Linux SPARC; en-US; rv:1.5) Gecko/20041129',
                'expected' => 32,
            ],
        ];
    }
}
