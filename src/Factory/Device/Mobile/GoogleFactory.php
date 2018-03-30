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

class GoogleFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'pixel 2 xl'    => 'google pixel 2 xl',
        'pixel 2'       => 'google pixel 2',
        'pixel c'       => 'google pixel c',
        'pixel xl'      => 'google pixel xl',
        'pixel'         => 'google pixel',
        'gce x86 phone' => 'google compute engine',
        'glass 1'       => 'google glass 1',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general google device';

    use Factory\DeviceFactoryTrait;
}
