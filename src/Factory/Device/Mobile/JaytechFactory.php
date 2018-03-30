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

class JaytechFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tpc-xte10d'  => 'jaytech tpc-xte10d',
        'tpc-x10f1'   => 'jaytech tpc-x10f1',
        'tpc-xte7d'   => 'jaytech tpc-xte7d',
        'tpc-pa10.1m' => 'jaytech pa10.1m',
        'tpc-736'     => 'jaytech tpc-736',
        'tpc-pa9702'  => 'jaytech tpc-pa9702',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general jaytech device';

    use Factory\DeviceFactoryTrait;
}
