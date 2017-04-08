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
class MicromaxFactory implements Factory\FactoryInterface
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
        if ($s->contains('A120', false)) {
            return $this->loader->load('a120', $useragent);
        }

        if ($s->contains('A116', false)) {
            return $this->loader->load('a116', $useragent);
        }

        if ($s->contains('A114', false)) {
            return $this->loader->load('a114', $useragent);
        }

        if ($s->contains('A101', false)) {
            return $this->loader->load('micromax a101', $useragent);
        }

        if ($s->contains('A093', false)) {
            return $this->loader->load('a093', $useragent);
        }

        if ($s->contains('A065', false)) {
            return $this->loader->load('a065', $useragent);
        }

        if ($s->contains('A59', false)) {
            return $this->loader->load('a59', $useragent);
        }

        if ($s->contains('A40', false)) {
            return $this->loader->load('a40', $useragent);
        }

        if ($s->contains('A35', false)) {
            return $this->loader->load('a35', $useragent);
        }

        if ($s->contains('A27', false)) {
            return $this->loader->load('a27', $useragent);
        }

        if ($s->contains('X650', false)) {
            return $this->loader->load('x650', $useragent);
        }

        return $this->loader->load('general micromax device', $useragent);
    }
}
