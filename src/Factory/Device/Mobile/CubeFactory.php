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
class CubeFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'i15-tcl'   => 'cube i15-tcl',
        'u55gt'     => 'cube u55gt',
        'u51gt-c4b' => 'cube u51gt_c4b',
        'u51gt_c4'  => 'cube u51gt_c4',
        'u51gt-s'   => 'cube u51gt-s',
        'u51gt'     => 'cube u51gt',
        'u30gt 2'   => 'cube u30gt2',
        'u30gt'     => 'cube u30gt',
        'u25gt-c4w' => 'cube u25gt-c4w',
    ];

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
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

        return $this->loader->load('general cube device', $useragent);
    }
}
