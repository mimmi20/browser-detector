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
class RitmixFactory implements Factory\FactoryInterface
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
        if ($s->contains('RMD-1040', true)) {
            return $this->loader->load('rmd-1040', $useragent);
        }

        if ($s->contains('RMD-1028', true)) {
            return $this->loader->load('rmd-1028', $useragent);
        }

        if ($s->contains('RMD-1025', true)) {
            return $this->loader->load('rmd-1025', $useragent);
        }

        if ($s->contains('RMD-757', true)) {
            return $this->loader->load('rmd-757', $useragent);
        }

        if ($s->contains('RMD-753', true)) {
            return $this->loader->load('rmd-753', $useragent);
        }

        return $this->loader->load('general ritmix device', $useragent);
    }
}
