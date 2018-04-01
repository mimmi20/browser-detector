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

class MediacomFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'm-mp7s2d3g' => 'mediacom m-mp7s2d3g',
        'm-mp7s2a3g' => 'mediacom m-mp7s2a3g',
        'm-mp7s2k3g' => 'mediacom m-mp7s2k3g',
        'm-mp7s2b3g' => 'mediacom m-mp7s2b3g',
        'm-mp75s23g' => 'mediacom m-mp75s23g',
        'm-mp721m'   => 'mediacom m-mp721m',
        'm-mp720m'   => 'mediacom m-mp720m',
        'm-ppg700'   => 'mediacom m-ppg700',
        'm-pp2s650c' => 'mediacom m-pp2s650c',
        'm-pp2s650'  => 'mediacom m-pp2s650',
        'm-ppxs551u' => 'mediacom m-ppxs551u',
        'm-pp2s550'  => 'mediacom m-pp2s550',
        'm-ppag550'  => 'mediacom m-ppag550',
        'm-ppxs531'  => 'mediacom m-ppxs531',
        'm-mp5303g'  => 'mediacom m-mp5303g',
        'm-pp2g530'  => 'mediacom m-pp2g530',
        'm-mp940m'   => 'mediacom m-mp940m',
        'm-pp2s500b' => 'mediacom m-pp2s500b',
        'm-ppxg501'  => 'mediacom m-ppxg501',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general mediacom device';

    use Factory\DeviceFactoryTrait;
}
