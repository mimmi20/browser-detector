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

class MobistelFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'cynus t8' => 'mobistel cynus t8',
        'cynus t6' => 'mobistel cynus t6',
        'cynus t5' => 'mobistel cynus t5',
        'cynus t2' => 'mobistel cynus t2',
        'cynus t1' => 'mobistel cynus t1',
        'cynus_f9' => 'mobistel cynus f9',
        'cynus f6' => 'mobistel cynus f6',
        'cynus f5' => 'mobistel cynus f5',
        'cynus f4' => 'mobistel mt-7521s',
        'cynus f3' => 'mobistel cynus f3',
        'cynus e7' => 'mobistel cynus e7',
        'cynus_e5' => 'mobistel cynus e5',
        'cynus e1' => 'mobistel cynus e1',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general mobistel device';

    use Factory\DeviceFactoryTrait;
}
