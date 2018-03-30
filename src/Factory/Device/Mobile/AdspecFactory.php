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

class AdspecFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'adtab 7 lite' => 'adspec adtab 7 lite',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general adspec device';

    use Factory\DeviceFactoryTrait;
}
