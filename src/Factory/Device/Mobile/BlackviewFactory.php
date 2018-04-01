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

class BlackviewFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'bv8000pro'  => 'blackview bv8000 pro',
        'bv7000 pro' => 'blackview bv7000 pro',
        'bv6000'     => 'blackview bv6000',
        'bv5000'     => 'blackview bv5000',
        'dm550'      => 'blackview dm550',
        'omega_pro'  => 'blackview omega pro',
        'alife p1'   => 'blackview alife p1',
        'crown'      => 'blackview t570',
        ' r6 '       => 'blackview r6',
        ' a8 '       => 'blackview a8',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general blackview device';

    use Factory\DeviceFactoryTrait;
}
