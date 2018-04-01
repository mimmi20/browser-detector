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

class PipoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        ' t9 '  => 'pipo t9',
        'p93g'  => 'pipo p9 3g',
        'm9pro' => 'pipo q107',
        'm7t'   => 'pipo m7t',
        'm6pro' => 'pipo q977',
        'i75'   => 'pipo i75',
        'm83g'  => 'pipo m8 3g',
        ' m6 '  => 'pipo m6',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general pipo device';

    use Factory\DeviceFactoryTrait;
}
