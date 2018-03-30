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

class PhicommFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'c630'      => 'phicomm c630',
        'e670'      => 'phicomm e670',
        'e653'      => 'phicomm e653',
        'clue c230' => 'phicomm clue c230',
        'clue 2s'   => 'phicomm clue 2s',
        'fws610_eu' => 'phicomm fws610',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general phicomm device';

    use Factory\DeviceFactoryTrait;
}
