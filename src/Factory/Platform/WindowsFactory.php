<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Platform;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class WindowsFactory implements Factory\FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Gets the information about the platform by User Agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect($useragent)
    {
        $s = new Stringy($useragent);

        if ($s->containsAny(['Windows NT 10', 'Windows 10'], false)) {
            return $this->loader->load('windows nt 10.0', $useragent);
        }

        if ($s->containsAny(['Windows NT 6.4', 'Windows 6.4'], false)) {
            return $this->loader->load('windows nt 6.4', $useragent);
        }

        if ($s->containsAny(['Windows NT 6.3', 'Windows 6.3', 'Windows 8.1'], false)) {
            return $this->loader->load('windows nt 6.3', $useragent);
        }

        if ($s->containsAny(['Windows NT 6.2', 'Windows 6.2', 'Windows 8'], false)) {
            return $this->loader->load('windows nt 6.2', $useragent);
        }

        if ($s->containsAny(['Windows NT 6.1', 'Windows 6.1', 'Windows 7'], false)) {
            return $this->loader->load('windows nt 6.1', $useragent);
        }

        if ($s->containsAny(['Windows NT 6', 'Windows 6', 'Windows Vista'], false)) {
            return $this->loader->load('windows nt 6.0', $useragent);
        }

        if ($s->contains('Windows 2003', false)) {
            return $this->loader->load('windows 2003', $useragent);
        }

        if ($s->containsAny(['Windows NT 5.3', 'Windows 5.3'], false)) {
            return $this->loader->load('windows nt 5.3', $useragent);
        }

        if ($s->containsAny(['Windows NT 5.2', 'Windows 5.2'], false)) {
            return $this->loader->load('windows nt 5.2', $useragent);
        }

        if ($s->containsAny(['Windows NT 5.1', 'Windows 5.1', 'Windows XP'], false)) {
            return $this->loader->load('windows nt 5.1', $useragent);
        }

        if ($s->containsAny(['Windows NT 5.01', 'Windows 5.01'], false)) {
            return $this->loader->load('windows nt 5.01', $useragent);
        }

        if ($s->containsAny(['Windows NT 5.0', 'Windows 5.0', 'Windows 2000'], false)) {
            return $this->loader->load('windows nt 5.0', $useragent);
        }

        if ($s->containsAny(['win9x/NT 4.90', 'Win 9x 4.90', 'Win 9x4.90', 'Windows ME'], false)) {
            return $this->loader->load('windows me', $useragent);
        }

        if ($s->containsAny(['Win98', 'Windows 98'], false)) {
            return $this->loader->load('windows 98', $useragent);
        }

        if ($s->containsAny(['Win95', 'Windows 95'], false)) {
            return $this->loader->load('windows 95', $useragent);
        }

        if ($s->containsAny(['Windows NT 4.10', 'Windows 4.10'], false)) {
            return $this->loader->load('windows nt 4.10', $useragent);
        }

        if ($s->containsAny(['Windows NT 4.1', 'Windows 4.1'], false)) {
            return $this->loader->load('windows nt 4.1', $useragent);
        }

        if ($s->containsAny(['Windows NT 4.0', 'Windows 4.0'], false)) {
            return $this->loader->load('windows nt 4.0', $useragent);
        }

        if ($s->containsAny(['Windows NT 3.5', 'Windows 3.5'], false)) {
            return $this->loader->load('windows nt 3.5', $useragent);
        }

        if ($s->containsAny(['Windows NT 3.1'], false)) {
            return $this->loader->load('windows nt 3.1', $useragent);
        }

        if ($s->containsAny(['Windows NT'], false)) {
            return $this->loader->load('windows nt', $useragent);
        }

        if ($s->containsAny(['Windows 3.11'], false)) {
            return $this->loader->load('windows 3.11', $useragent);
        }

        if ($s->containsAny(['Windows 3.1'], false)) {
            return $this->loader->load('windows 3.1', $useragent);
        }

        return $this->loader->load('windows', $useragent);
    }
}
