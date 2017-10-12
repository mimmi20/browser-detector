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

use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;
use UaResult\Os\OsInterface;

/**
 * Browser detection class
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class BrowserFactory implements FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string                        $useragent
     * @param Stringy                       $s
     * @param \UaResult\Os\OsInterface|null $platform
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s, ?OsInterface $platform = null): array
    {
        if ($s->contains('edge', false)) {
            return (new Browser\EdgeBasedFactory($this->loader))->detect($useragent, $s, $platform);
        }

        if ($s->containsAny(['chrome', 'crmo'], false)) {
            return (new Browser\ChromeBasedFactory($this->loader))->detect($useragent, $s, $platform);
        }

        if ($s->containsAny(['safari', 'webkit', 'cfnetwork', 'dalvik'], false)) {
            return (new Browser\SafariBasedFactory($this->loader))->detect($useragent, $s, $platform);
        }

        if ($s->containsAny(['opera', 'presto'], false)) {
            return (new Browser\OperaBasedFactory($this->loader))->detect($useragent, $s, $platform);
        }

        if ($s->containsAny(['msie', 'trident', 'like gecko'], false)) {
            return (new Browser\IeBasedFactory($this->loader))->detect($useragent, $s, $platform);
        }

        if ($s->containsAny(['firefox', 'gecko'], false)) {
            return (new Browser\FirefoxBasedFactory($this->loader))->detect($useragent, $s, $platform);
        }

        return (new Browser\GenericBrowserFactory($this->loader))->detect($useragent, $s, $platform);
    }
}
