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

class SupraFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'm74cg' => 'supra m74cg',
        'm723g' => 'supra m723g',
        'm121g' => 'supra m121g',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general supra device';

    use Factory\DeviceFactoryTrait;
}
