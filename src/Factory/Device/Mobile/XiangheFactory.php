<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class XiangheFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'iphone 6c' => 'xianghe iphone 6c',
        'iphone6c'  => 'xianghe iphone 6c',
        'iphone 5c' => 'xianghe iphone 5c',
        'iphone5c'  => 'xianghe iphone 5c',
        'iphone 5'  => 'xianghe iphone 5',
        'iphone_5'  => 'xianghe iphone 5',
        'iphone5'   => 'xianghe iphone 5',
        'iphone'    => 'xianghe iphone',
    ];

    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
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
    public function detect(string $useragent, Stringy $s): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general xianghe device', $useragent);
    }
}
