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

class TeclastFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'd4c5' => 'teclast d4c5',
        'k9c6' => 'teclast k9c6',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general teclast device';

    use Factory\DeviceFactoryTrait;
}
