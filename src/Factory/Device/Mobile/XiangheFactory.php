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
class XiangheFactory implements Factory\FactoryInterface
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
        if ($s->containsAny(['iphone 6c', 'iphone6c'], false)) {
            return $this->loader->load('iphone 6c', $useragent);
        }

        if ($s->containsAny(['iphone 5c', 'iphone5c'], false)) {
            return $this->loader->load('iphone 5c', $useragent);
        }

        if ($s->containsAny(['iphone 5', 'iphone5'], false)) {
            return $this->loader->load('iphone 5', $useragent);
        }

        if ($s->contains('iphone', false)) {
            return $this->loader->load('xianghe iphone', $useragent);
        }

        return $this->loader->load('general xianghe device', $useragent);
    }
}
