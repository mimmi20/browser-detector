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
class BlaupunktFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'atlantis 1010a' => 'blaupunkt atlantis 1010a',
        'atlantis 1001a' => 'blaupunkt atlantis 1001a',
        'discovery 111c' => 'blaupunkt discovery 111c',
        'discovery 102c' => 'blaupunkt discovery 102c',
        'endeavour 101l' => 'blaupunkt endeavour 101l',
        'endeavour_101l' => 'blaupunkt endeavour 101l',
        'end_101g-test'  => 'blaupunkt endeavour 101g',
        'endeavour 1010' => 'blaupunkt endeavour 1010',
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

        return $this->loader->load('general blaupunkt device', $useragent);
    }
}
