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

class PhilipsFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'w8510'   => 'philips w8510',
        'w8500'   => 'philips w8500',
        'w3509'   => 'philips w3509',
        'w336'    => 'philips w336',
        'pi3210g' => 'philips pi3210g',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general philips device';

    use Factory\DeviceFactoryTrait;
}
