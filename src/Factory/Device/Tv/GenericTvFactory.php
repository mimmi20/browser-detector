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
namespace BrowserDetector\Factory\Device\Tv;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class GenericTvFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'xbox one'                    => 'xbox one',
        'xbox'                        => 'xbox 360',
        'crkey'                       => 'google cromecast',
        'dlink.dsm380'                => 'dsm 380',
        'idl-6651n'                   => 'idl-6651n',
        'sl32x'                       => 'sl32x',
        'sl121'                       => 'sl121',
        'sl150'                       => 'sl150',
        'digio i33-hd+'               => 'telestar digio 33i hd+',
        'mxl661l32'                   => 'samsung smart tv',
        'smart-tv'                    => 'samsung smart tv',
        '(;metz;mms;;;)'              => 'general metz tv',
        '(;tcl; ; ; ;)'               => 'general tcl tv',
        'netrangemmh'                 => 'netrangemmh',
        'viera'                       => 'viera tv',
        'technisat digicorder isio s' => 'digicorder isio s',
        'technisat digit isio s'      => 'digit isio s',
        'technisat multyvision isio'  => 'multyvision isio',
        'cx919'                       => 'cx919',
        'gxt_dongle_3188'             => 'cx919',
        'apple tv'                    => 'appletv',
        'netbox'                      => 'sony netbox',
        'aston;xenahd twin connect'   => 'aston xenahd twin connect',
        'arcelik;bk'                  => 'arcelik bk',
        'arcelik;j5'                  => 'arcelik j5',
        'mstar;t42'                   => 'mstar t42',
        'aldinord; mb120'             => 'aldinord mb120',
        'aldinord;'                   => 'general aldinord tv',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general tv device';

    use Factory\DeviceFactoryTrait;
}
