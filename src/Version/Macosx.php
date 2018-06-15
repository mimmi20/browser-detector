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

        if (false !== mb_stripos($useragent, 'darwin')) {
            $searches = [
                '/darwin\/18/i' => '10.14.0',
                '/darwin\/17\.6/i' => '10.13.6',
                '/darwin\/17\.5/i' => '10.13.5',
                '/darwin\/17\.4/i' => '10.13.4',
                '/darwin\/17\.3/i' => '10.13.3',
                '/darwin\/17\.2/i' => '10.13.2',
                '/darwin\/17\.1/i' => '10.13.1',
                '/darwin\/17/i' => '10.13.0',
                '/darwin\/16\.6/i' => '10.12.6',
                '/darwin\/16\.5/i' => '10.12.5',
                '/darwin\/16\.4/i' => '10.12.4',
                '/darwin\/16\.3/i' => '10.12.3',
                '/darwin\/16\.2/i' => '10.12.2',
                '/darwin\/16\.1/i' => '10.12.1',
                '/darwin\/16/i' => '10.12.0',
                '/darwin\/15\.6/i' => '10.11.6',
                '/darwin\/15\.5/i' => '10.11.5',
                '/darwin\/15\.4/i' => '10.11.4',
                '/darwin\/15\.3/i' => '10.11.3',
                '/darwin\/15\.2/i' => '10.11.2',
                '/darwin\/15\.1/i' => '10.11.1',
                '/darwin\/15/i' => '10.11.0',
                '/darwin\/14\.5/i' => '10.10.5',
                '/darwin\/14\.4/i' => '10.10.4',
                '/darwin\/14\.3/i' => '10.10.3',
                '/darwin\/14\.2/i' => '10.10.2',
                '/darwin\/14\.1/i' => '10.10.1',
                '/darwin\/14/i' => '10.10.0',
                '/darwin\/13\.5/i' => '10.9.5',
                '/darwin\/13\.4/i' => '10.9.4',
                '/darwin\/13\.3/i' => '10.9.3',
                '/darwin\/13\.2/i' => '10.9.2',
                '/darwin\/13\.1/i' => '10.9.1',
                '/darwin\/13/i' => '10.9.0',
                '/darwin\/12\.5/i' => '10.8.5',
                '/darwin\/12\.4/i' => '10.8.4',
                '/darwin\/12\.3/i' => '10.8.3',
                '/darwin\/12\.2/i' => '10.8.2',
                '/darwin\/12\.1/i' => '10.8.1',
                '/darwin\/12/i' => '10.8.0',
                '/darwin\/11\.4\.2/i' => '10.7.5',
                '/darwin\/11\.4/i' => '10.7.4',
                '/darwin\/11\.3/i' => '10.7.3',
                '/darwin\/11\.2/i' => '10.7.2',
                '/darwin\/11\.1/i' => '10.7.1',
                '/darwin\/11/i' => '10.7.0',
                '/darwin\/10\.8/i' => '10.6.8',
                '/darwin\/10\.7/i' => '10.6.7',
                '/darwin\/10\.6/i' => '10.6.6',
                '/darwin\/10\.5/i' => '10.6.5',
                '/darwin\/10\.4/i' => '10.6.4',
                '/darwin\/10\.3/i' => '10.6.3',
                '/darwin\/10\.2/i' => '10.6.2',
                '/darwin\/10\.1/i' => '10.6.1',
                '/darwin\/10/i' => '10.6.0',
                '/darwin\/9\.8/i' => '10.5.8',
                '/darwin\/9\.7/i' => '10.5.7',
                '/darwin\/9\.6/i' => '10.5.6',
                '/darwin\/9\.5/i' => '10.5.5',
                '/darwin\/9\.4/i' => '10.5.4',
                '/darwin\/9\.3/i' => '10.5.3',
                '/darwin\/9\.2/i' => '10.5.2',
                '/darwin\/9\.1/i' => '10.5.1',
                '/darwin\/9/i' => '10.5.0',
                '/darwin\/8\.11/i' => '10.4.11',
                '/darwin\/8\.10/i' => '10.4.10',
                '/darwin\/8\.9/i' => '10.4.9',
                '/darwin\/8\.8/i' => '10.4.8',
                '/darwin\/8\.7/i' => '10.4.7',
                '/darwin\/8\.6/i' => '10.4.6',
                '/darwin\/8\.5/i' => '10.4.5',
                '/darwin\/8\.4/i' => '10.4.4',
                '/darwin\/8\.3/i' => '10.4.3',
                '/darwin\/8\.2/i' => '10.4.2',
                '/darwin\/8\.1/i' => '10.4.1',
                '/darwin\/8/i' => '10.4.0',
                '/darwin\/7\.9/i' => '10.3.9',
                '/darwin\/7\.8/i' => '10.3.8',
                '/darwin\/7\.7/i' => '10.3.7',
                '/darwin\/7\.6/i' => '10.3.6',
                '/darwin\/7\.5/i' => '10.3.5',
                '/darwin\/7\.4/i' => '10.3.4',
                '/darwin\/7\.3/i' => '10.3.3',
                '/darwin\/7\.2/i' => '10.3.2',
                '/darwin\/7\.1/i' => '10.3.1',
                '/darwin\/7/i' => '10.3.0',
                '/darwin\/6\.8/i' => '10.2.8',
                '/darwin\/6\.7/i' => '10.2.7',
                '/darwin\/6\.6/i' => '10.2.6',
                '/darwin\/6\.5/i' => '10.2.5',
                '/darwin\/6\.4/i' => '10.2.4',
                '/darwin\/6\.3/i' => '10.2.3',
                '/darwin\/6\.2/i' => '10.2.2',
                '/darwin\/6\.1/i' => '10.2.1',
                '/darwin\/6/i' => '10.2.0',
                '/darwin\/5\.5/i' => '10.1.5',
                '/darwin\/5\.4/i' => '10.1.4',
                '/darwin\/5\.3/i' => '10.1.3',
                '/darwin\/5\.2/i' => '10.1.2',
                '/darwin\/5\.1/i' => '10.1.1',
                '/darwin\/1\.4\.1/i' => '10.1.0',
                '/darwin\/1\.3\.1/i' => '10.0.0',
            ];

            foreach ($searches as $rule => $version) {
                if (preg_match($rule, $useragent)) {
                    return (new VersionFactory())->set($version);
                }
            }
        }

        if (false !== mb_stripos($useragent, 'cfnetwork')) {
            $searches = [
                '/cfnetwork\/897.*\(x86_64\)/i' => '10.13',
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
