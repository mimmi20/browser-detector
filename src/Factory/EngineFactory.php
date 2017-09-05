<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use BrowserDetector\Version\VersionInterface;
use Stringy\Stringy;
use UaResult\Engine\EngineInterface;
use UaResult\Os\OsInterface;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class EngineFactory implements FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string                                     $useragent
     * @param Stringy                                    $s
     * @param \BrowserDetector\Loader\BrowserLoader|null $browserLoader
     * @param \UaResult\Os\OsInterface|null              $platform
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function detect(string $useragent, Stringy $s, ?BrowserLoader $browserLoader = null, ?OsInterface $platform = null): EngineInterface
    {
        if (null !== $platform && in_array($platform->getName(), ['iOS'])) {
            return $this->loader->load('webkit', $useragent);
        }

        $s = new Stringy($useragent);

        if ($s->contains('Edge')) {
            return $this->loader->load('edge', $useragent);
        }

        if ($s->contains(' U3/')) {
            return $this->loader->load('u3', $useragent);
        }

        if ($s->contains(' U2/')) {
            return $this->loader->load('u2', $useragent);
        }

        if ($s->contains(' T7/')) {
            return $this->loader->load('t7', $useragent);
        }

        if ($s->contains(' T5/')) {
            return $this->loader->load('t5', $useragent);
        }

        if ($s->containsAny(['msie', 'trident', 'outlook', 'kkman'], false)
            && !$s->contains('opera', false)
            && !$s->contains('tasman', false)
        ) {
            return $this->loader->load('trident', $useragent);
        }

        if ($s->contains('goanna', false)) {
            return $this->loader->load('goanna', $useragent);
        }

        if ($s->contains('clecko', false)) {
            return $this->loader->load('clecko', $useragent);
        }

        if (null !== $browserLoader && $s->containsAny(['webkit', 'cfnetwork', 'safari', 'dalvik'], false)) {
            /** @var \UaResult\Browser\Browser $chrome */
            list($chrome)  = $browserLoader->load('chrome', $useragent);
            $version       = $chrome->getVersion();
            $chromeVersion = 0;

            if (null !== $version) {
                $chromeVersion = (int) $version->getVersion(VersionInterface::IGNORE_MINOR);
            }

            if ($chromeVersion >= 28) {
                return $this->loader->load('blink', $useragent);
            }

            return $this->loader->load('webkit', $useragent);
        }

        if ($s->containsAny(['khtml', 'konqueror'], false)) {
            return $this->loader->load('khtml', $useragent);
        }

        if ($s->contains('tasman', false) || $s->containsAll(['MSIE', 'Mac_PowerPC'])) {
            return $this->loader->load('tasman', $useragent);
        }

        if ($s->containsAny(['presto', 'opera'], false)) {
            return $this->loader->load('presto', $useragent);
        }

        if ($s->containsAny(['gecko', 'firefox'], false)) {
            return $this->loader->load('gecko', $useragent);
        }

        if ($s->containsAny(['netfront/', 'nf/', 'NetFrontLifeBrowserInterface', 'NF3', 'Nintendo 3DS'], false)
            && !$s->containsAny(['kindle'], false)
        ) {
            return $this->loader->load('netfront', $useragent);
        }

        if ($s->contains('blackberry', false)) {
            return $this->loader->load('blackberry', $useragent);
        }

        if ($s->containsAny(['teleca', 'obigo'], false)) {
            return $this->loader->load('teleca', $useragent);
        }

        return $this->loader->load('unknown', $useragent);
    }
}
