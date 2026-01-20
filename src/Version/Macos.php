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
use MacosBuild\Exception\NotFoundException;
use MacosBuild\MacosBuildInterface;
use Override;
use UnexpectedValueException;

use function array_key_exists;
use function mb_strtolower;
use function preg_match;
use function str_contains;
use function str_replace;

final readonly class Macos implements VersionFactoryInterface
{
    /** @api */
    public const array SEARCHES = ['Mac OS X Version', 'Mac OS X v', 'Mac OS X', 'OS X', 'os=mac ', 'Mac OS'];

    private const array DARWIN_MAP = [
        '/darwin\/25\.3/i' => '16.3.0',
        '/darwin\/25\.2/i' => '16.2.0',
        '/darwin\/25\.1/i' => '16.1.0',
        '/darwin\/25/i' => '16.0.0',
        '/darwin\/24\.6/i' => '15.6.0',
        '/darwin\/24\.5/i' => '15.5.0',
        '/darwin\/24\.4/i' => '15.4.0',
        '/darwin\/24\.3/i' => '15.3.0',
        '/darwin\/24\.2/i' => '15.2.0',
        '/darwin\/24\.1/i' => '15.1.0',
        '/darwin\/24/i' => '15.0.0',
        '/darwin\/23\.6/i' => '14.6.0',
        '/darwin\/23\.5/i' => '14.5.0',
        '/darwin\/23\.4/i' => '14.4.0',
        '/darwin\/23\.3/i' => '14.3.0',
        '/darwin\/23\.2/i' => '14.2.0',
        '/darwin\/23\.1/i' => '14.1.0',
        '/darwin\/23/i' => '14.0.0',
        '/darwin\/22\.6/i' => '13.5.0',
        '/darwin\/22\.5/i' => '13.4.0',
        '/darwin\/22\.4/i' => '13.3.0',
        '/darwin\/22\.3/i' => '13.2.0',
        '/darwin\/22\.2/i' => '13.1.0',
        '/darwin\/22/i' => '13.0.0',
        '/darwin\/21\.6/i' => '12.5.0',
        '/darwin\/21\.5/i' => '12.4.0',
        '/darwin\/21\.4/i' => '12.3.0',
        '/darwin\/21\.3/i' => '12.2.0',
        '/darwin\/21\.2/i' => '12.1.0',
        '/darwin\/21\.1/i' => '12.0.1',
        '/darwin\/21/i' => '12.0.0',
        '/darwin\/20\.6/i' => '11.5.0',
        '/darwin\/20\.5/i' => '11.4.0',
        '/darwin\/20\.4/i' => '11.3.0',
        '/darwin\/20\.3/i' => '11.2.0',
        '/darwin\/20\.2/i' => '11.1.0',
        '/darwin\/20/i' => '11.0.0',
        '/darwin\/19/i' => '10.15.0',
        '/darwin\/18\.[67]/i' => '10.14.6',
        '/darwin\/18\.5/i' => '10.14.5',
        '/darwin\/18\.4/i' => '10.14.4',
        '/darwin\/18\.3/i' => '10.14.3',
        '/darwin\/18\.2/i' => '10.14.2',
        '/darwin\/18\.1/i' => '10.14.1',
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

    /** @throws void */
    public function __construct(
        private VersionBuilderInterface $versionBuilder,
        private MacosBuildInterface $macosBuild,
    ) {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws UnexpectedValueException
     */
    #[Override]
    public function detectVersion(string $useragent): VersionInterface
    {
        $doMatch = preg_match(
            '/\((?:[bB]uild )?(?P<build>\d{1,2}[A-Z]\d{1,4}[a-z]?)\)/',
            $useragent,
            $matches,
        );

        if ($doMatch) {
            try {
                $buildVersion = $this->macosBuild->getVersion($matches['build']);

                return $this->versionBuilder->set($buildVersion);
            } catch (NotFoundException | NotNumericException) {
                // do nothing
            }

            return new NullVersion();
        }

        $doMatch = preg_match(
            '/coremedia v\d+\.\d+\.\d+\.(?P<build>\d+[A-Z]\d+[a-z]?)/i',
            $useragent,
            $matches,
        );

        if ($doMatch) {
            try {
                $buildVersion = $this->macosBuild->getVersion($matches['build']);
            } catch (NotFoundException) {
                $buildVersion = false;
            }

            if ($buildVersion !== false) {
                try {
                    return $this->versionBuilder->set($buildVersion);
                } catch (NotNumericException) {
                    return new NullVersion();
                }
            }
        }

        if (str_contains(mb_strtolower($useragent), 'darwin')) {
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

        try {
            $detectedVersion = $this->versionBuilder->detectVersion(
                str_replace(',', '.', $useragent),
                self::SEARCHES,
            );
        } catch (NotNumericException) {
            return new NullVersion();
        }

        $versionNumber = $detectedVersion->getVersion(VersionInterface::IGNORE_MINOR);

        if ($versionNumber !== null) {
            if (
                preg_match('/(?P<major>\d{2})(?P<minor>\d{2})(?P<micro>\d)/', $versionNumber, $versions)
            ) {
                try {
                    return $this->versionBuilder->set(
                        $versions['major'] . '.' . $versions['minor'] . '.' . $versions['micro'],
                    );
                } catch (NotNumericException) {
                    return new NullVersion();
                }
            }

            if (
                preg_match('/(?P<major>\d{2})(?P<minor>\d)(?P<micro>\d)?/', $versionNumber, $versions)
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
