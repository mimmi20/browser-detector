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

class OvermaxFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'ov-v10'        => 'overmax ov-v10',
        'steelcore-b'   => 'overmax steelcore',
        'solution 10ii' => 'overmax solution 10 ii 3g',
        'solution 7iii' => 'overmax solution 7 iii',
        'quattor 10+'   => 'overmax quattor 10+',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general overmax device';

    use Factory\DeviceFactoryTrait;
}
