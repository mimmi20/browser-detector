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
class ZteFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'n9132'             => 'zte n9132',
        'v807'              => 'zte v807',
        'orange reyo'       => 'zte reyo',
        'orange hi 4g'      => 'zte hi 4g',
        'bs 451'            => 'zte bs 451',
        'blade vec'         => 'zte blade vec',
        'blade v6'          => 'blade v6',
        'blade l6'          => 'blade l6',
        'blade l5 plus'     => 'blade l5 plus',
        'blade l3'          => 'blade l3',
        'blade l2'          => 'blade l2',
        'n919'              => 'n919',
        'x920'              => 'x920',
        'w713'              => 'w713',
        'z221'              => 'z221',
        'v975'              => 'v975',
        'geek'              => 'v975',
        'v970'              => 'v970',
        'v967s'             => 'v967s',
        'v880'              => 'v880',
        'v829'              => 'v829',
        'v808'              => 'v808',
        'v788d'             => 'zte v788d',
        'kis plus'          => 'zte v788d',
        'v9'                => 'v9',
        'u930hd'            => 'u930hd',
        'smarttab10'        => 'smart tab 10',
        'smarttab7'         => 'smarttab7',
        'vodafone smart 4g' => 'smart 4g',
        'zte skate'         => 'skate',
        'zte-skate'         => 'skate',
        'racerii'           => 'racer ii',
        'racer'             => 'racer',
        'openc'             => 'zte open c',
        'open2'             => 'zte open 2',
        'zteopen'           => 'open',
        'nx501'             => 'nx501',
        'nx402'             => 'nx402',
        'n918st'            => 'n918st',
        ' n600 '            => 'n600',
        'leo q2'            => 'v769m',
        'blade q maxi'      => 'blade q maxi',
        'blade iii'         => 'blade iii',
        'base tab'          => 'base tab',
        'base_lutea_3'      => 'lutea 3',
        'base lutea 2'      => 'lutea 2',
        'blade'             => 'zte blade',
        'base lutea'        => 'zte blade',
        'atlas_w'           => 'atlas w',
        'atlas w'           => 'atlas w',
        'tania'             => 'tania',
        'g-x991-rio-orange' => 'g-x991',
        'beeline pro'       => 'beeline pro',
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

        return $this->loader->load('general zte device', $useragent);
    }
}
