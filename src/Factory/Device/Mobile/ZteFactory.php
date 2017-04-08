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
class ZteFactory implements Factory\FactoryInterface
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
        if ($s->contains('blade v6', false)) {
            return $this->loader->load('blade v6', $useragent);
        }

        if ($s->contains('blade l6', false)) {
            return $this->loader->load('blade l6', $useragent);
        }

        if ($s->contains('blade l5 plus', false)) {
            return $this->loader->load('blade l5 plus', $useragent);
        }

        if ($s->contains('blade l3', false)) {
            return $this->loader->load('blade l3', $useragent);
        }

        if ($s->contains('blade l2', false)) {
            return $this->loader->load('blade l2', $useragent);
        }

        if ($s->contains('n919', false)) {
            return $this->loader->load('n919', $useragent);
        }

        if ($s->contains('x920', false)) {
            return $this->loader->load('x920', $useragent);
        }

        if ($s->contains('w713', false)) {
            return $this->loader->load('w713', $useragent);
        }

        if ($s->contains('z221', false)) {
            return $this->loader->load('z221', $useragent);
        }

        if ($s->containsAny(['v975', 'geek'], false)) {
            return $this->loader->load('v975', $useragent);
        }

        if ($s->contains('v970', false)) {
            return $this->loader->load('v970', $useragent);
        }

        if ($s->contains('v967s', false)) {
            return $this->loader->load('v967s', $useragent);
        }

        if ($s->contains('v880', false)) {
            return $this->loader->load('v880', $useragent);
        }

        if ($s->contains('v829', false)) {
            return $this->loader->load('v829', $useragent);
        }

        if ($s->contains('v808', false)) {
            return $this->loader->load('v808', $useragent);
        }

        if ($s->containsAny(['v788d', 'kis plus'], false)) {
            return $this->loader->load('zte v788d', $useragent);
        }

        if ($s->contains('v9', false)) {
            return $this->loader->load('v9', $useragent);
        }

        if ($s->contains('u930hd', false)) {
            return $this->loader->load('u930hd', $useragent);
        }

        if ($s->contains('smarttab10', false)) {
            return $this->loader->load('smart tab 10', $useragent);
        }

        if ($s->contains('smarttab7', false)) {
            return $this->loader->load('smarttab7', $useragent);
        }

        if ($s->contains('vodafone smart 4g', false)) {
            return $this->loader->load('smart 4g', $useragent);
        }

        if ($s->containsAny(['zte skate', 'zte-skate'], false)) {
            return $this->loader->load('skate', $useragent);
        }

        if ($s->contains('racerii', false)) {
            return $this->loader->load('racer ii', $useragent);
        }

        if ($s->contains('racer', false)) {
            return $this->loader->load('racer', $useragent);
        }

        if ($s->contains('zteopen', false)) {
            return $this->loader->load('open', $useragent);
        }

        if ($s->contains('nx501', false)) {
            return $this->loader->load('nx501', $useragent);
        }

        if ($s->contains('nx402', false)) {
            return $this->loader->load('nx402', $useragent);
        }

        if ($s->contains('n918st', false)) {
            return $this->loader->load('n918st', $useragent);
        }

        if ($s->contains(' n600 ', false)) {
            return $this->loader->load('n600', $useragent);
        }

        if ($s->contains('leo q2', false)) {
            return $this->loader->load('v769m', $useragent);
        }

        if ($s->contains('blade q maxi', false)) {
            return $this->loader->load('blade q maxi', $useragent);
        }

        if ($s->contains('blade iii_il', false)) {
            return $this->loader->load('blade iii', $useragent);
        }

        if ($s->contains('base tab', false)) {
            return $this->loader->load('base tab', $useragent);
        }

        if ($s->contains('base_lutea_3', false)) {
            return $this->loader->load('lutea 3', $useragent);
        }

        if ($s->contains('base lutea 2', false)) {
            return $this->loader->load('lutea 2', $useragent);
        }

        if ($s->containsAny(['blade', 'base lutea'], false)) {
            return $this->loader->load('zte blade', $useragent);
        }

        if ($s->contains('atlas_w', false)) {
            return $this->loader->load('atlas w', $useragent);
        }

        if ($s->contains('tania', false)) {
            return $this->loader->load('tania', $useragent);
        }

        if ($s->contains('g-x991-rio-orange', false)) {
            return $this->loader->load('g-x991', $useragent);
        }

        if ($s->contains('beeline pro', false)) {
            return $this->loader->load('beeline pro', $useragent);
        }

        return $this->loader->load('general zte device', $useragent);
    }
}
