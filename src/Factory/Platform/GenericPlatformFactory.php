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
namespace BrowserDetector\Factory\Platform;

use BrowserDetector\Factory\FactoryInterface;
use BrowserDetector\Helper;
use BrowserDetector\Loader\PlatformLoader;
use Stringy\Stringy;
use UaResult\Os\OsInterface;

class GenericPlatformFactory implements FactoryInterface
{
    /**
     * @var array
     */
    private $platforms = [
        'commoncrawler' => 'unknown',
        'symbianos'     => 'symbian',
        'symbos'        => 'symbian',
        'symbian'       => 'symbian',
        'series 60'     => 'symbian',
        's60v3'         => 'symbian',
        's60v5'         => 'symbian',
        'nokia7230'     => 'symbian',
        'bada'          => 'bada',
        'meego'         => 'meego',
        'sailfish'      => 'sailfishos',
        'cygwin'        => 'cygwin',
        'netbsd'        => 'netbsd',
        'openbsd'       => 'openbsd',
        'dragonfly'     => 'dragonfly bsd',
        'hp-ux'         => 'hp-ux',
        'hpux'          => 'hp-ux',
        'irix'          => 'irix',
        'webos'         => 'webos',
        'hpwos'         => 'webos',
        'tizen'         => 'tizen',
        'kfreebsd'      => 'debian with freebsd kernel',
        'freebsd'       => 'freebsd',
        'bsd'           => 'bsd',
        'MIUI' => 'miui os',
        'micromaxx650' => 'java',
        'dolfin/'      => 'java',
        'yuanda50'     => 'java',
        'wap browser'  => 'java',
        'wap-browser'  => 'java',
        'yunos'        => 'yun os',
        'aliyunos'     => 'yun os',
        'aix'     => 'aix',
        'openvms' => 'openvms',
        'maemo'        => 'linux smartphone os (maemo)',
        'like android' => 'linux smartphone os (maemo)',
        'blackberry'   => 'rim os',
        'bb10'         => 'rim os',
        'remix'        => 'remixos',
        'mac os x'           => 'mac os x',
        'os=mac 10'          => 'mac os x',
        'mac_powerpc'        => 'macintosh',
        'ppc'                => 'macintosh',
        '68k'                => 'macintosh',
        'macintosh'          => 'mac os x',
        'rim tablet'         => 'rim tablet os',
        'amigaos'            => 'amiga os',
        'brew'               => 'brew',
        'beos'               => 'beos',
        'opensolaris'        => 'opensolaris',
        'solaris'            => 'solaris',
        'sunos'              => 'sunos',
        'risc'               => 'risc os',
        'tru64 unix'         => 'tru64 unix',
        'digital unix'       => 'tru64 unix',
        'osf1'               => 'tru64 unix',
        'unix'               => 'unix',
        'os/2'               => 'os/2',
        'warp'               => 'os/2',
        'cp/m'               => 'cp/m',
        'nintendo wii'       => 'nintendo os',
        'nintendo 3ds'       => 'nintendo os',
        'palm os'            => 'palmos',
        'palmsource'         => 'palmos',
        'wyderos'            => 'wyderos',
        'liberate'           => 'liberate',
        'inferno'            => 'inferno os',
        'syllable'           => 'syllable',
        'camino'             => 'mac os x',
        'pubsub'             => 'mac os x',
        'integrity'          => 'mac os x',
        'gt-s5380'           => 'bada',
        's8500'              => 'bada',
        'java'               => 'java',
        'j2me/midp'          => 'java',
        'profile/midp'       => 'java',
        'juc'                => 'java',
        'ucweb'              => 'java',
        'netfront'           => 'java',
        'jasmine/1.0'        => 'java',
        'obigo'              => 'java',
        'spark284'           => 'java',
        'lemon b556'         => 'java',
        'kkt20'              => 'java',
        'gt-c3312r'          => 'java',
        'velocitymicro/t408' => 'android',
    ];

    /**
     * @var string
     */
    private $genericPlatform = 'unknown';

    /**
     * @var \BrowserDetector\Loader\PlatformLoader
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\PlatformLoader $loader
     */
    public function __construct(PlatformLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Gets the information about the platform by User Agent
     *
     * @param string  $useragent
     * @param Stringy $s
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect(string $useragent, Stringy $s): OsInterface
    {
        foreach ($this->platforms as $searchkey => $platfornKey) {
            if ($s->contains($searchkey, false)) {
                return $this->loader->load($platfornKey, $useragent);
            }
        }

        return $this->loader->load($this->genericPlatform, $useragent);
    }
}
