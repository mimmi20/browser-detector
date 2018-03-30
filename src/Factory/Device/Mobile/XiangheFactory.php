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

class XiangheFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'iphone 6c' => 'xianghe iphone 6c',
        'iphone6c'  => 'xianghe iphone 6c',
        'iphone 5c' => 'xianghe iphone 5c',
        'iphone5c'  => 'xianghe iphone 5c',
        'iphone 5'  => 'xianghe iphone 5',
        'iphone_5'  => 'xianghe iphone 5',
        'iphone5'   => 'xianghe iphone 5',
        'iphone'    => 'xianghe iphone',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general xianghe device';

    use Factory\DeviceFactoryTrait;
}
