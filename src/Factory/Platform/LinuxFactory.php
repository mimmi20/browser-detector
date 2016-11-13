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

namespace BrowserDetector\Factory\Platform;

use BrowserDetector\Factory\FactoryInterface;
use BrowserDetector\Helper;
use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;
use BrowserDetector\Loader\LoaderInterface;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class LinuxFactory implements FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
        $this->loader = $loader;
    }

    /**
     * Gets the information about the platform by User Agent
     *
     * @param string $agent
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect($agent)
    {
        $s = new Stringy($agent);

        $platformCode = 'linux';

        if ($s->contains('Debian APT-HTTP')) {
            $platformCode = 'debian';
        } elseif ($s->contains('linux mint', false)) {
            $platformCode = 'linux mint';
        } elseif ($s->contains('kubuntu', false)) {
            $platformCode = 'kubuntu';
        } elseif ($s->contains('ubuntu', false)) {
            $platformCode = 'ubuntu';
        } elseif ($s->contains('fedora', false)) {
            $platformCode = 'fedora linux';
        } elseif ($s->containsAny(['redhat', 'red hat'], false)) {
            $platformCode = 'redhat linux';
        } elseif ($s->contains('kfreebsd', false)) {
            $platformCode = 'debian with freebsd kernel';
        } elseif (preg_match('/(de|rasp)bian/i', $agent)) {
            $platformCode = 'debian';
        } elseif ($s->contains('centos', false)) {
            $platformCode = 'cent os linux';
        } elseif ($s->contains('CrOS')) {
            $platformCode = 'chromeos';
        } elseif ($s->contains('Joli OS')) {
            $platformCode = 'joli os';
        } elseif ($s->contains('mandriva', false)) {
            $platformCode = 'mandriva linux';
        } elseif ($s->contains('suse', false)) {
            $platformCode = 'suse linux';
        } elseif ($s->contains('gentoo', false)) {
            $platformCode = 'gentoo linux';
        } elseif ($s->contains('slackware', false)) {
            $platformCode = 'slackware linux';
        } elseif ($s->contains('ventana', false)) {
            $platformCode = 'ventana linux';
        } elseif ($s->contains('moblin', false)) {
            $platformCode = 'moblin';
        } elseif ($s->contains('Zenwalk GNU')) {
            $platformCode = 'zenwalk gnu linux';
        }

        return $this->loader->load($platformCode, $agent);
    }
}
