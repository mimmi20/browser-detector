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

class AcmeFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tb717-3g' => 'acme tb717-3g',
        'tb1016'   => 'acme tb1016',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general acme device';

    use Factory\DeviceFactoryTrait;
}
