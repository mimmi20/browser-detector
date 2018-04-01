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

class SharpFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'shl25'    => 'sharp shl25',
        'tq-gx30i' => 'sharp tq-gx30i',
        'sh-10d'   => 'sharp sh-10d',
        'sh-01f'   => 'sharp sh-01f',
        'sh8128u'  => 'sharp sh8128u',
        'sh7228u'  => 'sharp sh7228u',
        '306sh'    => 'sharp 306sh',
        '304sh'    => 'sharp 304sh',
        'sh80f'    => 'sharp sh80f',
        'sh05c'    => 'sharp sh05c',
        'is05'     => 'sharp is05',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general sharp device';

    use Factory\DeviceFactoryTrait;
}
