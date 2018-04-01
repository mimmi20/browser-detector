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

class PointOfViewFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tab-p517'        => 'point-of-view tab p517',
        'tab-protab25'    => 'point-of-view protab 25',
        'tab-protab30'    => 'point-of-view protab 3 xxl',
        'tab-protab2xxl'  => 'point-of-view protab 2 xxl',
        'tab-protab2xl'   => 'point-of-view protab 2 xl',
        'tab-protab2-ips' => 'point-of-view protab 2 ips',
        'pi1045'          => 'point-of-view pi1045',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general point-of-view device';

    use Factory\DeviceFactoryTrait;
}
