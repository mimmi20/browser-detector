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

class VodafoneFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        '985n'          => 'vodafone 985n',
        'smart 4 max'   => 'vodafone smart 4 max',
        'smart 4 turbo' => 'vodafone smart 4 turbo',
        'vfd 600'       => 'vodafone vfd 600',
        'smart tab 4'   => 'vodafone smart tab 4',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general vodafone device';

    use Factory\DeviceFactoryTrait;
}
