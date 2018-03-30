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

class IonikFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tp10.1-1500dc' => 'ionik tp10.1-1500dc',
        'tp9.7-1500dc'  => 'ionik tp9.7-1500dc',
        'tp8-1200qc'    => 'ionik tp8-1200qc',
        'tu-1489a'      => 'ionik tu-1489a',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general ionik device';

    use Factory\DeviceFactoryTrait;
}
