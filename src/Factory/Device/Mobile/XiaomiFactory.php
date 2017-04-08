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
class XiaomiFactory implements Factory\FactoryInterface
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
        if ($s->contains('MI MAX', true)) {
            return $this->loader->load('mi max', $useragent);
        }

        if ($s->contains('MI 4W', true)) {
            return $this->loader->load('mi 4w', $useragent);
        }

        if ($s->contains('MI 4LTE', true)) {
            return $this->loader->load('mi 4 lte', $useragent);
        }

        if ($s->contains('MI 3W', true)) {
            return $this->loader->load('mi 3w', $useragent);
        }

        if ($s->containsAny(['MI PAD', 'MiPad'], true)) {
            return $this->loader->load('mi pad', $useragent);
        }

        if ($s->contains('MI 2A', true)) {
            return $this->loader->load('mi 2a', $useragent);
        }

        if ($s->contains('MI 2S', true)) {
            return $this->loader->load('mi 2s', $useragent);
        }

        if ($s->contains('MI 2', true)) {
            return $this->loader->load('mi 2', $useragent);
        }

        if ($s->contains('Redmi 3S', true)) {
            return $this->loader->load('redmi 3s', $useragent);
        }

        if ($s->contains('Redmi 3', true)) {
            return $this->loader->load('redmi 3', $useragent);
        }

        if ($s->contains('Redmi_Note_3', true)) {
            return $this->loader->load('redmi note 3', $useragent);
        }

        if ($s->contains('Redmi Note 2', true)) {
            return $this->loader->load('redmi note 2', $useragent);
        }

        if ($s->contains('HM NOTE 1W', true)) {
            return $this->loader->load('hm note 1w', $useragent);
        }

        if ($s->contains('HM NOTE 1S', true)) {
            return $this->loader->load('hm note 1s', $useragent);
        }

        if ($s->contains('HM NOTE 1LTETD', true)) {
            return $this->loader->load('hm note 1lte td', $useragent);
        }

        if ($s->contains('HM NOTE 1LTE', true)) {
            return $this->loader->load('hm note 1lte', $useragent);
        }

        if ($s->contains('HM_1SW', true)) {
            return $this->loader->load('hm 1sw', $useragent);
        }

        if ($s->contains('HM 1SC', true)) {
            return $this->loader->load('hm 1sc', $useragent);
        }

        return $this->loader->load('general xiaomi device', $useragent);
    }
}
