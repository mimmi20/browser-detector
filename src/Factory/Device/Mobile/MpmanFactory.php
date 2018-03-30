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

class MpmanFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'mpqc1040i' => 'mpman mpqc1040i',
        'mpqc1030'  => 'mpman mpqc1030',
        'mpqc1010'  => 'mpman mpqc1010',
        'mpqc730'   => 'mpman mpqc730',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general mpman device';

    use Factory\DeviceFactoryTrait;
}
