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

use peterkahl\OSXbuild\OSXbuild;

class Macosx implements VersionCacheFactoryInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @throws \Exception
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        $doMatch = preg_match('/\((?:build )?(\d+[A-Z]\d+(?:[a-z])?)\)/i', $useragent, $matches);

        if ($doMatch && isset($matches[1])) {
            $buildVersion = OSXbuild::getVersion($matches[1]);

            if (false !== $buildVersion) {
                return (new VersionFactory())->set($buildVersion);
            }
        }

        $doMatch = preg_match('/coremedia v\d+\.\d+\.\d+\.(\d+[A-Z]\d+(?:[a-z])?)/i', $useragent, $matches);

        if ($doMatch && isset($matches[1])) {
            $buildVersion = OSXbuild::getVersion($matches[1]);

            if (false !== $buildVersion) {
                return (new VersionFactory())->set($buildVersion);
            }
        }

        if (false !== mb_stripos($useragent, 'cfnetwork')) {
            $searches = [
                '/cfnetwork\/887.*\(x86_64\)/i' => '10.13',
                '/cfnetwork\/811/i' => '10.12',
                '/cfnetwork\/807/i' => '10.12',
                '/cfnetwork\/802/i' => '10.12',
                '/cfnetwork\/798/i' => '10.12',
                '/cfnetwork\/796/i' => '10.12',
                '/cfnetwork\/790.*\(x86_64\)/i' => '10.12',
                '/cfnetwork\/760/i' => '10.11',
                '/cfnetwork\/720/i' => '10.10',
                '/cfnetwork\/718/i' => '10.10',
                '/cfnetwork\/714/i' => '10.10',
                '/cfnetwork\/709/i' => '10.10',
                '/cfnetwork\/708/i' => '10.10',
                '/cfnetwork\/705/i' => '10.10',
                '/cfnetwork\/699/i' => '10.10',
                '/cfnetwork\/696/i' => '10.10',
                '/cfnetwork\/673/i' => '10.9',
                '/cfnetwork\/647/i' => '10.9',
                '/cfnetwork\/596/i' => '10.8',
                '/cfnetwork\/595/i' => '10.8',
                '/cfnetwork\/561/i' => '10.8',
                '/cfnetwork\/520/i' => '10.7',
                '/cfnetwork\/515/i' => '10.7',
                '/cfnetwork\/454/i' => '10.6',
                '/cfnetwork\/438/i' => '10.5',
                '/cfnetwork\/433/i' => '10.5',
                '/cfnetwork\/422/i' => '10.5',
                '/cfnetwork\/339/i' => '10.5',
                '/cfnetwork\/330/i' => '10.5',
                '/cfnetwork\/221/i' => '10.5',
                '/cfnetwork\/220/i' => '10.5',
                '/cfnetwork\/217/i' => '10.5',
                '/cfnetwork\/129/i' => '10.4',
                '/cfnetwork\/128/i' => '10.4',
                '/cfnetwork\/4\.0/i' => '10.3',
                '/cfnetwork\/1\.2/i' => '10.3',
                '/cfnetwork\/1\.1/i' => '10.3',
            ];

            foreach ($searches as $rule => $version) {
                if (preg_match($rule, $useragent)) {
                    return (new VersionFactory())->set($version);
                }
            }
        }

        $searches = ['Mac OS X Version', 'Mac OS X v', 'Mac OS X', 'OS X', 'os=mac '];

        $detectedVersion = (new VersionFactory())->detectVersion($useragent, $searches);

        if (99 < $detectedVersion->getVersion(VersionInterface::IGNORE_MINOR)) {
            $versions = [];
            $found    = preg_match('/(\d{2})(\d)(\d)?/', $detectedVersion->getVersion(VersionInterface::IGNORE_MINOR), $versions);

            if ($found) {
                $version = $versions[1] . '.' . $versions[2];

                if (isset($versions[3])) {
                    $version .= '.' . $versions[3];
                }

                return (new VersionFactory())->set($version);
            }
        }

        return $detectedVersion;
    }
}
