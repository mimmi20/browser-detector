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
class AsusFactory implements Factory\FactoryInterface
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
        if ($s->contains('TF101G', false)) {
            return $this->loader->load('eee pad transformer tf101g', $useragent);
        }

        if ($s->contains('z00ad', false)) {
            return $this->loader->load('z00ad', $useragent);
        }

        if ($s->contains('k00c', false)) {
            return $this->loader->load('k00c', $useragent);
        }

        if ($s->contains('k00f', false)) {
            return $this->loader->load('k00f', $useragent);
        }

        if ($s->contains('k00z', false)) {
            return $this->loader->load('k00z', $useragent);
        }

        if ($s->contains('k01e', false)) {
            return $this->loader->load('k01e', $useragent);
        }

        if ($s->contains('k01a', false)) {
            return $this->loader->load('k01a', $useragent);
        }

        if ($s->contains('k017', false)) {
            return $this->loader->load('k017', $useragent);
        }

        if ($s->contains('K013', false)) {
            return $this->loader->load('k013', $useragent);
        }

        if ($s->contains('K012', false)) {
            return $this->loader->load('k012', $useragent);
        }

        if ($s->containsAny(['K00E', 'ME372CG'], false)) {
            return $this->loader->load('k00e', $useragent);
        }

        if ($s->contains('ME172V', false)) {
            return $this->loader->load('me172v', $useragent);
        }

        if ($s->contains('ME173X', false)) {
            return $this->loader->load('me173x', $useragent);
        }

        if ($s->contains('ME301T', false)) {
            return $this->loader->load('me301t', $useragent);
        }

        if ($s->contains('ME302C', false)) {
            return $this->loader->load('me302c', $useragent);
        }

        if ($s->contains('ME302KL', false)) {
            return $this->loader->load('me302kl', $useragent);
        }

        if ($s->contains('ME371MG', false)) {
            return $this->loader->load('me371mg', $useragent);
        }

        if ($s->contains('P1801-T', false)) {
            return $this->loader->load('p1801-t', $useragent);
        }

        if ($s->contains('T00J', true)) {
            return $this->loader->load('t00j', $useragent);
        }

        if ($s->contains('T00N', true)) {
            return $this->loader->load('t00n', $useragent);
        }

        if ($s->contains('P01Y', true)) {
            return $this->loader->load('p01y', $useragent);
        }

        if ($s->contains('TF101', false)) {
            return $this->loader->load('tf101', $useragent);
        }

        if ($s->contains('TF300TL', false)) {
            return $this->loader->load('tf300tl', $useragent);
        }

        if ($s->contains('TF300TG', false)) {
            return $this->loader->load('tf300tg', $useragent);
        }

        if ($s->contains('TF300T', false)) {
            return $this->loader->load('tf300t', $useragent);
        }

        if ($s->contains('TF700T', false)) {
            return $this->loader->load('tf700t', $useragent);
        }

        if ($s->contains('Slider SL101', false)) {
            return $this->loader->load('sl101', $useragent);
        }

        if ($s->contains('Garmin-Asus A50', false)) {
            return $this->loader->load('a50', $useragent);
        }

        if ($s->contains('Garmin-Asus A10', false)) {
            return $this->loader->load('asus a10', $useragent);
        }

        if ($s->containsAny(['Transformer TF201', 'Transformer Prime'], false)) {
            return $this->loader->load('asus eee pad tf201', $useragent);
        }

        if ($s->contains('padfone t004', false)) {
            return $this->loader->load('padfone t004', $useragent);
        }

        if ($s->contains('padfone 2', false)) {
            return $this->loader->load('a68', $useragent);
        }

        if ($s->contains('padfone', false)) {
            return $this->loader->load('padfone', $useragent);
        }

        if ($s->containsAny(['nexus 7', 'nexus_7', 'nexus7'], false)) {
            return $this->loader->load('nexus 7', $useragent);
        }

        if ($s->contains('asus;galaxy6', false)) {
            return $this->loader->load('galaxy6', $useragent);
        }

        if ($s->contains('eee_701', false)) {
            return $this->loader->load('eee 701', $useragent);
        }

        return $this->loader->load('general asus device', $useragent);
    }
}
