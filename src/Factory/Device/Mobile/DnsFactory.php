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

class DnsFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        's5701'   => 'dns s5701',
        's4505m'  => 'dns s4505m',
        's4505'   => 'dns s4505',
        's4503q'  => 'dns s4503q',
        's4502m'  => 'dns s4502m',
        's4502'   => 'dns s4502',
        's4501m'  => 'dns s4501m',
        's4008'   => 'dns s4008',
        'mb40ii1' => 'dns mb40ii1',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general dns device';

    use Factory\DeviceFactoryTrait;
}
