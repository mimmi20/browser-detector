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
class DigmaFactory implements Factory\FactoryInterface
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
        if ($s->contains('PS1043MG', true)) {
            return $this->loader->load('ps1043mg', $useragent);
        }

        if ($s->contains('TT7026MW', true)) {
            return $this->loader->load('tt7026mw', $useragent);
        }

        if ($s->contains('iDxD7', true)) {
            return $this->loader->load('idxd7 3g', $useragent);
        }

        if ($s->contains('iDxD4', true)) {
            return $this->loader->load('idxd4 3g', $useragent);
        }

        if ($s->contains('iDsD7', true)) {
            return $this->loader->load('idsd7 3g', $useragent);
        }

        if ($s->contains('iDnD7', true)) {
            return $this->loader->load('idnd7', $useragent);
        }

        if ($s->contains('iDjD7', true)) {
            return $this->loader->load('idjd7', $useragent);
        }

        if ($s->contains('iDrQ10', true)) {
            return $this->loader->load('idrq10 3g', $useragent);
        }

        return $this->loader->load('general digma device', $useragent);
    }
}
