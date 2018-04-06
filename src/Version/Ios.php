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

use peterkahl\iOSbuild\iOSbuild;

class Ios implements VersionCacheFactoryInterface
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
        $doMatch = preg_match('/CPU like Mac OS X/', $useragent);

        if ($doMatch) {
            return (new VersionFactory())->set('1.0');
        }

        $doMatch = preg_match('/mobile\/(\d+[A-Z]\d+(?:[a-z])?)/i', $useragent, $matches);

        if ($doMatch && isset($matches[1])) {
            $buildVersion = iOSbuild::getVersion($matches[1]);

            if (false !== $buildVersion) {
                return (new VersionFactory())->set($buildVersion);
            }
        }

        $doMatch = preg_match('/applecoremedia\/\d+\.\d+\.\d+\.(\d+[A-Z]\d+(?:[a-z])?)/i', $useragent, $matches);

        if ($doMatch && isset($matches[1])) {
            $buildVersion = iOSbuild::getVersion($matches[1]);

            if (false !== $buildVersion) {
                return (new VersionFactory())->set($buildVersion);
            }
        }

        if (false !== mb_stripos($useragent, 'cfnetwork')) {
            $searches = [
                '/cfnetwork\/887/i' => '11.0',
                '/cfnetwork\/808\.2/i' => '10.2',
                '/cfnetwork\/808\.1/i' => '10.1',
                '/cfnetwork\/808/i' => '10.0',
                '/cfnetwork\/790/i' => '10.0',
                '/cfnetwork\/758\.3/i' => '9.3',
                '/cfnetwork\/758\.2/i' => '9.2',
                '/cfnetwork\/758\.1/i' => '9.1',
                '/cfnetwork\/758/i' => '9.0',
                '/cfnetwork\/757/i' => '9.0',
                '/cfnetwork\/711\.[45]/i' => '8.4',
                '/cfnetwork\/711\.3/i' => '8.3',
                '/cfnetwork\/711\.2/i' => '8.2',
                '/cfnetwork\/711\.1/i' => '8.1',
                '/cfnetwork\/711/i' => '8.0',
                '/cfnetwork\/709/i' => '8.0',
                '/cfnetwork\/672\.1/i' => '7.1',
                '/cfnetwork\/672/i' => '7.0',
                '/cfnetwork\/609\.1/i' => '6.1',
                '/cfnetwork\/609/i' => '6.0',
                '/cfnetwork\/602/i' => '6.0',
                '/cfnetwork\/548\.1/i' => '5.1',
                '/cfnetwork\/548/i' => '5.0',
                '/cfnetwork\/485\.13/i' => '4.3',
                '/cfnetwork\/485\.12/i' => '4.2',
                '/cfnetwork\/485\.10/i' => '4.1',
                '/cfnetwork\/485\.2/i' => '4.0',
                '/cfnetwork\/467\.12/i' => '3.2',
                '/cfnetwork\/459/i' => '3.1',
            ];

            foreach ($searches as $rule => $version) {
                if (preg_match($rule, $useragent)) {
                    return (new VersionFactory())->set($version);
                }
            }
        }

        $searches = [
            'IphoneOSX',
            'CPU OS_?',
            'CPU iOS',
            'CPU iPad OS',
            'iPhone OS\;FBSV',
            'iPhone OS',
            'iPhone_OS',
            'IUC\(U\;iOS',
            'iPh OS',
            'iosv',
            'iOS',
        ];

        $detectedVersion = (new VersionFactory())->detectVersion($useragent, $searches);

        if ('10.10' === $detectedVersion->getVersion(VersionInterface::IGNORE_MICRO)) {
            return (new VersionFactory())->set('8.0.0');
        }

        return $detectedVersion;
    }
}
