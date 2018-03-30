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

class IjoyFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'elektra l'    => 'ijoy elektra l',
        'i-call 504'   => 'ijoy i-call 504',
        'i-call 300v2' => 'ijoy i-call 300v2',
        'i-call 300'   => 'ijoy i-call 300',
        'i-call'       => 'ijoy i-call',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general ijoy device';

    use Factory\DeviceFactoryTrait;
}
