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

class ExcelvanFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'kp-703' => 'excelvan kp-703',
        'mt13'   => 'excelvan mt13',
        'mt10b'  => 'excelvan mt10b',
        'm1009b' => 'excelvan m1009b',
        'm1009'  => 'excelvan m1009',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general excelvan device';

    use Factory\DeviceFactoryTrait;
}
