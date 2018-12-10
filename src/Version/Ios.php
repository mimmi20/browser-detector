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

final class Ios implements VersionDetectorInterface
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

        if (false !== mb_stripos($useragent, 'darwin')) {
            $searches = [
                '/darwin\/18/i' => '12.0',
                '/darwin\/17\.7/i' => '11.4',
                '/darwin\/17\.6/i' => '11.4',
                '/cfnetwork\/897(\.\d+)? darwin\/17\.5/i' => '11.3',
                '/darwin\/17\.4/i' => '11.2',
                '/darwin\/17\.3/i' => '11.2',
                '/darwin\/17\.2/i' => '11.1',
                '/darwin\/17/i' => '11.0',
                '/darwin\/16\.7/i' => '10.3.3',
                '/darwin\/16\.6/i' => '10.3.2',
                '/darwin\/16\.5/i' => '10.3',
                '/darwin\/16\.3/i' => '10.2',
                '/darwin\/16\.1/i' => '10.1',
                '/darwin\/16/i' => '10.0',
                '/darwin\/15\.6/i' => '9.3.3',
                '/darwin\/15\.5/i' => '9.3.2',
                '/darwin\/15\.4/i' => '9.3',
                '/cfnetwork\/758\.3(\.\d+)? darwin\/15/i' => '9.3',
                '/cfnetwork\/758\.2(\.\d+)? darwin\/15/i' => '9.2',
                '/cfnetwork\/758\.1(\.\d+)? darwin\/15/i' => '9.1',
                '/darwin\/15/i' => '9.0',
                '/cfnetwork\/711\.[45](\.\d+)? darwin\/14/i' => '8.4',
                '/cfnetwork\/711\.3(\.\d+)? darwin\/14/i' => '8.3',
                '/cfnetwork\/711\.2(\.\d+)? darwin\/14/i' => '8.2',
                '/cfnetwork\/711\.1(\.\d+)? darwin\/14/i' => '8.1',
                '/cfnetwork\/711([\.\d]+)? darwin\/14/i' => '8.0',
                '/cfnetwork\/709(\.\d+)? darwin\/14/i' => '8.0',
                '/cfnetwork\/672\.1(\.\d+)? darwin\/14/i' => '7.1',
                '/darwin\/14/i' => '7.0',
                '/cfnetwork\/609\.1(\.\d+)? darwin\/13/i' => '6.1',
                '/darwin\/13/i' => '6.0',
                '/cfnetwork\/548\.1(\.\d+)? darwin\/11/i' => '5.1',
                '/cfnetwork\/548([\.\d]+)? darwin\/11/i' => '5.0',
                '/darwin\/11/i' => '4.3',
                '/darwin\/10\.4/i' => '4.2',
                '/cfnetwork\/485\.10(\.\d+)? darwin\/10\.3/i' => '4.1',
                '/cfnetwork\/485\.2(\.\d+)? darwin\/10\.3/i' => '4.0',
                '/darwin\/10\.3/i' => '3.2',
                '/cfnetwork\/459 darwin\/10/i' => '3.1',
                '/darwin\/10/i' => '3.0',
                '/darwin\/9\.4/i' => '2.1',
                '/darwin\/9\.3/i' => '2.0',
                '/darwin\/9/i' => '1.0',
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
            'iPad\/',
            'iOS',
        ];

        $detectedVersion = (new VersionFactory())->detectVersion($useragent, $searches);

        if ('10.10' === $detectedVersion->getVersion(VersionInterface::IGNORE_MICRO)) {
            return (new VersionFactory())->set('8.0.0');
        }

        return $detectedVersion;
    }
}
