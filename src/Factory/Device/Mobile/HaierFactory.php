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

class HaierFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'pad g781'   => 'haier pad g781',
        'sy0880'     => 'haier sy0880',
        'l52'        => 'haier l52',
        'hm-n501-fl' => 'haier hm-n501-fl',
        'hm-g303-w'  => 'haier hm-g303-w',
        'g30'        => 'haier g30',
        'w970'       => 'haier w970',
        'w910'       => 'haier w910',
        'w860'       => 'haier w860',
        'w757'       => 'haier w757',
        'w718'       => 'haier w718',
        'w717'       => 'haier w717',
        'w716'       => 'haier w716',
        'hw-n86w'    => 'haier n86w',
        'ht-i600'    => 'haier ht-i600',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general haier device';

    use Factory\DeviceFactoryTrait;
}
