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
     * @throws \Seld\JsonLint\ParsingException
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

        if (preg_match('/commoncrawler|msie or firefox mutant|not on windows server/i', $useragent)) {
            $loader = $loaderFactory('unknown');

            return $loader($useragent);
        }

        if (preg_match('/symb(?:ian|os)|series ?[346]0|s60v[35]|nokia7230/i', $useragent)) {
            $loader = $loaderFactory('symbian');

            return $loader($useragent);
        }

        if (preg_match('/maemo|like android|remix|bada|meego|sailfish/i', $useragent)) {
            $loader = $loaderFactory('maemo');

            return $loader($useragent);
        }

        if (preg_match('/bsd|dragonfly/i', $useragent)) {
            $loader = $loaderFactory('bsd');

            return $loader($useragent);
        }

        if (preg_match('/web[o0]s|hpwos/i', $useragent)) {
            $loader = $loaderFactory('webos');

            return $loader($useragent);
        }

        if (preg_match('/hp\-?ux|irix|aix|unix|osf1|openvms/i', $useragent)) {
            $loader = $loaderFactory('unix');

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

        if (preg_match('/darwin|cfnetwork/i', $useragent)) {
            $loader = $loaderFactory('darwin');

            return $loader($useragent);
        }

        if ((new Helper\Linux($s))->isLinux()) {
            $loader = $loaderFactory('linux');

            return $loader($useragent);
        }

        if (preg_match('/blackberry|bb10|rim tablet/i', $useragent)) {
            $loader = $loaderFactory('rimos');

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

        if (preg_match('/\bprofile\b|gt\-c3312r|kkt20|lemon b556|spark284|obigo|jasmine\/1\.0|netfront|profile\/midp|j2me\/|java|nucleus|maui runtime|mre/i', $useragent)) {
            $loader = $loaderFactory('java');

            return $loader($useragent);
        }

        if (preg_match('/mac os x|macintosh|os=mac 10|mac_powerpc|ppc|68k|camino|pubsub|integrity/i', $useragent)) {
            $loader = $loaderFactory('mac');

            return $loader($useragent);
        }

        if (preg_match('/sunos|solaris/i', $useragent)) {
            $loader = $loaderFactory('solaris');

            return $loader($useragent);
        }

        if (preg_match('/palm os|palmsource/i', $useragent)) {
            $loader = $loaderFactory('palm');

            return $loader($useragent);
        }

        if (preg_match('/amigaos|brew|beos|risc|os\/2|warp|cp\/m|nintendo (wii|3ds)|wyderos|liberate|inferno|syllable/i', $useragent)) {
            $loader = $loaderFactory('genericplatform');

            return $loader($useragent);
        }

        $loader = $loaderFactory('unknown');

        return $loader($useragent);
    }
}
