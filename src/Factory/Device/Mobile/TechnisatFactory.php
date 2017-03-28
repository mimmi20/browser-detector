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
class TechnisatFactory implements Factory\FactoryInterface
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
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect($useragent, Stringy $s = null)
    {
        if ($s->containsAny(['TechniPad_10-3G', 'TechniPad 10-3G'], true)) {
            return $this->loader->load('technipad 10 3g', $useragent);
        }

        if ($s->containsAny(['TechniPad_10', 'TechniPad 10'], true)) {
            return $this->loader->load('technipad 10', $useragent);
        }

        if ($s->containsAny(['AQIPAD_7G', 'AQIPAD 7G'], true)) {
            return $this->loader->load('aqiston aqipad 7g', $useragent);
        }

        if ($s->containsAny(['TechniPhone_5', 'TechniPhone 5'], true)) {
            return $this->loader->load('techniphone 5', $useragent);
        }

        return $this->loader->load('general technisat device', $useragent);
    }
}
