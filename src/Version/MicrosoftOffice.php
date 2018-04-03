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
namespace BrowserDetector\Version;

use BrowserDetector\Version\Helper\MicrosoftOffice as MicrosoftOfficeHelper;

class MicrosoftOffice implements VersionCacheFactoryInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        $helper = new MicrosoftOfficeHelper();

        return VersionFactory::set($helper->mapOfficeVersion($this->detectInternalVersion($useragent)));
    }

    /**
     * detects the browser version from the given user agent
     *
     * @param string $useragent
     *
     * @return string
     */
    private function detectInternalVersion(string $useragent): string
    {
        $doMatch = preg_match('/MSOffice ([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            return $matches[1];
        }

        $doMatch = preg_match('/Office\/([\d\.]+)/i', $useragent, $matches);

        if ($doMatch) {
            return $matches[1];
        }

        $doMatch = preg_match('/Office Mobile\/([\d\.]+)/i', $useragent, $matches);

        if ($doMatch) {
            return $matches[1];
        }

        $doMatch = preg_match('/Office Mobile for Symbian\/([\d\.]+)/i', $useragent, $matches);

        if ($doMatch) {
            return $matches[1];
        }

        return '0';
    }
}
