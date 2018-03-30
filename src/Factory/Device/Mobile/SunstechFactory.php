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

class SunstechFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tab917qc-8gb' => 'sunstech tab917qc 8gb',
        'tab785dual'   => 'sunstech tab785 dual',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general sunstech device';

    use Factory\DeviceFactoryTrait;
}
