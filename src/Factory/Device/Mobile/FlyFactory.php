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
class FlyFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'fs551'     => 'fly fs551',
        'fs511'     => 'fly fs511',
        'fs509'     => 'fly fs509',
        'fs508'     => 'fly fs508',
        'fs506'     => 'fly fs506',
        'fs505'     => 'fly fs505',
        'fs504'     => 'fly fs504',
        'fs502'     => 'fly fs502',
        'fs501'     => 'fly fs501',
        'fs454'     => 'fly fs454',
        'fs452'     => 'fly fs452',
        'fs451'     => 'fly fs451',
        'fs407'     => 'fly fs407',
        'fs406'     => 'fly fs406',
        'fs405'     => 'fly fs405',
        'fs404'     => 'fly fs404',
        'fs403'     => 'fly fs403',
        'fs402'     => 'fly fs402',
        'fs401'     => 'fly fs401',
        'iq4504'    => 'iq4504',
        'iq4502'    => 'iq4502',
        'iq4415'    => 'iq4415',
        'iq4411'    => 'iq4411 quad energie2',
        'phoenix 2' => 'iq4410i',
        'iq4490'    => 'iq4490',
        'iq4410'    => 'iq4410 quad phoenix',
        'iq4409'    => 'iq4409 quad',
        'iq4404'    => 'iq4404',
        'iq4403'    => 'iq4403',
        'iq456'     => 'iq456',
        'iq452'     => 'iq452',
        'iq450'     => 'iq450',
        'iq449'     => 'iq449',
        'iq448'     => 'iq448',
        'iq444'     => 'iq444',
        'iq442'     => 'iq442',
        'iq436i'    => 'iq436i',
        'iq434'     => 'iq434',
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

        return $this->loader->load('general fly device', $useragent);
    }
}
