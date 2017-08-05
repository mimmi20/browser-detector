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
        'blade s6'          => 'zte blade s6',
        'b2016'             => 'zte b2016',
        'blade v580'        => 'zte blade v580',
        'e8q+'              => 'zte e8q+',
        's8q'               => 'zte s8q',
        's7q'               => 'zte s7q',
        'nx511j'            => 'zte nx511j',
        'grand s flex'      => 'zte grand s flex',
        'blade l110'        => 'zte blade l110',
        'blade vec 4g'      => 'zte blade vec 4g',
        'nx541j'            => 'zte nx541j',
        'blade a510'        => 'zte blade a510',
        'blade c341'        => 'zte blade c341',
        'blade v7'          => 'zte blade v7',
        'a2016'             => 'zte a2016',
        'smart ultra 6'     => 'zte smart ultra 6',
        'kis3 max'          => 'zte kis3 max',
        'blade v0800'       => 'zte blade v0800',
        'a2017g'            => 'zte a2017g',
        'nx549j'            => 'zte nx549j',
        'kis ii max'        => 'zte kis ii max',
        'nx512j'            => 'zte nx512j',
        'b2017g'            => 'zte b2017g',
        'n9132'             => 'zte n9132',
        'v807'              => 'zte v807',
        'orange reyo'       => 'zte reyo',
        'orange hi 4g'      => 'zte hi 4g',
        'bs 451'            => 'zte bs 451',
        'blade a910'        => 'zte blade a910',
        'blade a452'        => 'zte blade a452',
        'blade vec'         => 'zte blade vec',
        'blade s6 plus'     => 'zte blade s6 plus',
        'blade v6'          => 'zte blade v6',
        'blade l6'          => 'zte blade l6',
        'blade l5 plus'     => 'zte blade l5 plus',
        'blade l5'          => 'zte blade l5',
        'blade l3'          => 'zte blade l3',
        'blade l2'          => 'zte blade l2',
        'n919'              => 'zte n919',
        'x920'              => 'zte x920',
        'z221'              => 'zte z221',
        'v975'              => 'zte v975',
        'geek'              => 'zte v975',
        'v970'              => 'zte v970',
        'v967s'             => 'zte v967s',
        'v880'              => 'zte v880',
        'v829'              => 'zte v829',
        'v808'              => 'zte v808',
        'v788d'             => 'zte v788d',
        'kis plus'          => 'zte v788d',
        'v9'                => 'zte v9',
        'u930hd'            => 'zte u930hd',
        'smarttab10'        => 'zte smart tab 10',
        'smarttab7'         => 'zte smarttab7',
        'vodafone smart 4g' => 'zte smart 4g',
        'zte skate'         => 'zte skate',
        'zte-skate'         => 'zte skate',
        'racerii'           => 'zte racer ii',
        'racer'             => 'zte racer',
        'openc'             => 'zte open c',
        'open2'             => 'zte open 2',
        'zteopen'           => 'zte open',
        'nx501'             => 'zte nx501',
        'nx402'             => 'zte nx402',
        'n918st'            => 'zte n918st',
        ' n600 '            => 'zte n600',
        'leo q2'            => 'zte v769m',
        'blade q maxi'      => 'zte blade q maxi',
        'blade iii'         => 'zte blade iii',
        'base tab'          => 'zte base tab',
        'base_lutea_3'      => 'zte lutea 3',
        'base lutea 2'      => 'zte lutea 2',
        'blade'             => 'zte blade',
        'base lutea'        => 'zte blade',
        'atlas_w'           => 'zte atlas w',
        'atlas w'           => 'zte atlas w',
        'tania'             => 'zte tania',
        'g-x991-rio-orange' => 'zte g-x991',
        'beeline pro'       => 'zte beeline pro',
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
