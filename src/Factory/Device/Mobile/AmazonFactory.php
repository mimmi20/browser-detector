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
class AmazonFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'kfarwi'      => 'amazon kfarwi',
        'kftt'        => 'kftt',
        'kfthwi'      => 'kfthwi',
        'kfsowi'      => 'kfsowi',
        'kfot'        => 'kfot',
        'kfjwi'       => 'kfjwi',
        'kfjwa'       => 'kfjwa',
        'kfaswi'      => 'kfaswi',
        'kfapwi'      => 'kfapwi',
        'kfapwa'      => 'kfapwa',
        'fire2'       => 'amazon kindle fire 2',
        'sd4930ur'    => 'sd4930ur',
        'kindle fire' => 'd01400',
        'kindle'      => 'kindle',
        'silk'        => 'kindle',
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

        return $this->loader->load('general amazon device', $useragent);
    }
}
