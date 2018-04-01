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

class LencoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tab-925'    => 'lenco tab 925',
        'cooltab-70' => 'lenco cooltab-70',
        'lencm900hz' => 'lenco cm900hz',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general lenco device';

    use Factory\DeviceFactoryTrait;
}
