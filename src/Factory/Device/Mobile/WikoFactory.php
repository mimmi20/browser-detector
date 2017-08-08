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
class WikoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'darknight'     => 'wiko darknight',
        'sunset2'       => 'wiko sunset2',
        'sunset'        => 'wiko sunset',
        'plus'          => 'wiko plus',
        'fever'         => 'wiko fever',
        'sunny'         => 'wiko sunny',
        'pulp fab 4g'   => 'wiko pulp fab 4g',
        'pulp fab'      => 'wiko pulp fab',
        'pulp 4g'       => 'wiko pulp 4g',
        'pulp'          => 'wiko pulp',
        'ridge fab 4g'  => 'wiko ridge fab 4g',
        'ridge fab'     => 'wiko ridge fab',
        'l5510'         => 'wiko ridge fab',
        'ozzy'          => 'wiko ozzy',
        'highway star'  => 'wiko highway star',
        'highway signs' => 'wiko highway signs',
        'highway'       => 'wiko highway',
        'barry'         => 'wiko barry',
        'wax'           => 'wiko wax',
        'slide2'        => 'wiko slide 2',
        'slide'         => 'wiko slide',
        'jerry'         => 'wiko jerry',
        'bloom'         => 'wiko bloom',
        'rainbow up'    => 'wiko rainbow up',
        'rainbow jam'   => 'wiko rainbow jam',
        'rainbow 2'     => 'wiko rainbow 2',
        'rainbow'       => 'wiko rainbow',
        'lenny3'        => 'wiko lenny3',
        'lenny'         => 'wiko lenny',
        'getaway'       => 'wiko getaway',
        'darkmoon'      => 'wiko darkmoon',
        'darkside'      => 'wiko darkside',
        'cink slim'     => 'wiko cink slim',
        'cink peax 2'   => 'wiko cink peax 2',
        'kite'          => 'wiko kite',
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

        return $this->loader->load('general wiko device', $useragent);
    }
}
