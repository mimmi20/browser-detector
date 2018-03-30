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

class RossMoorFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'rm-997' => 'ross&moor rm-997',
        'rm-560' => 'ross&moor rm-560',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general ross&moor device';

    use Factory\DeviceFactoryTrait;
}
