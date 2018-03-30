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

class WileyfoxFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'storm'        => 'wileyfox storm',
        'spark +'      => 'wileyfox spark +',
        'swift 2 plus' => 'wileyfox swift 2 plus',
        'swift 2'      => 'wileyfox swift 2',
        'swift'        => 'wileyfox swift',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general wileyfox device';

    use Factory\DeviceFactoryTrait;
}
