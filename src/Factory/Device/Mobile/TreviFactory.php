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

class TreviFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        ' c4 '          => 'trevi c4',
        'phablet 5,3 q' => 'trevi phablet 5,3 q',
        'reverse_5.5q'  => 'trevi reverse 5.5q',
        'phablet 6 s'   => 'trevi phablet 6 s',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general trevi device';

    use Factory\DeviceFactoryTrait;
}
