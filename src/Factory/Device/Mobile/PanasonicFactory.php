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

class PanasonicFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'eluga_arc_2' => 'panasonic eluga arc 2',
        'eluga a'     => 'panasonic eluga a',
        't50'         => 'panasonic t50',
        'p61'         => 'panasonic p61',
        'p55'         => 'panasonic p55',
        'p31'         => 'panasonic p31',
        'dl1'         => 'panasonic dl1',
        'kx-prxa15'   => 'panasonic kx-prxa15',
        'sv-mv100'    => 'panasonic sv-mv100',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general panasonic device';

    use Factory\DeviceFactoryTrait;
}
