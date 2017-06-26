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
class ArchosFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        '45c helium'            => 'archos 45c helium',
        'a101it'                => 'a101it',
        'a80ksc'                => 'a80ksc',
        'a70s'                  => 'a70s',
        'a70hb'                 => 'a70hb',
        'a70h2'                 => 'a70 h2',
        'a70cht'                => 'a70cht',
        'a70bht'                => 'a70bht',
        'a35dm'                 => 'a35dm',
        'a7eb'                  => '70c',
        '101 xs 2'              => '101 xs 2',
        '121 neon'              => '121 neon',
        '101d neon'             => '101d neon',
        '101 neon'              => '101 neon',
        '101 copper'            => '101 copper',
        '101g10'                => '101g10',
        '101g9'                 => '101 g9',
        '101b'                  => '101b',
        '97 xenon'              => '97 xenon',
        '97 titaniumhd'         => '97 titanium hd',
        '97 neon'               => '97 neon',
        '97 carbon'             => '97 carbon',
        '80xsk'                 => '80xsk',
        '80 xenon'              => '80 xenon',
        '80g9'                  => '80 g9',
        '80 cobalt'             => '80 cobalt',
        '79 xenon'              => '79 xenon',
        '70 xenon'              => '70 xenon',
        '70it2'                 => '70it2',
        '55 platinum'           => 'archos 55 platinum',
        '55 helium'             => 'archos 55 helium',
        '50 neon'               => 'archos 50 neon',
        '53 platinum'           => '53 platinum',
        '50 titanium'           => '50 titanium',
        '50c platinum'          => 'archos 50c platinum',
        '50b platinum'          => '50b platinum',
        '50 platinum'           => '50 platinum',
        '50 oxygen plus'        => '50 oxygen plus',
        '50c oxygen'            => '50c oxygen',
        '45c platinum'          => 'archos 45c platinum',
        '40 cesium'             => '40 cesium',
        '40b titanium surround' => '40b titanium surround',
        'archos5'               => '5',
        'familypad 2'           => 'family pad 2',
        'bush windows phone'    => 'eluma',
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

        return $this->loader->load('general archos device', $useragent);
    }
}
