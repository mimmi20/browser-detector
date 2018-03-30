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

class InfinixFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'x600-lte' => 'infinix x600 lte',
        'x600'     => 'infinix x600',
        'note 2'   => 'infinix x600',
        'x552'     => 'infinix x552',
        'x551'     => 'infinix x551',
        'x530'     => 'infinix x530',
        'x510'     => 'infinix x510',
        'x507'     => 'infinix x507',
        'x503'     => 'infinix x503',
        'x501'     => 'infinix x501',
        'x450'     => 'infinix x450',
        'x401'     => 'infinix x401',
        'x352'     => 'infinix x352',
        'x351'     => 'infinix x351',
        'buzz'     => 'infinix buzz',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general infinix device';

    use Factory\DeviceFactoryTrait;
}
