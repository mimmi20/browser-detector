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
     * @var array
     */
    private $devices = [
        'e481' => 'micromax e481',
        'q327' => 'micromax q327',
        'a96'  => 'micromax a96',
        'e455' => 'micromax e455',
        'a177' => 'micromax a177',
        'a120' => 'a120',
        'a116' => 'a116',
        'a114' => 'a114',
        'a107' => 'micromax a107',
        'a101' => 'micromax a101',
        'a093' => 'a093',
        'a065' => 'a065',
        'a99'  => 'micromax a99',
        'a59'  => 'a59',
        'a40'  => 'a40',
        'a35'  => 'a35',
        'a27'  => 'a27',
        'x650' => 'x650',
    ];

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
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general micromax device', $useragent);
    }
}
