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

class PandigitalFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'sprnova1'                             => 'pandigital supernova',
        'opc1'                                 => 'pandigital novel',
        'sl20_20101210_b_pd_inx7e_eng_6410pop' => 'pandigital novel',
        'pandigital9hr'                        => 'pandigital 9hr',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general pandigital device';

    use Factory\DeviceFactoryTrait;
}
