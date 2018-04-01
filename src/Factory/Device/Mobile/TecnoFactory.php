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

class TecnoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'w4'      => 'tecno w4',
        'l8'      => 'tecno l8',
        'g9'      => 'tecno g9',
        'p9'      => 'tecno p9',
        'h6'      => 'tecno h6',
        ' m7'     => 'tecno m7',
        ' h7'     => 'tecno h7',
        ' f7'     => 'tecno f7',
        ' f5 '    => 'tecno f5',
        ' d5 '    => 'tecno d5',
        ' m5'     => 'tecno m5',
        '-j5'     => 'tecno j5',
        '_m5'     => 'tecno m5',
        'p5_plus' => 'tecno p5 plus',
        ' p5'     => 'tecno p5',
        '_p5'     => 'tecno p5',
        ' d3'     => 'tecno d3',
        '_d3'     => 'tecno d3',
        ' m3'     => 'tecno m3',
        '_m3'     => 'tecno m3',
        ' s3'     => 'tecno s3',
        '_s3'     => 'tecno s3',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general tecno device';

    use Factory\DeviceFactoryTrait;
}
