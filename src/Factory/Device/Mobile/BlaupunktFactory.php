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

class BlaupunktFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'atlantis 1010a' => 'blaupunkt atlantis 1010a',
        'atlantis 1001a' => 'blaupunkt atlantis 1001a',
        'discovery 111c' => 'blaupunkt discovery 111c',
        'discovery 102c' => 'blaupunkt discovery 102c',
        'endeavour 101l' => 'blaupunkt endeavour 101l',
        'endeavour_101l' => 'blaupunkt endeavour 101l',
        'end_101g-test'  => 'blaupunkt endeavour 101g',
        'endeavour 1010' => 'blaupunkt endeavour 1010',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general blaupunkt device';

    use Factory\DeviceFactoryTrait;
}
