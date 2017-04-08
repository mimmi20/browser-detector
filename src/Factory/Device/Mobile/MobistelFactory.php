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
class MobistelFactory implements Factory\FactoryInterface
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
        if ($s->contains('cynus t6', false)) {
            return $this->loader->load('cynus t6', $useragent);
        }

        if ($s->contains('cynus t5', false)) {
            return $this->loader->load('cynus t5', $useragent);
        }

        if ($s->contains('cynus t2', false)) {
            return $this->loader->load('cynus t2', $useragent);
        }

        if ($s->contains('cynus t1', false)) {
            return $this->loader->load('cynus t1', $useragent);
        }

        if ($s->contains('cynus f5', false)) {
            return $this->loader->load('cynus f5', $useragent);
        }

        if ($s->contains('cynus f4', false)) {
            return $this->loader->load('mt-7521s', $useragent);
        }

        if ($s->contains('cynus f3', false)) {
            return $this->loader->load('cynus f3', $useragent);
        }

        if ($s->contains('cynus e1', false)) {
            return $this->loader->load('cynus e1', $useragent);
        }

        return $this->loader->load('general mobistel device', $useragent);
    }
}
