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

class ColorflyFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'g708 oc' => 'colorfly g708 oc',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general colorfly device';

    use Factory\DeviceFactoryTrait;
}
