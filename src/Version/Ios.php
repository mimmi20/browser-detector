<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use BrowserDetector\Version\Exception\NotNumericException;
use IosBuild\Exception\NotFoundException;
use IosBuild\IosBuildInterface;
use Override;
use UnexpectedValueException;

use function array_filter;
use function array_first;
use function array_key_exists;
use function array_map;
use function mb_strtolower;
use function preg_match;
use function str_contains;

final readonly class Ios implements VersionFactoryInterface
{
    /** @api */
    public const array SEARCHES = [
        'watchOS',
        'tvOS',
        'IphoneOSX',
        'CPU OS_?',
        'CPU iOS',
        'CPU iPad ?OS',
        'CPU Phone ?OS',
        'CPU iPod ?OS',
        'iPhone OS\;FBSV',
        'iOS\;FBSV[\/ ]?',
        'iPhone[ _]OS',
        'IUC\(U\;iOS',
        'iPhone[0-9]+,[0-9]+; ',
        'iPh OS',
        'iPa?d ?OS',
        'iosv',
        '(?<!browser)iPad\/',
        'iPhone\/',
        '(?<![rtx]|[ekpry][- ])iOS',
        'Version',
    ];

    private const array DARWIN_MAP = [
        '/darwin\/25\.4/i' => '26.4',
        '/darwin\/25\.3/i' => '26.3',
        '/darwin\/25\.2/i' => '26.2',
        '/darwin\/25\.1/i' => '26.1',
        '/darwin\/25/i' => '26.0',
        '/darwin\/24\.6/i' => '18.6',
        '/darwin\/24\.5/i' => '18.5',
        '/darwin\/24\.4/i' => '18.4',
        '/darwin\/24\.3/i' => '18.3',
        '/darwin\/24\.2/i' => '18.2',
        '/darwin\/24\.1/i' => '18.1',
        '/darwin\/24/i' => '18.0',
        '/darwin\/23\.6/i' => '17.6',
        '/darwin\/23\.5/i' => '17.5',
        '/darwin\/23\.4/i' => '17.4',
        '/darwin\/23\.3/i' => '17.3',
        '/darwin\/23\.2/i' => '17.2',
        '/darwin\/23\.1/i' => '17.1',
        '/darwin\/23/i' => '17.0',
        '/darwin\/22\.6/i' => '16.6',
        '/darwin\/22\.5/i' => '16.5',
        '/darwin\/22\.4/i' => '16.4',
        '/darwin\/22\.3/i' => '16.3',
        '/darwin\/22\.2/i' => '16.2',
        '/darwin\/22\.1/i' => '16.1',
        '/darwin\/22/i' => '16.0',
        '/darwin\/21\.6/i' => '15.6',
        '/darwin\/21\.5/i' => '15.5',
        '/darwin\/21\.4/i' => '15.4',
        '/darwin\/21\.3/i' => '15.3',
        '/darwin\/21\.2/i' => '15.2',
        '/darwin\/21\.1/i' => '15.1',
        '/darwin\/21/i' => '15.0',
        '/darwin\/20\.6/i' => '14.7',
        '/darwin\/20\.5/i' => '14.6',
        '/darwin\/20\.4/i' => '14.5',
        '/darwin\/20\.3/i' => '14.4',
        '/darwin\/20\.2/i' => '14.3',
        '/darwin\/20\.1/i' => '14.2',
        '/darwin\/20/i' => '14.0',
        '/darwin\/19\.6/i' => '13.6',
        '/darwin\/19\.5/i' => '13.5',
        '/darwin\/19\.4/i' => '13.4',
        '/darwin\/19\.3/i' => '13.3.1',
        '/darwin\/19\.2/i' => '13.3',
        '/darwin\/19/i' => '13.0',
        '/darwin\/18\.7/i' => '12.4',
        '/darwin\/18\.6/i' => '12.3',
        '/darwin\/18\.5/i' => '12.2',
        '/darwin\/18\.[12]/i' => '12.1',
        '/darwin\/18/i' => '12.0',
        '/darwin\/17\.7/i' => '11.4',
        '/darwin\/17\.6/i' => '11.4',
        '/cfnetwork\/901(\.\d+)? darwin\/17\.5/i' => '11.3',
        '/cfnetwork\/897(\.\d+)? darwin\/17\.5/i' => '11.3',
        '/darwin\/17\.4/i' => '11.2',
        '/darwin\/17\.3/i' => '11.2',
        '/darwin\/17\.2/i' => '11.1',
        '/darwin\/17/i' => '11.0',
        '/darwin\/16\.7/i' => '10.3.3',
        '/darwin\/16\.6/i' => '10.3.2',
        '/darwin\/16\.5/i' => '10.3',
        '/cfnetwork\/808\.3(\.\d+)? darwin\/16\.3/i' => '10.3',
        '/darwin\/16\.3/i' => '10.2',
        '/darwin\/16\.1/i' => '10.1',
        '/darwin\/16/i' => '10.0',
        '/cfnetwork\/808\.0(\.\d+)? darwin\/15\.6/i' => '10.0',
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
        '/cfnetwork\/609\.1(\.\d+)? darwin\/12/i' => '6.1',
        '/darwin\/13/i' => '6.0',
        '/cfnetwork\/548\.1(\.\d+)? darwin\/11/i' => '5.1',
        '/cfnetwork\/548([\.\d]+)? darwin\/11/i' => '5.0',
        '/darwin\/11/i' => '4.3',
        '/cfnetwork\/485\.13([\.\d]+)? darwin\/10\.8/i' => '4.3',
        '/cfnetwork\/485\.12([\.\d]+)? darwin\/10\.8/i' => '4.2',
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
    private const array BUILD_MAP = [
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
        '1604.39' => '12.1.3',
        '1604.57' => '12.1.4',
        '1605.227' => '12.2',
        '1606.156' => '12.3',
        '1606.203' => '12.3.1',
        '1607.77' => '12.4',
        '1607.102' => '12.4.1',
        '1607.114' => '12.4.2',
        '1607.130' => '12.4.3',
        '1607.140' => '12.4.4',
        '1607.161' => '12.4.5',
        '1607.183' => '12.4.6',
        '1607.192' => '12.4.7',
        '1607.201' => '12.4.8',
        '1608.5' => '12.4.9',
        '1608.20' => '12.5',
        '1701.577' => '13.0',
        '1701.844' => '13.1',
        '1701.854' => '13.1.2',
        '1702.84' => '13.2',
        '1702.102' => '13.2.2',
        '1702.111' => '13.2.3',
        '1703.54' => '13.3',
        '1705.255' => '13.4',
        '1705.262' => '13.4.1',
        '1706.75' => '13.5',
        '1706.80' => '13.5.1',
        '1707.68' => '13.6',
        '1707.80' => '13.6.1',
        '1708.35' => '13.7',
        '1801.373' => '14.0',
        '1801.393' => '14.0.1',
        '1801.8395' => '14.1',
        '1802.92' => '14.2',
        '1803.66' => '14.3',
        '1804.52' => '14.4',
        '1804.61' => '14.4.4',
        '1804.70' => '14.4.2',
        '1805.199' => '14.5',
        '1805.212' => '14.5.1',
        '1806.72' => '14.6',
        '1807.69' => '14.7',
        '1807.82' => '14.7.1',
        '1808.17' => '14.8',
        '1901.346' => '15.0',
        '1901.348' => '15.0.1',
        '1902.74' => '15.1',
        '1902.81' => '15.1.1',
        '1903.63' => '15.2.1',
        '1904.50' => '15.3',
        '1904.52' => '15.3.1',
        '1905.241' => '15.4',
        '1905.258' => '15.4.1',
        '1906.77' => '15.5',
        '1907.71' => '15.6',
        '1907.82' => '15.6.1',
        '1908.12' => '15.7',
        '1908.117' => '15.7.1',
        '2001.362' => '16.0',
        '2001.380' => '16.0.2',
        '2001.392' => '16.1',
        '2002.82' => '16.1',
        '2002.101' => '16.1.1',
        '2002.110' => '16.1.2',
        '2003.65' => '16.2',
        '2004.47' => '16.3',
        '2004.67' => '16.3.1',
        '2005.247' => '16.4',
        '2005.252' => '16.4.1',
    ];

    /** @throws void */
    public function __construct(private VersionBuilderInterface $versionBuilder, private IosBuildInterface $iosBuild)
    {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[Override]
    public function detectVersion(string $useragent): VersionInterface
    {
        $regexes = [
            '/[aA]pple[cC]ore[mM]edia\/\d+\.\d+\.\d+\.(?P<build>\d{1,2}[A-Z]\d{1,4}[a-z]?)/',
            '/i[oO][sS]\/\d+[\d\.]+ \((?P<build>\d{1,2}[A-Z]\d{1,4}[a-z]?)\)/',
        ];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $useragent),
        );

        $results = array_map(
            static function (string $regex) use ($useragent): string {
                $matches = [];

                preg_match($regex, $useragent, $matches);

                return $matches['build'] ?? '';
            },
            $filtered,
        );

        $detectedBuild = array_first($results);

        if ($detectedBuild !== null && $detectedBuild !== '') {
            try {
                $buildVersion = $this->iosBuild->getVersion($detectedBuild);

                return $this->versionBuilder->set($buildVersion);
            } catch (NotFoundException | NotNumericException) {
                // do nothing
            }

            return new NullVersion();
        }

        if (
            str_contains(mb_strtolower($useragent), 'darwin')
            && !str_contains(mb_strtolower($useragent), 'watchos')
        ) {
            foreach (self::DARWIN_MAP as $rule => $version) {
                if (!preg_match($rule, $useragent)) {
                    continue;
                }

                try {
                    return $this->versionBuilder->set($version);
                } catch (NotNumericException) {
                    return new NullVersion();
                }
            }
        }

        $regexes = ['/^apple-(?:iphone|ip[ao]d)\d+[c,_]\d+\/(?P<build>[\d\.]+)$/i'];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $useragent),
        );

        $results = array_map(
            static function (string $regex) use ($useragent): string {
                $matches = [];

                preg_match($regex, $useragent, $matches);

                return $matches['build'] ?? '';
            },
            $filtered,
        );

        $detectedBuildVersion = array_first($results);

        if ($detectedBuildVersion !== null && $detectedBuildVersion !== '') {
            if (array_key_exists($detectedBuildVersion, self::BUILD_MAP)) {
                try {
                    return $this->versionBuilder->set(self::BUILD_MAP[$detectedBuildVersion]);
                } catch (NotNumericException) {
                    return new NullVersion();
                }
            }
        }

        try {
            $detectedVersion = $this->versionBuilder->detectVersion($useragent, self::SEARCHES);
        } catch (NotNumericException) {
            return new NullVersion();
        }

        if ($detectedVersion->getVersion(VersionInterface::IGNORE_MICRO) === '10.10') {
            try {
                return $this->versionBuilder->set('8.0.0');
            } catch (NotNumericException) {
                return new NullVersion();
            }
        }

        $versionNumber = $detectedVersion->getVersion(VersionInterface::IGNORE_MINOR);

        if ($versionNumber !== null) {
            if (
                preg_match('/(?P<major>\d{1,2})(?P<minor>\d)(?P<micro>\d)/', $versionNumber, $versions)
            ) {
                $version = $versions['major'] . '.' . $versions['minor'];

                if (array_key_exists('micro', $versions)) {
                    $version .= '.' . $versions['micro'];
                }

                try {
                    return $this->versionBuilder->set($version);
                } catch (NotNumericException) {
                    return new NullVersion();
                }
            }
        }

        return $detectedVersion;
    }
}
