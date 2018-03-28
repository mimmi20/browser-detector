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

class AppleFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'ipod7,1'    => 'apple ipod 7,1',
        'ipod5,1'    => 'apple ipod 5,1',
        'ipod5c1'    => 'apple ipod 5,1',
        'ipod4,1'    => 'apple ipod 4,1',
        'ipod3,1'    => 'apple ipod 3,1',
        'ipod2,1'    => 'apple ipod 2,1',
        'ipod1,1'    => 'apple ipod 1,1',
        'ipod'       => 'apple ipod touch',
        'ipad7,4'    => 'apple ipad 7,4',
        'ipad7,3'    => 'apple ipad 7,3',
        'ipad7,2'    => 'apple ipad 7,2',
        'ipad7,1'    => 'apple ipad 7,1',
        'ipad6,8'    => 'apple ipad 6,8',
        'ipad6,7'    => 'apple ipad 6,7',
        'ipad6,4'    => 'apple ipad 6,4',
        'ipad6,3'    => 'apple ipad 6,3',
        'ipad5,4'    => 'apple ipad 5,4',
        'ipad5,3'    => 'apple ipad 5,3',
        'ipad5,2'    => 'apple ipad 5,2',
        'ipad5,1'    => 'apple ipad 5,1',
        'ipad4,9'    => 'apple ipad 4,9',
        'ipad4,8'    => 'apple ipad 4,8',
        'ipad4,7'    => 'apple ipad 4,7',
        'ipad4,6'    => 'apple ipad 4,6',
        'ipad4,5'    => 'apple ipad 4,5',
        'ipad4,4'    => 'apple ipad 4,4',
        'ipad4,3'    => 'apple ipad 4,3',
        'ipad4,2'    => 'apple ipad 4,2',
        'ipad4,1'    => 'apple ipad 4,1',
        'ipad3,6'    => 'apple ipad 3,6',
        'ipad3,5'    => 'apple ipad 3,5',
        'ipad3,4'    => 'apple ipad 3,4',
        'ipad3,3'    => 'apple ipad 3,3',
        'ipad3,2'    => 'apple ipad 3,2',
        'ipad3,1'    => 'apple ipad 3,1',
        'ipad2,7'    => 'apple ipad 2,7',
        'ipad2,6'    => 'apple ipad 2,6',
        'ipad2,5'    => 'apple ipad 2,5',
        'ipad2,4'    => 'apple ipad 2,4',
        'ipad2,3'    => 'apple ipad 2,3',
        'ipad2,2'    => 'apple ipad 2,2',
        'ipad2,1'    => 'apple ipad 2,1',
        'ipad1,1'    => 'apple ipad 1,1',
        'ipad'       => 'apple ipad',
        'iphone10,6' => 'apple iphone 10,6',
        'iphone10,5' => 'apple iphone 10,5',
        'iPhone10_5' => 'apple iphone 10,5',
        'iphone10,4' => 'apple iphone 10,4',
        'iphone10,3' => 'apple iphone 10,3',
        'iphone10,2' => 'apple iphone 10,2',
        'iphone10,1' => 'apple iphone 10,1',
        'iphone9,4'  => 'apple iphone 9,4',
        'iphone9,3'  => 'apple iphone 9,3',
        'iphone9,2'  => 'apple iphone 9,2',
        'iphone9,1'  => 'apple iphone 9,1',
        'iphone8,4'  => 'apple iphone 8,4',
        'iph8,4'     => 'apple iphone 8,4',
        'iphone8,2'  => 'apple iphone 8,2',
        'iphone8_2'  => 'apple iphone 8,2',
        'iph8,2'     => 'apple iphone 8,2',
        'iphone8,1'  => 'apple iphone 8,1',
        'iphone8_1'  => 'apple iphone 8,1',
        'iph8,1'     => 'apple iphone 8,1',
        'iphone7,2'  => 'apple iphone 7,2',
        'iPhone7_2'  => 'apple iphone 7,2',
        'iph7,2'     => 'apple iphone 7,2',
        'iphone 6'   => 'apple iphone 7,2',
        'iphone7,1'  => 'apple iphone 7,1',
        'iph7,1'     => 'apple iphone 7,1',
        'iphone6,2'  => 'apple iphone 6,2',
        'iphone6_2'  => 'apple iphone 6,2',
        'iph6,2'     => 'apple iphone 6,2',
        'iphone6,1'  => 'apple iphone 6,1',
        'iph6,1'     => 'apple iphone 6,1',
        'iphone5,4'  => 'apple iphone 5,4',
        'iph5,4'     => 'apple iphone 5,4',
        'iphone5,3'  => 'apple iphone 5,3',
        'iph5,3'     => 'apple iphone 5,3',
        'iphone5,2'  => 'apple iphone 5,2',
        'iph5,2'     => 'apple iphone 5,2',
        'iphone5,1'  => 'apple iphone 5,1',
        'iph5,1'     => 'apple iphone 5,1',
        'iphone4,1'  => 'apple iphone 4,1',
        'iph4,1'     => 'apple iphone 4,1',
        'iphone3,3'  => 'apple iphone 3,3',
        'iph3,3'     => 'apple iphone 3,3',
        'iphone3,2'  => 'apple iphone 3,2',
        'iph3,2'     => 'apple iphone 3,2',
        'iphone3,1'  => 'apple iphone 3,1',
        'iph3,1'     => 'apple iphone 3,1',
        'iphone2,1'  => 'apple iphone 2,1',
        'iphone1,2'  => 'apple iphone 1,2',
        'iphone1,1'  => 'apple iphone 1,1',
        'iph'        => 'apple iphone',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general apple device';

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
        $matches = [];

        if (preg_match('/(iphone|ipad|ipod)(\d+)[,_c](\d)/i', $useragent, $matches)) {
            $key = 'apple ' . mb_strtolower($matches[1]) . ' ' . $matches[2] . ',' . $matches[3];

            if ($this->loader->has($key)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if (preg_match('/iph(\d+),(\d)/i', $useragent, $matches)) {
            $key = 'apple iphone ' . $matches[1] . ',' . $matches[2];

            if ($this->loader->has($key)) {
                return $this->loader->load($key, $useragent);
            }
        }

        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if (preg_match('/Puffin\/[\d\.]+IT/', $useragent)) {
            return $this->loader->load('apple ipad', $useragent);
        }

        if (preg_match('/Puffin\/[\d\.]+IP/', $useragent)) {
            return $this->loader->load('apple iphone', $useragent);
        }

        return $this->loader->load('general apple device', $useragent);
    }
}
