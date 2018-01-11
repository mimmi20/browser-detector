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

class AmazonFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'kfdowi'              => 'amazon kfdowi',
        'kfauwi'              => 'amazon kfauwi',
        'kfgiwi'              => 'amazon kfgiwi',
        'kftbwi'              => 'amazon kftbwi',
        'kfmewi'              => 'amazon kfmewi',
        'kffowi'              => 'amazon kffowi',
        'kfsawi'              => 'amazon kfsawi',
        'kfsawa'              => 'amazon kfsawa',
        'kfarwi'              => 'amazon kfarwi',
        'kftt'                => 'amazon kftt',
        'kfthwi'              => 'amazon kfthwi',
        'kindle fire hdx 7'   => 'amazon kfthwi',
        'kfthwa'              => 'amazon kfthwa',
        'kfsowi'              => 'amazon kfsowi',
        'kfot'                => 'amazon kfot',
        'kfjwi'               => 'amazon kfjwi',
        'kfjwa'               => 'amazon kfjwa',
        'kfaswi'              => 'amazon kfaswi',
        'kfapwi'              => 'amazon kfapwi',
        'kindle fire hdx 8.9' => 'amazon kfapwi',
        'kfapwa'              => 'amazon kfapwa',
        'fire2'               => 'amazon kindle fire 2',
        'sd4930ur'            => 'amazon sd4930ur',
        'kindle fire'         => 'amazon d01400',
        'kindle'              => 'amazon kindle',
        'silk'                => 'amazon kindle',
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

        return $this->loader->load('general amazon device', $useragent);
    }
}
