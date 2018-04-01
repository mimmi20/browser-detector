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

class LexandFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'a1002'      => 'lexand a1002',
        'a811'       => 'lexand a811',
        's5a4'       => 'lexand s5a4',
        's4a5'       => 'lexand s4a5',
        's4a4'       => 'lexand s4a4',
        's4a2'       => 'lexand s4a2',
        's4a1'       => 'lexand s4a1',
        'sc7 pro hd' => 'lexand sc7 pro hd',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general lexand device';

    use Factory\DeviceFactoryTrait;
}
