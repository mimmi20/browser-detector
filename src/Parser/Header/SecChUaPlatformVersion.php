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

namespace BrowserDetector\Parser\Header;

use BrowserDetector\Data\Os;
use BrowserDetector\Parser\Header\Exception\VersionContainsDerivateException;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\VersionInterface;
use Deprecated;
use Override;
use UaData\OsInterface;
use UaParser\PlatformVersionInterface;
use UnexpectedValueException;

use function assert;
use function is_int;
use function mb_strpos;
use function mb_substr;
use function mb_trim;

final class SecChUaPlatformVersion implements PlatformVersionInterface
{
    use SetVersionTrait;

    /** @throws void */
    #[Override]
    public function hasPlatformVersion(string $value): bool
    {
        $value = mb_trim($value, '"\\\'');

        return $value !== '';
    }

    /** @throws VersionContainsDerivateException */
    #[Override]
    #[Deprecated(message: 'use getPlatformVersionWithOs() instead', since: '10.0.27')]
    public function getPlatformVersion(string $value, string | null $code = null): VersionInterface
    {
        try {
            $os = Os::fromName((string) $code);
        } catch (UnexpectedValueException) {
            $os = Os::unknown;
        }

        return $this->getVersion($value, $os);
    }

    /** @throws VersionContainsDerivateException */
    #[Override]
    public function getPlatformVersionWithOs(string $value, OsInterface $os): VersionInterface
    {
        return $this->getVersion($value, $os);
    }

    /** @throws VersionContainsDerivateException */
    private function getVersion(string $value, OsInterface $os): VersionInterface
    {
        $value = mb_trim($value, '"\\\'');

        if ($value === '') {
            return new ForcedNullVersion();
        }

        if ($os === Os::windows) {
            $version = match ((float) $value) {
                0.1, 6.1 => '7',
                0.2 => '8',
                0.3 => '8.1',
                10.0 => '10',
                default => '11',
            };

            return $this->setVersion($version);
        }

        $derivatePosition = mb_strpos($value, ';');

        assert($derivatePosition === false || is_int($derivatePosition));

        if ($derivatePosition !== false) {
            $derivate = mb_trim(mb_substr($value, $derivatePosition + 1));

            $exception = new VersionContainsDerivateException();
            $exception->setDerivate($derivate);

            throw $exception;
        }

        return $this->setVersion($value);
    }
}
