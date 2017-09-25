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
use BrowserDetector\Loader\ExtendedLoaderInterface;
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
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Gets the information about the platform by User Agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect(string $useragent, Stringy $s)
    {
        if ($s->containsAny(['windows nt 10', 'windows 10'], false)) {
            return $this->loader->load('windows nt 10.0', $useragent);
        }

        if ($s->containsAny(['windows nt 6.4', 'windows 6.4'], false)) {
            return $this->loader->load('windows nt 6.4', $useragent);
        }

        if ($s->contains('windows nt 6.3; arm', false)) {
            return $this->loader->load('windows nt 6.3; arm', $useragent);
        }

        if ($s->containsAny(['windows nt 6.3', 'windows 6.3', 'windows 8.1'], false)) {
            return $this->loader->load('windows nt 6.3', $useragent);
        }

        if ($s->contains('windows nt 6.2; arm', false)) {
            return $this->loader->load('windows nt 6.2; arm', $useragent);
        }

        if ($s->containsAny(['windows nt 6.2', 'windows 6.2', 'windows 8', 'winnt 6.2'], false)) {
            return $this->loader->load('windows nt 6.2', $useragent);
        }

        if ($s->containsAny(['windows nt 6.1', 'windows 6.1', 'windows 7'], false)) {
            return $this->loader->load('windows nt 6.1', $useragent);
        }

        if ($s->containsAny(['windows nt 6.0', 'windows 6.0', 'windows vista'], false)) {
            return $this->loader->load('windows nt 6.0', $useragent);
        }

        if ($s->contains('windows 2003', false)) {
            return $this->loader->load('windows 2003', $useragent);
        }

        if ($s->containsAny(['windows nt 5.3', 'windows 5.3'], false)) {
            return $this->loader->load('windows nt 5.3', $useragent);
        }

        if ($s->containsAny(['windows nt 5.2', 'windows 5.2'], false)) {
            return $this->loader->load('windows nt 5.2', $useragent);
        }

        if ($s->containsAny(['win9x/nt 4.90', 'win 9x 4.90', 'win 9x4.90', 'windows me'], false)) {
            return $this->loader->load('windows me', $useragent);
        }

        if ($s->containsAny(['windows nt 5.1', 'windows 5.1', 'windows xp'], false)) {
            return $this->loader->load('windows nt 5.1', $useragent);
        }

        if ($s->containsAny(['windows nt 5.01', 'windows 5.01'], false)) {
            return $this->loader->load('windows nt 5.01', $useragent);
        }

        if ($s->containsAny(['windows nt 5.0', 'windows nt5.0', 'windows 5.0', 'windows 2000'], false)) {
            return $this->loader->load('windows nt 5.0', $useragent);
        }

        if ($s->containsAny(['win98', 'windows 98'], false)) {
            return $this->loader->load('windows 98', $useragent);
        }

        if ($s->containsAny(['win95', 'windows 95'], false)) {
            return $this->loader->load('windows 95', $useragent);
        }

        if ($s->containsAny(['windows nt 4.10', 'windows 4.10'], false)) {
            return $this->loader->load('windows nt 4.10', $useragent);
        }

        if ($s->containsAny(['windows nt 4.1', 'windows 4.1'], false)) {
            return $this->loader->load('windows nt 4.1', $useragent);
        }

        if ($s->containsAny(['windows nt 4.0', 'windows nt4.0', 'windows 4.0', 'winnt4.0'], false)) {
            return $this->loader->load('windows nt 4.0', $useragent);
        }

        if ($s->containsAny(['windows nt 3.51', 'windows 3.51', 'winnt3.51'], false)) {
            return $this->loader->load('windows nt 3.51', $useragent);
        }

        if ($s->containsAny(['windows nt 3.5', 'windows 3.5', 'winnt3.5'], false)) {
            return $this->loader->load('windows nt 3.5', $useragent);
        }

        if ($s->containsAny(['windows nt 3.1'], false)) {
            return $this->loader->load('windows nt 3.1', $useragent);
        }

        if ($s->containsAny(['windows nt', 'winnt'], false)) {
            return $this->loader->load('windows nt', $useragent);
        }

        if ($s->containsAny(['windows 3.11'], false)) {
            return $this->loader->load('windows 3.11', $useragent);
        }

        if ($s->containsAny(['windows 3.1'], false)) {
            return $this->loader->load('windows 3.1', $useragent);
        }

        return $this->loader->load('windows', $useragent);
    }
}
