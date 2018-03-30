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

class TriQFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'qs0716d' => '3q qs0716d',
        'mt0812e' => '3q mt0812e',
        'mt0739d' => '3q mt0739d',
        'ac0732c' => '3q ac0732c',
        'rc9724c' => '3q rc9724c',
        'lc0720c' => '3q lc0720c',
        'er71b'   => '3q er71b',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general 3q device';

    use Factory\DeviceFactoryTrait;
}
