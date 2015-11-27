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

use BrowserDetector\Detector\Browser\Android;
use BrowserDetector\Detector\Browser\Chrome;
use BrowserDetector\Detector\Browser\Dalvik;
use BrowserDetector\Detector\Browser\FastbotCrawler;
use BrowserDetector\Detector\Browser\Firefox;
use BrowserDetector\Detector\Browser\FlyFlow;
use BrowserDetector\Detector\Browser\MicrosoftEdge;
use BrowserDetector\Detector\Browser\MicrosoftInternetExplorer;
use BrowserDetector\Detector\Browser\PhantomJs;
use BrowserDetector\Detector\Browser\Safari;
use BrowserDetector\Detector\Browser\SecureBrowser360;
use BrowserDetector\Detector\Browser\SpeedBrowser360;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Browser\YahooSlurp;
use BrowserDetector\Helper\Classname;
use Psr\Log\LoggerInterface;
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
     * @param \Psr\Log\LoggerInterface             $logger
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @return \UaMatcher\Browser\BrowserInterface
     */
    public static function detect($agent, LoggerInterface $logger, AdapterInterface $cache = null)
    {
        /*
        if (preg_match('/(flyflow)/i', $agent)) {
            $browser = new FlyFlow($agent, $logger);
        } elseif (preg_match('/(dalvik)/i', $agent)) {
            $browser = new Dalvik($agent, $logger);
        } elseif (preg_match('/(dol(ph|f)in)/i', $agent)) {
            $browser = new Dalvik($agent, $logger);
        } elseif (preg_match('/(qihu 360se)/i', $agent)) {
            $browser = new SecureBrowser360($agent, $logger);
        } elseif (preg_match('/(qihu 360ee)/i', $agent)) {
            $browser = new SpeedBrowser360($agent, $logger);
        } elseif (preg_match('/(edge)/i', $agent)) {
            $browser = new MicrosoftEdge($agent, $logger);
        } elseif (preg_match('/(msie)/i', $agent)) {
            $browser = new MicrosoftInternetExplorer($agent, $logger);
        } elseif (preg_match('/((linux|android).*version.*chrome.*safari)/i', $agent)) {
            $browser = new Android($agent, $logger);
        } elseif (preg_match('/(chrome|crmo)/i', $agent)) {
            $browser = new Chrome($agent, $logger);
        } elseif (preg_match('/((linux|android).*version.*safari)/i', $agent)) {
            $browser = new Android($agent, $logger);
        } elseif (preg_match('/(phantomjs)/i', $agent)) {
            $browser = new PhantomJs($agent, $logger);
        } elseif (preg_match('/(yahoo! slurp)/i', $agent)) {
            $browser = new YahooSlurp($agent, $logger);
        } elseif (preg_match('/(safari)/i', $agent)) {
            $browser = new Safari($agent, $logger);
        } elseif (preg_match('/(firefox)/i', $agent)) {
            $browser = new Firefox($agent, $logger);
        } elseif (preg_match('/(fastbot crawler)/i', $agent)) {
            $browser = new FastbotCrawler($agent, $logger);
        } else {
            $browser = new UnknownBrowser($agent, $logger);
        }

        $browser->setCache($cache);

        return $browser;
        /**/

        foreach (self::getChain($cache, $logger) as $browser) {
            /** @var \UaMatcher\Browser\BrowserInterface $browser */
            $browser->setUserAgent($agent);

            if ($browser->canHandle()) {
                $browser->setLogger($logger);
                $browser->setCache($cache);

                return $browser;
            }
        }

        $browser = new UnknownBrowser($agent, $logger);
        $browser->setCache($cache);

        return $browser;
    }

    /**
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \UaMatcher\Browser\BrowserInterface[]
     */
    private static function getChain(AdapterInterface $cache = null, LoggerInterface $logger = null)
    {
        static $list = null;

        if (null === $list) {
            if (null === $cache) {
                $list = self::buildBrowserChain($logger);
            } else {
                $success = null;
                $list    = $cache->getItem('BrowserChain', $success);

                if (!$success) {
                    $list = self::buildBrowserChain($logger);

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
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \UaMatcher\Browser\BrowserInterface[]
     */
    private static function buildBrowserChain(LoggerInterface $logger = null)
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
                || 'AbstractBrowser' == $file->getBasename('.php')
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
                $logger->error(new \Exception('an error occured while creating the browser class', 0, $e));

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
