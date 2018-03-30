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

class FreetelFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'ftj162d' => 'freetel ftj162d',
        'ftj161b' => 'freetel ftj161b',
        'ftj152d' => 'freetel ftj152d',
        'ftj152c' => 'freetel ftj152c',
        'ftj152b' => 'freetel ftj152b',
        'ftj152a' => 'freetel ftj152a',
        'ft142d'  => 'freetel ft142d',
        'ft142a'  => 'freetel ft142a',
        'ft142'   => 'freetel ft142',
        'ft141b'  => 'freetel ft141b',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general freetel device';

    use Factory\DeviceFactoryTrait;
}
