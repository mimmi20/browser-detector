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
namespace BrowserDetector\Factory;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Helper;
use BrowserDetector\Loader\PlatformLoaderFactory;
use Psr\Log\LoggerInterface;
use Stringy\Stringy;
use UaResult\Os\OsInterface;

class PlatformFactory implements PlatformFactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\PlatformLoaderFactory
     */
    private $loaderFactory;

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     */
    public function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->loaderFactory = new PlatformLoaderFactory($cache, $logger);
    }

    /**
     * Gets the information about the platform by User Agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return \UaResult\Os\OsInterface
     */
    public function __invoke(string $useragent): OsInterface
    {
        $s             = new Stringy($useragent);
        $windowsHelper = new Helper\Windows($s);
        $loaderFactory = $this->loaderFactory;

        if ($windowsHelper->isMobileWindows()) {
            $loader = $loaderFactory('windowsmobile');

            return $loader($useragent);
        }

        if ($windowsHelper->isWindows()) {
            $loader = $loaderFactory('windows');

            return $loader($useragent);
        }

        if (preg_match('/symb(?:ian|os)|series ?[346]0|s60v[35]|nokia7230/i', $useragent)) {
            $loader = $loaderFactory('symbian');

            return $loader($useragent);
        }

        if (preg_match('/commoncrawler|bada|meego|sailfish|cygwin|bsd|dragonfly|hp\-?ux|irix|web[o0]s|hpwos/i', $useragent)) {
            $loader = $loaderFactory('genericplatform');

            return $loader($useragent);
        }

        if (preg_match('/micromaxx650|dolfin\/|yuanda50|wap[- ]?browser/i', $useragent)) {
            $loader = $loaderFactory('java');

            return $loader($useragent);
        }

        if (preg_match('/MIUI/', $useragent)
            || preg_match('/yunos|tizen/i', $useragent)
            || (new Helper\AndroidOs($s))->isAndroid()
        ) {
            $loader = $loaderFactory('android');

            return $loader($useragent);
        }

        if (preg_match('/aix|openvms/i', $useragent)) {
            $loader = $loaderFactory('genericplatform');

            return $loader($useragent);
        }

        if (preg_match('/darwin|cfnetwork/i', $useragent)) {
            $loader = $loaderFactory('darwin');

            return $loader($useragent);
        }

        if ((new Helper\Linux($s))->isLinux()) {
            $loader = $loaderFactory('linux');

            return $loader($useragent);
        }

        if (preg_match('/maemo|like android|blackberry|bb10|remix/i', $useragent)) {
            $loader = $loaderFactory('genericplatform');

            return $loader($useragent);
        }

        if ((new Helper\FirefoxOs($s))->isFirefoxOs()) {
            $loader = $loaderFactory('firefoxos');

            return $loader($useragent);
        }

        if ((new Helper\Ios($s))->isIos()) {
            $loader = $loaderFactory('ios');

            return $loader($useragent);
        }

        if (preg_match('/nokia/i', $useragent)) {
            $loader = $loaderFactory('symbian');

            return $loader($useragent);
        }

        if (preg_match('/\bprofile\b/i', $useragent)) {
            $loader = $loaderFactory('java');

            return $loader($useragent);
        }

        $platforms = [
            'mac os x' => 'mac os x',
            'os=mac 10' => 'mac os x',
            'mac_powerpc' => 'macintosh',
            'ppc' => 'macintosh',
            '68k' => 'macintosh',
            'macintosh' => 'mac os x',
            'rim tablet' => 'rim tablet os',
            'amigaos' => 'amiga os',
            'brew' => 'brew',
            'beos' => 'beos',
            'opensolaris' => 'opensolaris',
            'solaris' => 'solaris',
            'sunos' => 'sunos',
            'risc' => 'risc os',
            'tru64 unix' => 'tru64 unix',
            'digital unix' => 'tru64 unix',
            'osf1' => 'tru64 unix',
            'unix' => 'unix',
            'os/2' => 'os/2',
            'warp' => 'os/2',
            'cp/m' => 'cp/m',
            'nintendo wii' => 'nintendo os',
            'nintendo 3ds' => 'nintendo os',
            'palm os' => 'palmos',
            'palmsource' => 'palmos',
            'wyderos' => 'wyderos',
            'liberate' => 'liberate',
            'inferno' => 'inferno os',
            'syllable' => 'syllable',
            'camino' => 'mac os x',
            'pubsub' => 'mac os x',
            'integrity' => 'mac os x',
            'gt-s5380' => 'bada',
            's8500' => 'bada',
            'java' => 'java',
            'j2me/midp' => 'java',
            'profile/midp' => 'java',
            'juc' => 'java',
            'ucweb' => 'java',
            'netfront' => 'java',
            'jasmine/1.0' => 'java',
            'obigo' => 'java',
            'spark284' => 'java',
            'lemon b556' => 'java',
            'kkt20' => 'java',
            'gt-c3312r' => 'java',
            'velocitymicro/t408' => 'android',
        ];

        if ($s->containsAny(array_keys($platforms), false)) {
            $loader = $loaderFactory('genericplatform');

            return $loader($useragent);
        }

        $loader = $loaderFactory('unknown');

        return $loader($useragent);
    }
}
