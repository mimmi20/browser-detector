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

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Helper\Classname;
use WurflCache\Adapter\AdapterInterface;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserFactory
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string                               $agent
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @return \UaMatcher\Browser\BrowserInterface
     */
    public static function detect($agent, AdapterInterface $cache = null)
    {
        foreach (self::getChain($cache) as $browser) {
            /** @var \UaMatcher\Browser\BrowserInterface $browser */
            $browser->setUserAgent($agent);

            if ($browser->canHandle()) {
                return $browser;
            }
        }

        $browser = new UnknownBrowser();
        $browser->setUserAgent($agent);

        return $browser;
    }

    /**
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @return \Generator
     */
    private static function getChain(AdapterInterface $cache = null)
    {
        static $list = null;

        if (null === $list) {
            if (null === $cache) {
                $list = self::buildBrowserChain();
            } else {
                $success = null;
                $list    = $cache->getItem('BrowserChain', $success);

                if (!$success) {
                    $list = self::buildBrowserChain();

                    $cache->setItem('BrowserChain', $list);
                }
            }
        }

        foreach ($list as $browser) {
            yield $browser;
        }
    }

    /**
     * creates the detection chain for browsers
     *
     * @return array
     */
    private static function buildBrowserChain()
    {
        $sourceDirectory = __DIR__ . '/../Browser/';

        $utils    = new Classname();
        $iterator = new \RecursiveDirectoryIterator($sourceDirectory);
        $list     = array();

        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            /** @var $file \SplFileInfo */
            if (!$file->isFile()
                || $file->getExtension() != 'php'
                || 'BrowserInterface' == $file->getBasename('.php')
            ) {
                continue;
            }

            $className = $utils->getClassNameFromFile(
                $file->getBasename('.php'),
                '\BrowserDetector\Detector\Browser',
                true
            );

            try {
                /** @var \UaMatcher\Browser\BrowserInterface $handler */
                $handler = new $className();
            } catch (\Exception $e) {
                continue;
            }

            $list[] = $handler;
        }

        $names   = array();
        $weights = array();

        foreach ($list as $key => $entry) {
            /** @var \UaMatcher\Browser\BrowserInterface $entry */
            $names[$key]   = $entry->getName();
            $weights[$key] = $entry->getWeight();
        }

        array_multisort(
            $weights,
            SORT_DESC,
            SORT_NUMERIC,
            $names,
            SORT_ASC,
            SORT_NATURAL,
            $list
        );

        return $list;
    }
}
