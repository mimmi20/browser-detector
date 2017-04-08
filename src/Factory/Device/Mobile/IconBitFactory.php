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
class IconBitFactory implements Factory\FactoryInterface
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
        if ($s->contains('nt-3710s', false)) {
            return $this->loader->load('nt-3710s', $useragent);
        }

        if ($s->contains('nt-3702m', false)) {
            return $this->loader->load('nt-3702m', $useragent);
        }

        if ($s->contains('nt-3601p', false)) {
            return $this->loader->load('nettab pocket 3g', $useragent);
        }

        if ($s->contains('nt-1009t', false)) {
            return $this->loader->load('nt-1009t', $useragent);
        }

        if ($s->contains('nt-1002t', false)) {
            return $this->loader->load('nt-1002t', $useragent);
        }

        if ($s->contains('nt-1001t', false)) {
            return $this->loader->load('nt-1001t', $useragent);
        }

        return $this->loader->load('general iconbit device', $useragent);
    }
}
