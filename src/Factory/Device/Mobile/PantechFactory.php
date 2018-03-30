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

class PantechFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'p9020'    => 'pantech p9020',
        'p7040'    => 'pantech p7040',
        'p6010'    => 'pantech p6010',
        'p2020'    => 'pantech p2020',
        'im-a900k' => 'pantech im-a900k',
        'im-a850k' => 'pantech im-a850k',
        'im-a830l' => 'pantech im-a830l',
        'pt-gf200' => 'pantech pt-gf200',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general pantech device';

    use Factory\DeviceFactoryTrait;
}
