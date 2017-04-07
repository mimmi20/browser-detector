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
class MedionFactory implements Factory\FactoryInterface
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
        if ($s->contains('medion e5001', false)) {
            return $this->loader->load('life e5001', $useragent);
        }

        if ($s->contains('medion e4502', false)) {
            return $this->loader->load('life e4502', $useragent);
        }

        if ($s->contains('medion e4504', false)) {
            return $this->loader->load('life e4504', $useragent);
        }

        if ($s->contains('medion e4503', false)) {
            return $this->loader->load('life e4503', $useragent);
        }

        if ($s->contains('medion e4506', false)) {
            return $this->loader->load('life e4506', $useragent);
        }

        if ($s->contains('medion e4005', false)) {
            return $this->loader->load('life e4005', $useragent);
        }

        if ($s->contains('x5020', false)) {
            return $this->loader->load('life x5020', $useragent);
        }

        if ($s->contains('x5004', false)) {
            return $this->loader->load('x5004', $useragent);
        }

        if ($s->contains('x4701', false)) {
            return $this->loader->load('x4701', $useragent);
        }

        if ($s->contains('p5001', false)) {
            return $this->loader->load('life p5001', $useragent);
        }

        if ($s->contains('p5004', false)) {
            return $this->loader->load('life p5004', $useragent);
        }

        if ($s->contains('p5005', false)) {
            return $this->loader->load('life p5005', $useragent);
        }

        if ($s->contains('s5004', false)) {
            return $this->loader->load('life s5004', $useragent);
        }

        if ($s->contains('LIFETAB_P1034X', false)) {
            return $this->loader->load('lifetab p1034x', $useragent);
        }

        if ($s->contains('LIFETAB_P733X', false)) {
            return $this->loader->load('lifetab p733x', $useragent);
        }

        if ($s->contains('LIFETAB_S9714', false)) {
            return $this->loader->load('lifetab s9714', $useragent);
        }

        if ($s->contains('LIFETAB_S9512', false)) {
            return $this->loader->load('lifetab s9512', $useragent);
        }

        if ($s->contains('LIFETAB_S1036X', false)) {
            return $this->loader->load('lifetab s1036x', $useragent);
        }

        if ($s->contains('LIFETAB_S1034X', false)) {
            return $this->loader->load('lifetab s1034x', $useragent);
        }

        if ($s->contains('LIFETAB_S1033X', false)) {
            return $this->loader->load('lifetab s1033x', $useragent);
        }

        if ($s->contains('LIFETAB_S831X', false)) {
            return $this->loader->load('lifetab s831x', $useragent);
        }

        if ($s->contains('LIFETAB_S785X', false)) {
            return $this->loader->load('lifetab s785x', $useragent);
        }

        if ($s->contains('LIFETAB_S732X', false)) {
            return $this->loader->load('lifetab s732x', $useragent);
        }

        if ($s->contains('LIFETAB_P9516', false)) {
            return $this->loader->load('lifetab p9516', $useragent);
        }

        if ($s->contains('LIFETAB_P9514', false)) {
            return $this->loader->load('lifetab p9514', $useragent);
        }

        if ($s->contains('LIFETAB_P891X', false)) {
            return $this->loader->load('lifetab p891x', $useragent);
        }

        if ($s->contains('LIFETAB_P831X.2', false)) {
            return $this->loader->load('lifetab p831x.2', $useragent);
        }

        if ($s->contains('LIFETAB_P831X', false)) {
            return $this->loader->load('lifetab p831x', $useragent);
        }

        if ($s->contains('LIFETAB_E10320', false)) {
            return $this->loader->load('lifetab e10320', $useragent);
        }

        if ($s->contains('LIFETAB_E10316', false)) {
            return $this->loader->load('lifetab e10316', $useragent);
        }

        if ($s->contains('LIFETAB_E10312', false)) {
            return $this->loader->load('lifetab e10312', $useragent);
        }

        if ($s->contains('LIFETAB_E10310', false)) {
            return $this->loader->load('lifetab e10310', $useragent);
        }

        if ($s->contains('LIFETAB_E7316', false)) {
            return $this->loader->load('lifetab e7316', $useragent);
        }

        if ($s->contains('LIFETAB_E7313', false)) {
            return $this->loader->load('lifetab e7313', $useragent);
        }

        if ($s->contains('LIFETAB_E7312', false)) {
            return $this->loader->load('lifetab e7312', $useragent);
        }

        if ($s->contains('LIFETAB_E733X', false)) {
            return $this->loader->load('lifetab e733x', $useragent);
        }

        if ($s->contains('LIFETAB_E723X', false)) {
            return $this->loader->load('lifetab e723x', $useragent);
        }

        if ($s->contains('p4501', false)) {
            return $this->loader->load('md 98428', $useragent);
        }

        if ($s->contains('p4502', false)) {
            return $this->loader->load('life p4502', $useragent);
        }

        if ($s->contains('LIFE P4310', false)) {
            return $this->loader->load('life p4310', $useragent);
        }

        if ($s->contains('p4013', false)) {
            return $this->loader->load('life p4013', $useragent);
        }

        if ($s->contains('LIFE P4012', false)) {
            return $this->loader->load('lifetab p4012', $useragent);
        }

        if ($s->contains('LIFE E3501', false)) {
            return $this->loader->load('life e3501', $useragent);
        }

        return $this->loader->load('general medion device', $useragent);
    }
}
