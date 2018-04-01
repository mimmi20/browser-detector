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

class KyoceraFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'e6560'   => 'kyocera e6560',
        'c6750'   => 'kyocera c6750',
        'c6742'   => 'kyocera c6742',
        'c6730'   => 'kyocera c6730',
        'c6522n'  => 'kyocera c6522n',
        'c5215'   => 'kyocera c5215',
        'c5170'   => 'kyocera c5170',
        'c5155'   => 'kyocera c5155',
        'c5120'   => 'kyocera c5120',
        'kc-s701' => 'kyocera kc-s701',
        'dm015k'  => 'kyocera dm015k',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general kyocera device';

    use Factory\DeviceFactoryTrait;
}
