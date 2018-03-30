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

class RitmixFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'rmd-1040' => 'ritmix rmd-1040',
        'rmd-1028' => 'ritmix rmd-1028',
        'rmd-1025' => 'ritmix rmd-1025',
        'rmd-757'  => 'ritmix rmd-757',
        'rmd-753'  => 'ritmix rmd-753',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general ritmix device';

    use Factory\DeviceFactoryTrait;
}
