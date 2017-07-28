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
        '64 xenon'              => 'archos 64 xenon',
        '50e neon'              => 'archos 50e neon',
        '50e helium'            => 'archos 50e helium',
        '45b neon'              => 'archos 45b neon',
        'gamepad2'              => 'archos gamepad2',
        '55 diamond 2 plus'     => 'archos 55 diamond 2 plus',
        '50 cobalt'             => 'archos 50 cobalt',
        'smart home tablet'     => 'archos arc-sh-q11',
        '80b platinum'          => 'archos 80b platinum',
        '50b neon'              => 'archos 50b neon',
        '101 helium'            => 'archos 101 helium',
        '80d xenon'             => 'archos 80d xenon',
        '50d neon'              => 'archos 50d neon',
        '40c tiv2'              => 'archos 40c tiv2',
        '45c helium'            => 'archos 45c helium',
        'a101it'                => 'archos a101it',
        'a80ksc'                => 'archos a80ksc',
        'a70s'                  => 'archos a70s',
        'a70hb'                 => 'archos a70hb',
        'a70h2'                 => 'archos a70 h2',
        'a70cht'                => 'archos a70cht',
        'a70bht'                => 'archos a70bht',
        'a35dm'                 => 'archos a35dm',
        'a7eb'                  => 'archos 70c',
        '101 xs 2'              => 'archos 101 xs 2',
        '121 neon'              => 'archos 121 neon',
        '101d neon'             => 'archos 101d neon',
        '101 neon'              => 'archos 101 neon',
        '101 copper'            => 'archos 101 copper',
        '101g10'                => 'archos 101g10',
        '101g9'                 => 'archos 101 g9',
        '101b'                  => 'archos 101b',
        '97 xenon'              => 'archos 97 xenon',
        '97 titaniumhd'         => 'archos 97 titanium hd',
        '97 neon'               => 'archos 97 neon',
        '97 carbon'             => 'archos 97 carbon',
        '80xsk'                 => 'archos 80xsk',
        '80 xenon'              => 'archos 80 xenon',
        '80g9'                  => 'archos 80 g9',
        '80 cobalt'             => 'archos 80 cobalt',
        '79 xenon'              => 'archos 79 xenon',
        '70 xenon'              => 'archos 70 xenon',
        '70it2'                 => 'archos 70it2',
        '55 platinum'           => 'archos 55 platinum',
        '55 helium'             => 'archos 55 helium',
        '50 neon'               => 'archos 50 neon',
        '53 platinum'           => 'archos 53 platinum',
        '50 titanium'           => 'archos 50 titanium',
        '50c platinum'          => 'archos 50c platinum',
        '50b platinum'          => 'archos 50b platinum',
        '50 platinum'           => 'archos 50 platinum',
        '50 oxygen plus'        => 'archos 50 oxygen plus',
        '50c oxygen'            => 'archos 50c oxygen',
        '45c platinum'          => 'archos 45c platinum',
        '40 cesium'             => 'archos 40 cesium',
        '40b titanium surround' => 'archos 40b titanium surround',
        'archos5'               => 'archos 5',
        'familypad 2'           => 'archos family pad 2',
        'bush windows phone'    => 'bush eluma',
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
