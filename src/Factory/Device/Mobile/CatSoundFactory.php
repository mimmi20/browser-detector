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

class CatSoundFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'cathelixm'              => 'catsound cathelixm',
        'cathelix'               => 'catsound cathelix',
        'catnova8'               => 'catsound cat nova 8',
        'nova'                   => 'catsound nova',
        'cat tablet galactica x' => 'catsound galactica x',
        'stargate'               => 'catsound stargate',
        'cat tablet phoenix'     => 'catsound phoenix',
        'cat tablet'             => 'catsound tablet',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general catsound device';

    use Factory\DeviceFactoryTrait;
}
