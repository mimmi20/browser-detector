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

class CobyFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'mid9742' => 'coby mid9742',
        'mid8128' => 'coby mid8128',
        'mid8127' => 'coby mid8127',
        'mid8024' => 'coby mid8024',
        'mid7022' => 'coby mid7022',
        'mid7015' => 'coby mid7015',
        'mid1126' => 'coby mid1126',
        'mid1125' => 'coby mid1125',
        'nbpc724' => 'coby nbpc724',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general coby device';

    use Factory\DeviceFactoryTrait;
}
