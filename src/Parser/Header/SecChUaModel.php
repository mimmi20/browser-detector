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

use BrowserDetector\Parser\Helper\Device;
use Override;
use UaParser\DeviceCodeInterface;

use function in_array;
use function mb_strtolower;
use function mb_trim;

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
final class SecChUaModel implements DeviceCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        $value = mb_trim($value, '"\\\'');
        $code  = mb_strtolower($value);

        return !in_array($code, ['', 'model', ': ', 'some unknown model', 'k', 'android'], true);
    }

    /**
     * @return non-empty-string|null
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        $value = mb_trim($value, '"\\\'');
        $code  = mb_strtolower($value);

        return match ($code) {
            // special case
            'a065' => 'nothing-phone=nothing-phone a065',
            's61' => 'doogee=doogee s61',
            's200' => 'doogee=doogee s200',
            'p50' => 'cubot=cubot p50',
            default => (new Device())->getDeviceCode($code),
        };
    }
}
