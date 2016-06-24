<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector;

use UaHelper\Utils;

/**
 * Class to detect the generic cpu of an Browser
 *
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Cpu
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = null;

    /**
     * @var string the bits of the detected browser
     */
    private $cpu = null;

    /**
     * sets the user agent to be handled
     *
     * @param string $useragent
     *
     * @return Cpu
     */
    public function setUserAgent($useragent)
    {
        $this->useragent = $useragent;

        return $this;
    }

    public function getCpu()
    {
        if (null === $this->useragent) {
            throw new \UnexpectedValueException(
                'You have to set the useragent before calling this function'
            );
        }

        if (null === $this->cpu) {
            $this->detectCpu();
        }

        return $this->cpu;
    }

    /**
     * detects the bit count by this browser from the given user agent
     *
     * @return Cpu
     */
    private function detectCpu()
    {
        $utils = new Utils();
        $utils->setUserAgent($this->useragent);

        // Intel 64 bits
        if ($utils->checkIfContains(['x64', 'x86_64'])) {
            $this->cpu = 'Intel X64';

            return $this;
        }

        // AMD 64 Bits
        if ($utils->checkIfContains(['amd64', 'AMD64'])) {
            $this->cpu = 'AMD X64';

            return $this;
        }

        // PPC 64 Bits
        if ($utils->checkIfContains(['ppc64'], true)) {
            $this->cpu = 'PPC X64';

            return $this;
        }

        // Intel X86
        if ($utils->checkIfContains(['i586', 'i686', 'i386', 'i486', 'i86'])) {
            $this->cpu = 'Intel X86';

            return $this;
        }

        // PPC 64 Bits
        if ($utils->checkIfContains(['ppc'], true)) {
            $this->cpu = 'PPC';

            return $this;
        }

        // ARM
        if ($utils->checkIfContains(['arm'], true)) {
            $this->cpu = 'ARM';

            return $this;
        }

        $this->cpu = '';

        return $this;
    }
}
