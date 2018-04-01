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

class AinolFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'numy_note_9' => 'ainol numy note 9',
        'novo7fire'   => 'ainol novo7fire',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general ainol device';

    use Factory\DeviceFactoryTrait;
}
