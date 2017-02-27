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
use BrowserDetector\Loader\LoaderInterface;
use BrowserDetector\Version\VersionInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Stringy\Stringy;

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
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
        $this->loader = $loader;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function detect($useragent)
    {
        $s         = new Stringy($useragent);
        $engineKey = 'unknown';

        if ($s->contains('Edge')) {
            $engineKey = 'edge';
        } elseif ($s->contains(' U2/')) {
            $engineKey = 'u2';
        } elseif ($s->contains(' U3/')) {
            $engineKey = 'u3';
        } elseif ($s->contains(' T5/')) {
            $engineKey = 't5';
        } elseif (preg_match('/(msie|trident|outlook|kkman)/i', $useragent)
            && false === mb_stripos($useragent, 'opera')
            && false === mb_stripos($useragent, 'tasman')
        ) {
            $engineKey = 'trident';
        } elseif (preg_match('/(goanna)/i', $useragent)) {
            $engineKey = 'goanna';
        } elseif (preg_match('/(clecko)/i', $useragent)) {
            $engineKey = 'clecko';
        } elseif (preg_match('/(applewebkit|webkit|cfnetwork|safari|dalvik)/i', $useragent)) {
            /** @var \UaResult\Browser\Browser $chrome */
            list($chrome) = (new BrowserLoader($this->cache))->load('chrome', $useragent);
            $version      = $chrome->getVersion();

            if (null !== $version) {
                $chromeVersion = (int) $version->getVersion(VersionInterface::IGNORE_MINOR);
            } else {
                $chromeVersion = 0;
            }

            if ($chromeVersion >= 28) {
                $engineKey = 'blink';
            } else {
                $engineKey = 'webkit';
            }
        } elseif (preg_match('/(KHTML|Konqueror)/', $useragent)) {
            $engineKey = 'khtml';
        } elseif (preg_match('/(tasman)/i', $useragent)
            || $s->containsAll(['MSIE', 'Mac_PowerPC'])
        ) {
            $engineKey = 'tasman';
        } elseif (preg_match('/(Presto|Opera)/', $useragent)) {
            $engineKey = 'presto';
        } elseif (preg_match('/(Gecko|Firefox)/', $useragent)) {
            $engineKey = 'gecko';
        } elseif (preg_match('/(NetFront\/|NF\/|NetFrontLifeBrowserInterface|NF3|Nintendo 3DS)/', $useragent)
            && !$s->containsAny(['Kindle'])
        ) {
            $engineKey = 'netfront';
        } elseif ($s->contains('BlackBerry')) {
            $engineKey = 'blackberry';
        } elseif (preg_match('/(Teleca|Obigo)/', $useragent)) {
            $engineKey = 'teleca';
        }

        return $this->loader->load($engineKey, $useragent);
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function fromArray(LoggerInterface $logger, array $data)
    {
        return (new \UaResult\Engine\EngineFactory())->fromArray($this->cache, $logger, $data);
    }
}
