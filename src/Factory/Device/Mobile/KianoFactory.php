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

class KianoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'intelect7'        => 'kiano intelect 7 3g',
        'elegance 10.1 3g' => 'kiano elegance 10.1 3g',
        'elegance 8 3g'    => 'kiano elegance 8 3g',
        'elegance_5_0'     => 'kiano elegance 5.0 3g',
        'elegance'         => 'kiano elegance',
        'slimtab7_3gr'     => 'kiano slimtab 7 3gr',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general kiano device';

    use Factory\DeviceFactoryTrait;
}
