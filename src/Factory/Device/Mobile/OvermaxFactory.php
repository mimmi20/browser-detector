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
class OvermaxFactory implements Factory\FactoryInterface
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
        if ($s->contains('SteelCore-B', true)) {
            return $this->loader->load('steelcore', $useragent);
        }

        if ($s->contains('Solution 10II', true)) {
            return $this->loader->load('solution 10 ii 3g', $useragent);
        }

        if ($s->contains('Solution 7III', true)) {
            return $this->loader->load('solution 7 iii', $useragent);
        }

        if ($s->contains('Quattor 10+', true)) {
            return $this->loader->load('quattor 10+', $useragent);
        }

        return $this->loader->load('general overmax device', $useragent);
    }
}
