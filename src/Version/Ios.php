<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Version;

use IosBuild\BuildException;
use IosBuild\IosBuildInterface;
use IosBuild\NotFoundException;
use Psr\Log\LoggerInterface;

final class Ios implements VersionDetectorInterface
{
    private const DARWIN_MAP = [
        '/darwin\/18\.2/i' => '12.2',
        '/darwin\/18\.1/i' => '12.1',
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

    /** @see https://justworks.ca/blog/ios-and */
    private const BUILD_MAP = [
        '508.11' => '2.2.1',
        '701.341' => '3.0',
        '701.400' => '3.0.1',
        '703.144' => '3.1',
        '704.11' => '3.1.2',
        '705.18' => '3.1.3',
        '702.367' => '3.2',
        '702.405' => '3.2.1',
        '702.500' => '3.2.2',
        '801.293' => '4.0',
        '801.306' => '4.0.1',
        '801.400' => '4.0.2',
        '802.117' => '4.1',
        '802.118' => '4.1',
        '803.148' => '4.2.1',
        '803.14800001' => '4.2.1',
        '805.128' => '4.2.5',
        '805.200' => '4.2.6',
        '805.303' => '4.2.7',
        '805.401' => '4.2.8',
        '805.501' => '4.2.9',
        '805.600' => '4.2.10',
        '806.190' => '4.3',
        '806.191' => '4.3',
        '807.4' => '4.3.1',
        '808.7' => '4.3.2',
        '808.8' => '4.3.2',
        '810.2' => '4.3.3',
        '810.3' => '4.3.3',
        '811.2' => '4.3.4',
        '812.1' => '4.3.5',
        '901.334' => '5.0',
        '901.40' => '5.0.1',
        '902.17' => '5.1',
        '902.206' => '5.1.1',
        '1001.40' => '6.0',
        '1001.52' => '6.0.1',
        '1002.14' => '6.1',
        '1002.146' => '6.1.2',
        '1002.329' => '6.1.3',
        '1002.350' => '6.1.3',
        '1101.465' => '7.0',
        '1101.470' => '7.0.1',
        '1101.47000001' => '7.0.1',
        '1101.501' => '7.0.2',
        '1102.511' => '7.0.3',
        '1102.55400001' => '7.0.4',
        '1102.601' => '7.0.5',
        '1102.651' => '7.0.6',
        '1104.167' => '7.1',
        '1104.169' => '7.1',
        '1104.201' => '7.1.1',
        '1104.257' => '7.1.2',
        '1201.365' => '8.0',
        '1201.366' => '8.0.1',
        '1201.405' => '8.0.2',
        '1202.410' => '8.1',
        '1202.411' => '8.1',
        '1202.435' => '8.1.1',
        '1202.436' => '8.1.1',
        '1202.440' => '8.1.2',
        '1202.445' => '8.1.2',
        '1202.466' => '8.1.3',
        '1204.508' => '8.2',
        '1206.69' => '8.3',
        '1208.143' => '8.4',
        '1208.321' => '8.4.1',
        '1301.342' => '9.0',
        '1301.344' => '9.0',
        '1301.402' => '9.0.1',
        '1301.404' => '9.0.1',
        '1301.452' => '9.0.2',
        '1302.143' => '9.1',
        '1303.075' => '9.2',
        '1304.15' => '9.2.1',
        '1305.234' => '9.3',
        '1305.328' => '9.3.1',
        '1306.69' => '9.3.2',
        '1306.72' => '9.3.2',
        '1307.34' => '9.3.3',
        '1307.35' => '9.3.4',
        '1307.36' => '9.3.5',
        '1401.403' => '10.0.1',
        '1401.456' => '10.0.2',
        '1402.72' => '10.1',
        '1402.100' => '10.1.1',
        '1403.92' => '10.2',
        '1404.27' => '10.2.1',
        '1405.277' => '10.3',
        '1405.304' => '10.3.1',
        '1406.89' => '10.3.2',
        '1406.8089' => '10.3.2',
        '1407.60' => '10.3.3',
        '1501.372' => '11.0',
        '1501.402' => '11.0.1',
        '1501.421' => '11.0.2',
        '1501.432' => '11.0.3',
        '1502.93' => '11.1',
        '1502.150' => '11.1.1',
        '1502.202' => '11.1.2',
        '1503.114' => '11.2',
        '1503.153' => '11.2.1',
        '1503.202' => '11.2.2',
        '1504.60' => '11.2.5',
        '1504.100' => '11.2.6',
        '1505.216' => '11.3',
        '1505.302' => '11.3.1',
        '1506.79' => '11.4',
        '1507.77' => '11.4.1',
        '1601.366' => '12.0',
        '1601.405' => '12.0.1',
        '1602.92' => '12.1',
        '1603.50' => '12.1.1',
    ];

    private const SEARCHES = [
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

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Version\VersionFactoryInterface
     */
    private $versionFactory;

    /**
     * @var \IosBuild\IosBuildInterface
     */
    private $iosBuild;

    /**
     * ChromeOs constructor.
     *
     * @param \Psr\Log\LoggerInterface                         $logger
     * @param \BrowserDetector\Version\VersionFactoryInterface $versionFactory
     * @param \IosBuild\IosBuildInterface                      $iosBuild
     */
    public function __construct(LoggerInterface $logger, VersionFactoryInterface $versionFactory, IosBuildInterface $iosBuild)
    {
        $this->logger         = $logger;
        $this->versionFactory = $versionFactory;
        $this->iosBuild       = $iosBuild;
    }

    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @throws \UnexpectedValueException
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        $doMatch = preg_match('/CPU like Mac OS X/', $useragent);

        if (0 < $doMatch) {
            return $this->versionFactory->set('1.0');
        }

        $doMatch = preg_match('/mobile\/(?P<build>\d+[A-Z]\d+(?:[a-z])?)/i', $useragent, $matches);

        if (0 < $doMatch) {
            try {
                $buildVersion = $this->iosBuild->getVersion($matches['build']);
            } catch (BuildException | NotFoundException $e) {
                $buildVersion = false;
            }

            if (false !== $buildVersion) {
                return $this->versionFactory->set((string) $buildVersion);
            }
        }

        $doMatch = preg_match('/applecoremedia\/\d+\.\d+\.\d+\.(?P<build>\d+[A-Z]\d+(?:[a-z])?)/i', $useragent, $matches);

        if (0 < $doMatch) {
            try {
                $buildVersion = $this->iosBuild->getVersion($matches['build']);
            } catch (BuildException | NotFoundException $e) {
                $buildVersion = false;
            }

            if (false !== $buildVersion) {
                return $this->versionFactory->set((string) $buildVersion);
            }
        }

        if (false !== mb_stripos($useragent, 'darwin')) {
            foreach (self::DARWIN_MAP as $rule => $version) {
                if ((bool) preg_match($rule, $useragent)) {
                    return $this->versionFactory->set($version);
                }
            }
        }

        $doMatch = preg_match('/^apple-(?:iphone|ip[ao]d)\d+[c,_]\d+\/(?P<build>[\d\.]+)$/i', $useragent, $matches);

        if (0 < $doMatch) {
            if (array_key_exists($matches['build'], self::BUILD_MAP)) {
                return $this->versionFactory->set(self::BUILD_MAP[$matches['build']]);
            }
        }

        $detectedVersion = $this->versionFactory->detectVersion($useragent, self::SEARCHES);

        if ('10.10' === $detectedVersion->getVersion(VersionInterface::IGNORE_MICRO)) {
            return $this->versionFactory->set('8.0.0');
        }

        return $detectedVersion;
    }
}
