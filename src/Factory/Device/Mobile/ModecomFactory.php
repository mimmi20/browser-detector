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
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ModecomFactory implements Factory\FactoryInterface
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
        if ($s->contains('FreeTAB 9702 HD X4', true)) {
            return $this->loader->load('freetab 9702 hd x4', $useragent);
        }

        if ($s->contains('FreeTAB 9000 IPS IC', true)) {
            return $this->loader->load('freetab 9000 ips ic', $useragent);
        }

        if ($s->contains('FreeTAB 8001 IPS X2 3G+', true)) {
            return $this->loader->load('freetab 8001 ips x2 3g+', $useragent);
        }

        if ($s->contains('FreeTAB 7800 IPS IC', true)) {
            return $this->loader->load('freetab 7800 ips ic', $useragent);
        }

        if ($s->contains('FreeTAB 7001 HD IC', true)) {
            return $this->loader->load('freetab 7001 hd ic', $useragent);
        }

        if ($s->contains('FreeTAB 1014 IPS X4 3G+', true)) {
            return $this->loader->load('freetab 1014 ips x4 3g+', $useragent);
        }

        if ($s->contains('FreeTAB 1001', true)) {
            return $this->loader->load('freetab 1001', $useragent);
        }

        return $this->loader->load('general modecom device', $useragent);
    }
}
