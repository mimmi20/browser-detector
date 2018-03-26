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

class KtouchFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'w688'    => 'k-touch w688',
        'w658'    => 'k-touch w658',
        'w619'    => 'k-touch w619',
        'w98'     => 'k-touch w98',
        'tou ch3' => 'k-touch tou ch3',
        'u86'     => 'k-touch u86',
        't780'    => 'k-touch t780',
        't621'    => 'k-touch t621',
        't619+'   => 'k-touch t619+',
        't60'     => 'k-touch t60',
        's757'    => 'k-touch s757',
        'e806'    => 'k-touch e806',
        'e780'    => 'k-touch e780',
        'e619'    => 'k-touch e619',
        't96'     => 'k-touch t96',
        'a930'    => 'k-touch tianyu a930',
        'a11'     => 'k-touch a11',
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

        return $this->loader->load('general ktouch device', $useragent);
    }
}
