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

class SymphonyFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'h150' => 'symphony h150',
        'i10'  => 'symphony i10',
        'w82'  => 'symphony w82',
        'l102' => 'symphony l102',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general symphony device';

    use Factory\DeviceFactoryTrait;
}
