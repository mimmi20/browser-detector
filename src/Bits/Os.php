<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Bits;

use Stringy\Stringy;

final class Os implements BitsInterface
{
    /**
     * @var string the user agent to handle
     */
    private $useragent;

    /**
     * @var int the bits of the detected browser
     */
    private $bits;

    /**
     * class constructor
     *
     * @param string $useragent
     */
    public function __construct(string $useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @throws \UnexpectedValueException
     *
     * @return int
     */
    public function getBits(): int
    {
        if (null !== $this->bits) {
            return $this->bits;
        }

        $this->bits = $this->detectBits();

        return $this->bits;
    }

    /**
     * detects the bit count by this browser from the given user agent
     *
     * @return int
     */
    private function detectBits(): int
    {
        $s = new Stringy($this->useragent);

        if ($s->containsAny(
            ['x64', 'win64', 'wow64', 'x86_64', 'amd64', 'ppc64', 'i686 on x86_64', 'sparc64', 'osf1'],
            false
        )
        ) {
            return 64;
        }

        if ($s->containsAny(['win3.1', 'windows 3.1'], false)) {
            return 16;
        }

        // old deprecated 8 bit systems
        if ($s->containsAny(['cp/m', '8-bit'], false)) {
            return 8;
        }

        return 32;
    }
}
