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

class WortmannFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'terra pad 1004' => 'wortmann terra pad 1004',
        'terra pad 1003' => 'wortmann terra pad 1003',
        'pad1002'        => 'wortmann terra pad 1002',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general wortmann device';

    use Factory\DeviceFactoryTrait;
}
