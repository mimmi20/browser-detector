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

namespace BrowserDetector\Detector\Browser;

use BrowserDetector\Detector\Engine;
use BrowserDetector\Detector\Factory\CompanyFactory;
use BrowserDetector\Matcher\Browser\BrowserHasSpecificEngineInterface;
use BrowserDetector\Version\VersionFactory;
use UaBrowserType;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BingProductsBot extends AbstractBrowser implements BrowserHasSpecificEngineInterface
{
    /**
     * Class Constructor
     *
     * @param string $useragent the user agent to be handled
     */
    public function __construct($useragent)
    {
        $this->useragent                   = $useragent;
        $this->name                        = 'Bing Product Search';
        $this->modus                       = null;
        $this->version                     = VersionFactory::detectVersion($useragent, ['msnbot\-Products']);
        $this->manufacturer                = CompanyFactory::get('Microsoft')->getName();
        $this->brand                       = CompanyFactory::get('Microsoft')->getBrandName();
        $this->pdfSupport                  = true;
        $this->rssSupport                  = false;
        $this->canSkipAlignedLinkRow       = false;
        $this->claimsWebSupport            = false;
        $this->supportsEmptyOptionValues   = true;
        $this->supportsBasicAuthentication = true;
        $this->supportsPostMethod          = true;
        $this->type                        = new UaBrowserType\Bot();
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\Engine\UnknownEngine
     */
    public function getEngine()
    {
        return new Engine\UnknownEngine($this->useragent, []);
    }
}
