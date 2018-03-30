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

class ElephoneFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'p9000' => 'elephone p9000',
        'p8000' => 'elephone p8000',
        'p7000' => 'elephone p7000',
        'p3000' => 'elephone p3000',
        's2'    => 'elephone s2',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general elephone device';

    use Factory\DeviceFactoryTrait;
}
