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

class TplinkFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'neffos x1 lite' => 'tp-link neffos x1 lite',
        'neffos y5l'     => 'tp-link neffos y5l',
        'neffos c5 max'  => 'tp-link neffos c5 max',
        'neffos c5l'     => 'tp-link neffos c5l',
        'neffos c5'      => 'tp-link neffos c5',
        'tp601a'         => 'tp-link neffos c5l',
        'tp601b'         => 'tp-link neffos c5l',
        'tp601c'         => 'tp-link neffos c5l',
        'tp601e'         => 'tp-link neffos c5l',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general tp-link device';

    use Factory\DeviceFactoryTrait;
}
