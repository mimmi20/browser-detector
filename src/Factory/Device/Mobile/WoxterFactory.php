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

class WoxterFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'nimbus 80qb' => 'woxter nimbus 80 qb',
        'qx103'       => 'woxter qx 103',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general woxter device';

    use Factory\DeviceFactoryTrait;
}
