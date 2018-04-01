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

class InewFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'one'  => 'inew one',
        'v7a'  => 'inew v7a',
        'v3-e' => 'inew v3-e',
        'v3e'  => 'inew v3-e',
        'v3c'  => 'inew v3c',
        ' v3 ' => 'inew v3',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general inew device';

    use Factory\DeviceFactoryTrait;
}
