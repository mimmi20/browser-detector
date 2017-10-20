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
namespace BrowserDetector\Factory\Device\Desktop;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

/**
 * @author Thomas Müller <mimmi20@live.de>
 */
class WindowsFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        // 'masb' => '', // Microsoft System Builder -> no device
        // 'mapb' => '',
        // 'manm' => '',
        // 'dadk' => '',
        'mddr'   => 'dell pc',
        'mddc'   => 'dell pc',
        'mdds'   => 'dell pc',
        'mafs'   => 'fujitsu pc',
        'maar'   => 'acer pc',
        'masp'   => 'sony pc',
        'masa'   => 'sony pc',
        'mase'   => 'sony pc',
        'np02'   => 'asus pc',
        'np06'   => 'asus pc',
        'np07'   => 'asus pc',
        'np08'   => 'asus pc',
        'np09'   => 'asus pc',
        'maau'   => 'asus pc',
        'asjb'   => 'asus pc',
        'asu2'   => 'asus pc',
        'masm'   => 'samsung pc',
        'malc'   => 'lenovo pc',
        'maln'   => 'lenovo pc',
        'lcjb'   => 'lenovo pc',
        'len2'   => 'lenovo pc',
        'matm'   => 'toshiba pc',
        'matb'   => 'toshiba pc',
        'matp'   => 'toshiba pc',
        'tnjb'   => 'toshiba pc',
        'tajb'   => 'toshiba pc',
        'mamd'   => 'medion pc',
        'mami'   => 'msi pc',
        'mam3'   => 'msi pc',
        'magw'   => 'gateway pc',
        'cpdtdf' => 'compaq pc',
        'cpntdf' => 'compaq pc',
        'cmntdf' => 'compaq pc',
        'hpcmhp' => 'hp pc',
        'hpntdf' => 'hp pc',
        'hpdtdf' => 'hp pc',
        'h9p'    => 'microsoft surface 3',
        'surfbook w1'    => 'trekstor surfbook w1',
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

        return $this->loader->load('windows desktop', $useragent);
    }
}
