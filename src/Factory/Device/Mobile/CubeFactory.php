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

class CubeFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'i1-3gd'    => 'cube i1-3gd',
        'i15-tcl'   => 'cube i15-tcl',
        'u55gt'     => 'cube u55gt',
        'u51gt-c4b' => 'cube u51gt_c4b',
        'u51gt_c4'  => 'cube u51gt_c4',
        'u51gt-s'   => 'cube u51gt-s',
        'u51gt'     => 'cube u51gt',
        'u30gt 2'   => 'cube u30gt2',
        'u30gt'     => 'cube u30gt',
        'u25gt-c4w' => 'cube u25gt-c4w',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general cube device';

    use Factory\DeviceFactoryTrait;
}
