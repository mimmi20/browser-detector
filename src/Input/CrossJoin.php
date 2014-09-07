<?php
/**
 * Copyright (c) 2012-2014, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Input;

use BrowserDetector\Detector\Bits as BitsDetector;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Result;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\InputMapper;
use Crossjoin\Browscap\Browscap;
use Crossjoin\Browscap\Updater\Local;
use Monolog\Logger;
use WurflCache\Adapter\AdapterInterface;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class CrossJoin extends AbstractBrowscapInput
{
    /**
     * the parser class
     *
     * @var \Crossjoin\Browscap\Browscap
     */
    private $parser = null;

    /**
     * sets the UA Parser detector
     *
     * @param \Crossjoin\Browscap\Browscap $parser
     *
     * @internal param \Crossjoin\Browscap\Browscap $parser
     *
     * @return CrossJoin
     */
    public function setParser(Browscap $parser)
    {
        $this->parser = $parser;

        return $this;
    }

    /**
     * sets the main parameters to the parser
     *
     * @throws \UnexpectedValueException
     * @return \Crossjoin\Browscap\Browscap
     */
    protected function initParser()
    {
        if (!($this->parser instanceof Browscap)) {
            throw new \UnexpectedValueException(
                'the parser object has to be an instance of \\phpbrowscap\\Detector'
            );
        }

        if (null !== $this->localFile) {
            $updater = new Local();
            $updater->setOption('LocalFile', $this->localFile);
            Browscap::setUpdater($updater);
        }

        return $this->parser;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \BrowserDetector\Detector\Result the object containing the browsers details.
     * @throws \UnexpectedValueException
     */
    public function getBrowser()
    {
        $parserResult = (array) $this->initParser()->getBrowser($this->_agent)->getData();

        return $this->setResultData($parserResult);
    }
}