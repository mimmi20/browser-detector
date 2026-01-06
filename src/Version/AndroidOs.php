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
use Override;
use UnexpectedValueException;

use function mb_stripos;
use function preg_match;

final readonly class AndroidOs implements VersionFactoryInterface
{
    /** @api */
    public const array SEARCHES = [
        'android android',
        'android androidhouse team',
        'android wildpuzzlerom v8 froyo',
        'juc ?\(linux;',
        'linux; googletv',
        'android ouya',
        'android os',
        '(?<!o)andr[0o]id[;_ ]',
        '(?<!o)andr[0o]id\/',
        '(?<!o)andr[0o]id',
        'adr ',
        '\(os: ',
        'platform:server_android,osversion:',
    ];

    /** @throws void */
    public function __construct(private VersionBuilderInterface $versionBuilder)
    {
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
        if (mb_stripos($useragent, 'android 2.1-update1') !== false) {
            try {
                return $this->versionBuilder->set('2.1.1');
            } catch (NotNumericException) {
                // do nothing here
            }
        }

        if (mb_stripos($useragent, 'android m;') !== false) {
            try {
                return $this->versionBuilder->set('6.0');
            } catch (NotNumericException) {
                // do nothing here
            }
        }

        if (preg_match('/Linux; Android (?P<version>\d+[\d\.]*);/', $useragent, $matches)) {
            try {
                return $this->versionBuilder->set($matches['version']);
            } catch (NotNumericException) {
                // do nothing here
            }
        }

        if (preg_match('/Android API (?:Level\: )?(?P<version>\d+)/', $useragent, $matches)) {
            try {
                return $this->versionBuilder->set($this->mapSdkVersion($matches['version']));
            } catch (NotNumericException) {
                // do nothing here
            }
        }

        if (preg_match('/(?P<version>\d+)\/tclwebkit\d+[\.\d]*/', $useragent, $matches)) {
            try {
                return $this->versionBuilder->set($this->mapSdkVersion($matches['version']));
            } catch (NotNumericException) {
                // do nothing here
            }
        }

        if (preg_match('/Android \(\d+\/(?P<version>\d+[\d\.]+)/', $useragent, $matches)) {
            try {
                return $this->versionBuilder->set($matches['version']);
            } catch (NotNumericException) {
                // do nothing here
            }
        }

        try {
            $detectedVersion = $this->versionBuilder->detectVersion($useragent, self::SEARCHES);
        } catch (NotNumericException) {
            return new NullVersion();
        }

        if ($detectedVersion->getVersion() !== null) {
            return $detectedVersion;
        }

        if (preg_match('/Linux; (?P<version>\d+[\d\.]+)/', $useragent, $matches)) {
            try {
                return $this->versionBuilder->set($matches['version']);
            } catch (NotNumericException) {
                // do nothing
            }
        }

        if (mb_stripos($useragent, 'gingerbread') !== false) {
            try {
                return $this->versionBuilder->set('2.3.0');
            } catch (NotNumericException) {
                // do nothing
            }
        }

        if (mb_stripos($useragent, 'android eclair') !== false) {
            try {
                return $this->versionBuilder->set('2.1.0');
            } catch (NotNumericException) {
                // do nothing
            }
        }

        return new NullVersion();
    }

    /** @throws void */
    private function mapSdkVersion(string $sdkVersion): string
    {
        return match ($sdkVersion) {
            '35' => '15',
            '34' => '14',
            '33' => '13',
            '32' => '12.1',
            '31' => '12',
            '30' => '11',
            '29' => '10',
            '28' => '9',
            '27' => '8.1',
            '26' => '8',
            '25' => '7.1',
            '24' => '7',
            '23' => '6',
            '22' => '5.1',
            '21' => '5',
            '20', '19' => '4.4',
            '18' => '4.3',
            '17', '16' => '4.2',
            '15' => '4.0.3',
            default => '0',
        };
    }
}
