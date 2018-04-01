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

class HpFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'slate 21'           => 'hp slate 21',
        'slatebook 10 x2 pc' => 'hp slatebook 10 x2 pc',
        'slate 8 pro'        => 'hp slate 8 pro',
        'slate 7 hd'         => 'hp slate 7 hd',
        '7 plus'             => 'hp slate 7 plus',
        'ipaqhw6900'         => 'hp ipaq 6900',
        'slate 17'           => 'hp slate 17',
        'slate 10 hd'        => 'hp slate 10',
        'slate 6 voice'      => 'hp slate 6 voice',
        'touchpad'           => 'hp touchpad',
        'cm_tenderloin'      => 'hp touchpad',
        'palm-d050'          => 'palm tx',
        'pre/3'              => 'hp pre 3',
        'pre/'               => 'hp pre',
        'pixi/'              => 'palm pixi',
        'p160u'              => 'hp p160u',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general hp device';

    use Factory\DeviceFactoryTrait;
}
