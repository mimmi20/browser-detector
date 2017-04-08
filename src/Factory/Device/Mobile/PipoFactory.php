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
class PipoFactory implements Factory\FactoryInterface
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
        if ($s->contains('p93g', false)) {
            return $this->loader->load('p9 3g', $useragent);
        }

        if ($s->contains('m9pro', false)) {
            return $this->loader->load('q107', $useragent);
        }

        if ($s->contains('m7t', false)) {
            return $this->loader->load('m7t', $useragent);
        }

        if ($s->contains('m6pro', false)) {
            return $this->loader->load('q977', $useragent);
        }

        if ($s->contains('i75', true)) {
            return $this->loader->load('i75', $useragent);
        }

        if ($s->contains('m83g', false)) {
            return $this->loader->load('m8 3g', $useragent);
        }

        if ($s->contains(' M6 ', true)) {
            return $this->loader->load('m6', $useragent);
        }

        return $this->loader->load('general pipo device', $useragent);
    }
}
