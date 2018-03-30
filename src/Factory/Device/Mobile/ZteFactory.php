<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class ZteFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'b2016'             => 'zte b2016',
        'e8q+'              => 'zte e8q+',
        's8q'               => 'zte s8q',
        's7q'               => 'zte s7q',
        'nx597j'            => 'zte nx597j',
        'nx549j'            => 'zte nx549j',
        'nx541j'            => 'zte nx541j',
        'nx512j'            => 'zte nx512j',
        'nx511j'            => 'zte nx511j',
        'nx501'             => 'zte nx501',
        'nx406e'            => 'zte nx406e',
        'nx402'             => 'zte nx402',
        'grand s flex'      => 'zte grand s flex',
        'a2016'             => 'zte a2016',
        'smart ultra 6'     => 'zte smart ultra 6',
        'a2017g'            => 'zte a2017g',
        'kis3 max'          => 'zte kis3 max',
        'kis ii max'        => 'zte kis ii max',
        'kis plus'          => 'zte v788d',
        'b2017g'            => 'zte b2017g',
        'v807'              => 'zte v807',
        'orange reyo'       => 'zte reyo',
        'orange hi 4g'      => 'zte hi 4g',
        'bs 451'            => 'zte bs 451',
        'blade v580'        => 'zte blade v580',
        'blade v220'        => 'zte blade v220',
        'blade vec 4g'      => 'zte blade vec 4g',
        'blade vec'         => 'zte blade vec',
        'blade v0800'       => 'zte blade v0800',
        'blade v7'          => 'zte blade v7',
        'blade v6'          => 'zte blade v6',
        'blade c341'        => 'zte blade c341',
        'blade a910'        => 'zte blade a910',
        'blade a612'        => 'zte blade a612',
        'blade a520'        => 'zte blade a520',
        'blade a512'        => 'zte blade a512',
        'blade a510'        => 'zte blade a510',
        'blade a460'        => 'zte blade a460',
        'blade a452'        => 'zte blade a452',
        'blade s6 plus'     => 'zte blade s6 plus',
        'blade s6'          => 'zte blade s6',
        'blade l110'        => 'zte blade l110',
        'blade l6'          => 'zte blade l6',
        'blade l5 plus'     => 'zte blade l5 plus',
        'blade l5'          => 'zte blade l5',
        'blade l3'          => 'zte blade l3',
        'blade l2'          => 'zte blade l2',
        'blade q maxi'      => 'zte blade q maxi',
        'blade iii'         => 'zte blade iii',
        'n9132'             => 'zte n9132',
        'n900d'             => 'zte n900d',
        'n919'              => 'zte n919',
        'n918st'            => 'zte n918st',
        'x920'              => 'zte x920',
        'z221'              => 'zte z221',
        'v975'              => 'zte v975',
        'geek'              => 'zte v975',
        'v970'              => 'zte v970',
        'v967s'             => 'zte v967s',
        'v880'              => 'zte v880',
        'v829'              => 'zte v829',
        'v809'              => 'zte v809',
        'v808'              => 'zte v808',
        'v795'              => 'zte v795',
        'v788d'             => 'zte v788d',
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
        ' n600 '            => 'zte n600',
        'leo q2'            => 'zte v769m',
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
        'a310'              => 'zte a310',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general zte device';

    use Factory\DeviceFactoryTrait;
}
