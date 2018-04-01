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

class YuFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'yu5510' => 'yu yu5510',
        'ao5510' => 'yu yu5510',
        'yu5010' => 'yu yu5010',
        'yu4711' => 'yu yu4711',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general yu device';

    use Factory\DeviceFactoryTrait;
}
