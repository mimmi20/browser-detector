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

class SagemFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'my511x'  => 'sagem my511x',
        'my411x'  => 'sagem my411x',
        'my411c'  => 'sagem my411c',
        'myc5-2v' => 'sagem myC5-2v',
        'myv-55'  => 'sagem myv-55',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general sagem device';

    use Factory\DeviceFactoryTrait;
}
