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
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ToshibaFactory implements Factory\FactoryInterface
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
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect($useragent, Stringy $s = null)
    {
        if ($s->containsAny(['Toshiba/TG01', 'Toshiba-TG01'], true)) {
            return $this->loader->load('tg01', $useragent);
        }

        if ($s->containsAny(['FOLIO_AND_A', 'TOSHIBA_AC_AND_AZ', 'folio100'], false)) {
            return $this->loader->load('folio 100', $useragent);
        }

        if ($s->contains('AT300SE', true)) {
            return $this->loader->load('at300se', $useragent);
        }

        if ($s->contains('AT300', true)) {
            return $this->loader->load('at300', $useragent);
        }

        if ($s->contains('AT200', true)) {
            return $this->loader->load('at200', $useragent);
        }

        if ($s->contains('AT100', true)) {
            return $this->loader->load('at100', $useragent);
        }

        if ($s->contains('AT10-A', true)) {
            return $this->loader->load('at10-a', $useragent);
        }

        return $this->loader->load('general toshiba device', $useragent);
    }
}
