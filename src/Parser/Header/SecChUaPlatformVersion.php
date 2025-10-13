<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Header;

use BrowserDetector\Parser\Header\Exception\VersionContainsDerivateException;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\VersionInterface;
use Override;
use UaParser\PlatformVersionInterface;

use function assert;
use function is_int;
use function mb_strpos;
use function mb_strtolower;
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
    public function getPlatformVersion(string $value, string | null $code = null): VersionInterface
    {
        $value = mb_trim($value, '"\\\'');

        if ($value === '') {
            return new ForcedNullVersion();
        }

        if ($code === null || mb_strtolower($code) !== 'windows') {
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

        $windowsVersion = (float) $value;

        if ($windowsVersion < 1) {
            $windowsVersion      = (int) ($windowsVersion * 10);
            $minorVersionMapping = [1 => '7', 2 => '8', 3 => '8.1'];

            return $this->setVersion($minorVersionMapping[$windowsVersion] ?? $value);
        }

        if ($windowsVersion < 11) {
            return $this->setVersion('10');
        }

        return $this->setVersion('11');
    }
}
