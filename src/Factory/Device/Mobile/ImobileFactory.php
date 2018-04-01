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

class ImobileFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'iq 1068'         => 'i-mobile iq 1068',
        'iqx oku'         => 'i-mobile iq x oku',
        'iq x3'           => 'i-mobile iq x3',
        'iq9.1a'          => 'i-mobile iq 9.1a',
        'iq9.1'           => 'i-mobile iq 9.1',
        'iq 6a'           => 'i-mobile iq 6a',
        'iq 5.6a'         => 'i-mobile iq 5.6a',
        'iq 5.6'          => 'i-mobile iq 5.6',
        'iq 5.5'          => 'i-mobile iq 5.5',
        'iq5.1 pro'       => 'i-mobile iq 5.1 pro',
        'iq 5.1a'         => 'i-mobile iq 5.1a',
        'iq 5.1'          => 'i-mobile iq 5.1',
        'iq 3'            => 'i-mobile iq 3',
        'iq1-1'           => 'i-mobile iq 1.1',
        'i-style 217'     => 'i-mobile i-style 217',
        'i-style q2 duo'  => 'i-mobile i-style q2 duo',
        'i-style 8'       => 'i-mobile i-style 8',
        'i-style 7.8 dtv' => 'i-mobile i-style 7.8 dtv',
        'i-style 7.7 dtv' => 'i-mobile i-style 7.7 dtv',
        'i-style 7.2'     => 'i-mobile i-style 7.2',
        'i-style 7.1'     => 'i-mobile i-style 7.1',
        'i-style 4'       => 'i-mobile i-style 4',
        'i-style 2.1a'    => 'i-mobile i-style 2.1a',
        'i-style2.1a'     => 'i-mobile i-style 2.1a',
        'i-style 2.1'     => 'i-mobile i-style 2.1',
        'i-style2.1'      => 'i-mobile i-style 2.1',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general i-mobile device';

    use Factory\DeviceFactoryTrait;
}
