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
namespace BrowserDetector\Loader;

use BrowserDetector\Bits\Os as OsBits;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaResult\Company\CompanyLoader;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

class PlatformLoader
{
    private const CACHE_PREFIX = 'platform';

    use LoaderTrait;

    /**
     * @param string $platformCode
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Os\OsInterface
     */
    public function load(string $platformCode, string $useragent = ''): OsInterface
    {
        try {
            $platform = $this->cache->getItem($this->getCacheKey($platformCode));
        } catch (InvalidArgumentException $e) {
            throw new NotFoundException('the platform with key "' . $platformCode . '" was not found', 0, $e);
        }

        $platformVersionClass = $platform->version->class;

        if (!is_string($platformVersionClass) && isset($platform->version->value) && is_numeric($platform->version->value)) {
            $version = (new VersionFactory())->set((string) $platform->version->value);
        } elseif (!is_string($platformVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $platformVersionClass) {
            $version = (new VersionFactory())->detectVersion($useragent, $platform->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $platformVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        $name          = $platform->name;
        $marketingName = $platform->marketingName;
        $manufacturer  = CompanyLoader::getInstance()->load($platform->manufacturer);

        if ('Mac OS X' === $name
            && version_compare($version->getVersion(VersionInterface::IGNORE_MICRO), '10.12', '>=')
        ) {
            $name          = 'macOS';
            $marketingName = 'macOS';
        }

        $bits = (new OsBits($useragent))->getBits();

        return new Os($name, $marketingName, $manufacturer, $version, $bits);
    }
}
