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

class TolinoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tab 8.9' => 'tolino tab 8.9',
        'tab 8'   => 'tolino tab 8',
        'tab 7'   => 'tolino tab 7',
        'tolino'  => 'tolino shine',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general tolino device';

    use Factory\DeviceFactoryTrait;
}
