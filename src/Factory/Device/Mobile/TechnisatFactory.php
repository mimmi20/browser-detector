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

class TechnisatFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'technipad_10-3g' => 'technisat technipad 10 3g',
        'technipad 10-3g' => 'technisat technipad 10 3g',
        'technipad_10'    => 'technisat technipad 10',
        'technipad 10'    => 'technisat technipad 10',
        'aqipad_7g'       => 'technisat aqiston aqipad 7g',
        'aqipad 7g'       => 'technisat aqiston aqipad 7g',
        'techniphone_5'   => 'technisat techniphone 5',
        'techniphone 5'   => 'technisat techniphone 5',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general technisat device';

    use Factory\DeviceFactoryTrait;
}
