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

class VericoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'km-uqm11a'   => 'verico uqm11a',
        'rp-udm02a'   => 'verico rp-udm02a',
        'rp-udm01a'   => 'verico rp-udm01a',
        'uq785-m1bgv' => 'verico m1bgv',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general verico device';

    use Factory\DeviceFactoryTrait;
}
