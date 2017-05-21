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
        'ozzy' => 'wiko ozzy',
        'highway signs' => 'wiko highway signs',
        'highway' => 'wiko highway',
        'barry'         => 'wiko barry',
        'wax'         => 'wiko wax',
        'slide2'      => 'slide 2',
        'slide'       => 'wiko slide',
        'jerry'       => 'jerry',
        'bloom'       => 'bloom',
        'rainbow'     => 'rainbow',
        'lenny'       => 'lenny',
        'getaway'     => 'getaway',
        'darkmoon'    => 'darkmoon',
        'darkside'    => 'darkside',
        'cink peax 2' => 'cink peax 2',
        'kite' => 'wiko kite',
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
