<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Helper;

use UaHelper\Utils;

/**
 * a helper to detect windows
 *
 * @package   BrowserDetector
 */
class Linux
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = '';

    /**
     * @var \UaHelper\Utils the helper class
     */
    private $utils = null;

    /**
     * Class Constructor
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Helper\Linux
     */
    public function __construct($useragent)
    {
        $this->utils = new Utils();

        $this->useragent = $useragent;
        $this->utils->setUserAgent($useragent);
    }

    public function isLinux()
    {
        $linux = array(
            'linux',
            'debian',
            'ubuntu',
            'suse',
            'fedora',
            'mint',
            'redhat',
            'slackware',
            'zenwalk gnu',
            'xentos',
            'kubuntu',
            'cros',
            'moblin'
        );

        if (!$this->utils->checkIfContains($linux, true)) {
            return false;
        }

        $noLinux = array('Loewe; SL121', 'eeepc', 'Microsoft Office', 'InfegyAtlas');

        if ($this->utils->checkIfContains($noLinux)) {
            return false;
        }

        return true;
    }
}
