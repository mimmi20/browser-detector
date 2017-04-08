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
class OdysFactory implements Factory\FactoryInterface
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
        if ($s->contains('MAVEN_10_PLUS', true)) {
            return $this->loader->load('maven 10 plus', $useragent);
        }

        if ($s->containsAny(['XELIO10EXTREME', 'Xelio 10 Extreme'], true)) {
            return $this->loader->load('xelio 10 extreme', $useragent);
        }

        if ($s->contains('xtreme', false)) {
            return $this->loader->load('xtreme', $useragent);
        }

        if ($s->contains('XPRESS PRO', true)) {
            return $this->loader->load('xpress pro', $useragent);
        }

        if ($s->contains('xpress', false)) {
            return $this->loader->load('xpress', $useragent);
        }

        if ($s->containsAny(['XENO10', 'XENO 10'], true)) {
            return $this->loader->load('xeno 10', $useragent);
        }

        if ($s->contains('XelioPT2Pro', true)) {
            return $this->loader->load('xelio pt2 pro', $useragent);
        }

        if ($s->containsAny(['Xelio10Pro', 'Xelio 10 Pro'], false)) {
            return $this->loader->load('xelio 10 pro', $useragent);
        }

        if ($s->containsAny(['XELIO7PRO', 'Xelio 7 pro'], true)) {
            return $this->loader->load('xelio 7 pro', $useragent);
        }

        if ($s->contains('xelio', false)) {
            return $this->loader->load('xelio', $useragent);
        }

        if ($s->contains('UNO_X10', true)) {
            return $this->loader->load('uno x10', $useragent);
        }

        if ($s->contains('SPACE10_PLUS_3G', true)) {
            return $this->loader->load('space 10 plus 3g', $useragent);
        }

        if ($s->contains('Space', true)) {
            return $this->loader->load('space', $useragent);
        }

        if ($s->contains('sky plus', false)) {
            return $this->loader->load('sky plus 3g', $useragent);
        }

        if ($s->contains('ODYS-Q', true)) {
            return $this->loader->load('q', $useragent);
        }

        if ($s->contains('noon', false)) {
            return $this->loader->load('noon', $useragent);
        }

        if ($s->contains('ADM816HC', true)) {
            return $this->loader->load('adm816hc', $useragent);
        }

        if ($s->contains('ADM816KC', true)) {
            return $this->loader->load('adm816kc', $useragent);
        }

        if ($s->contains('NEO_QUAD10', true)) {
            return $this->loader->load('neo quad 10', $useragent);
        }

        if ($s->contains('loox plus', false)) {
            return $this->loader->load('loox plus', $useragent);
        }

        if ($s->contains('loox', false)) {
            return $this->loader->load('loox', $useragent);
        }

        if ($s->contains('IEOS_QUAD_10_PRO', true)) {
            return $this->loader->load('ieos quad 10 pro', $useragent);
        }

        if ($s->contains('IEOS_QUAD_W', true)) {
            return $this->loader->load('ieos quad w', $useragent);
        }

        if ($s->contains('IEOS_QUAD', true)) {
            return $this->loader->load('ieos quad', $useragent);
        }

        if ($s->contains('CONNECT7PRO', true)) {
            return $this->loader->load('connect 7 pro', $useragent);
        }

        if ($s->contains('genesis', false)) {
            return $this->loader->load('genesis', $useragent);
        }

        if ($s->contains('evo', false)) {
            return $this->loader->load('evo', $useragent);
        }

        return $this->loader->load('general odys device', $useragent);
    }
}
