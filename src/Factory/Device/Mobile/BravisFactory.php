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

class BravisFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'np 725 ips 3g' => 'bravis np 725 ips 3g',
        'np101'         => 'bravis np101',
        'nb751'         => 'bravis nb751',
        'nb105'         => 'bravis nb105',
        'nb74'          => 'bravis nb74',
        'np 844'        => 'bravis np844',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general bravis device';

    use Factory\DeviceFactoryTrait;
}
