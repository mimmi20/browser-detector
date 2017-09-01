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
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AppleFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'ipod7,1'   => 'apple ipod touch version 6',
        'ipod5,1'   => 'apple ipod touch version 5',
        'ipod5c1'   => 'apple ipod touch version 5',
        'ipod4,1'   => 'apple ipod touch version 4',
        'ipod3,1'   => 'apple ipod touch version 3',
        'ipod2,1'   => 'apple ipod touch version 2',
        'ipod1,1'   => 'apple ipod touch version 1',
        'ipod'      => 'apple ipod touch',
        'ipad6,8'   => 'apple ipad pro version 1',
        'ipad6,7'   => 'apple ipad pro version 1',
        'ipad6,4'   => 'apple ipad pro 9.7 version 1',
        'ipad6,3'   => 'apple ipad pro 9.7 version 1',
        'ipad5,4'   => 'apple ipad air version 2',
        'ipad5,3'   => 'apple ipad air version 2',
        'ipad5,2'   => 'apple ipad mini version 4',
        'ipad5,1'   => 'apple ipad mini version 4',
        'ipad4,9'   => 'apple ipad mini version 3',
        'ipad4,8'   => 'apple ipad mini version 3',
        'ipad4,7'   => 'apple ipad mini version 3',
        'ipad4,6'   => 'apple ipad mini version 2',
        'ipad4,5'   => 'apple ipad mini version 2',
        'ipad4,4'   => 'apple ipad mini version 2',
        'ipad4,3'   => 'apple ipad air version 1',
        'ipad4,2'   => 'apple ipad air version 1',
        'ipad4,1'   => 'apple ipad air version 1',
        'ipad3,6'   => 'apple ipad version 4',
        'ipad3,5'   => 'apple ipad version 4',
        'ipad3,4'   => 'apple ipad version 4',
        'ipad3,3'   => 'apple ipad version 3',
        'ipad3,2'   => 'apple ipad version 3',
        'ipad3,1'   => 'apple ipad version 3',
        'ipad2,7'   => 'apple ipad mini version 1',
        'ipad2,6'   => 'apple ipad mini version 1',
        'ipad2,5'   => 'apple ipad mini version 1',
        'ipad2,4'   => 'apple ipad version 2',
        'ipad2,3'   => 'apple ipad version 2',
        'ipad2,2'   => 'apple ipad version 2',
        'ipad2,1'   => 'apple ipad version 2',
        'ipad1,1'   => 'apple ipad version 1',
        'ipad'      => 'apple ipad',
        'iphone9,4' => 'apple iphone 9,4',
        'iphone9,3' => 'apple iphone 9,3',
        'iphone8,4' => 'apple iphone se',
        'iph8,4'    => 'apple iphone se',
        'iphone8,2' => 'apple iphone 6s plus',
        'iphone8_2' => 'apple iphone 6s plus',
        'iph8,2'    => 'apple iphone 6s plus',
        'iphone8,1' => 'apple iphone 6s',
        'iphone8_1' => 'apple iphone 6s',
        'iph8,1'    => 'apple iphone 6s',
        'iphone7,2' => 'apple iphone 6',
        'iph7,2'    => 'apple iphone 6',
        'iphone 6'  => 'apple iphone 6',
        'iphone7,1' => 'apple iphone 6 plus',
        'iph7,1'    => 'apple iphone 6 plus',
        'iphone6,2' => 'apple iphone 5s',
        'iphone6_2' => 'apple iphone 5s',
        'iph6,2'    => 'apple iphone 5s',
        'iphone6,1' => 'apple iphone 5s',
        'iph6,1'    => 'apple iphone 5s',
        'iphone5,4' => 'apple iphone 5c',
        'iph5,4'    => 'apple iphone 5c',
        'iphone5,3' => 'apple iphone 5c',
        'iph5,3'    => 'apple iphone 5c',
        'iphone5,2' => 'apple iphone 5',
        'iph5,2'    => 'apple iphone 5',
        'iphone5,1' => 'apple iphone 5',
        'iph5,1'    => 'apple iphone 5',
        'iphone4,1' => 'apple iphone 4s',
        'iph4,1'    => 'apple iphone 4s',
        'iphone3,3' => 'apple iphone 4',
        'iph3,3'    => 'apple iphone 4',
        'iphone3,2' => 'apple iphone 4',
        'iph3,2'    => 'apple iphone 4',
        'iphone3,1' => 'apple iphone 4',
        'iph3,1'    => 'apple iphone 4',
        'iphone2,1' => 'apple iphone 3gs',
        'iphone1,2' => 'apple iphone 3g',
        'iphone1,1' => 'apple iphone 2g',
        'iph'       => 'apple iphone',
    ];

    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface|null
     */
    private $loader = null;

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
    public function detect(string $useragent, Stringy $s = null): array
    {
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
