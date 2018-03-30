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

class HaseeFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'x50 ts' => 'hasee x50 ts',
        'w50 t2' => 'hasee w50 t2',
        'e50 t1' => 'hasee e50 t1',
        'h45 t3' => 'hasee h45 t3',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general hasee device';

    use Factory\DeviceFactoryTrait;
}
