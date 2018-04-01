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

class XoloFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'q1010i'    => 'xolo q1010i',
        'q600s'     => 'xolo q600s',
        'win q1000' => 'xolo win q1000',
        'one'       => 'xolo one',
        'a1000s'    => 'xolo a1000s',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general xolo device';

    use Factory\DeviceFactoryTrait;
}
