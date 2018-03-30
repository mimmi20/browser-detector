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

class ModecomFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'freetab 9702 hd x4'      => 'modecom freetab 9702 hd x4',
        'freetab 9702 ips x2'     => 'modecom freetab 9702 ips x2',
        'freetab 9000 ips ic'     => 'modecom freetab 9000 ips ic',
        'freetab 8001 ips x2 3g+' => 'modecom freetab 8001 ips x2 3g+',
        'freetab 7800 ips ic'     => 'modecom freetab 7800 ips ic',
        'freetab 7001 hd ic'      => 'modecom freetab 7001 hd ic',
        'freetab 1014 ips x4 3g+' => 'modecom freetab 1014 ips x4 3g+',
        'freetab 1001'            => 'modecom freetab 1001',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general modecom device';

    use Factory\DeviceFactoryTrait;
}
