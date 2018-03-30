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

class XoroFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'telepad 9a1' => 'xoro xor400250',
        'pad1851'     => 'xoro pad 1851',
        'telepad830'  => 'xoro telepad 830',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general xoro device';

    use Factory\DeviceFactoryTrait;
}
