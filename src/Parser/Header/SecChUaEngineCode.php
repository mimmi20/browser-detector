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

use BrowserDetector\Data\Engine;
use Override;
use UaData\EngineInterface;
use UaParser\EngineCodeInterface;
use UnexpectedValueException;

use function mb_strtolower;
use function preg_match;

final class SecChUaEngineCode implements EngineCodeInterface
{
    use SortTrait;

    /** @throws void */
    #[Override]
    public function hasEngineCode(string $value): bool
    {
        return $this->sortForEngine($value) !== [];
    }

    /** @throws void */
    #[Override]
    public function getEngineCode(string $value): EngineInterface
    {
        $list = $this->sortForEngine($value);

        if ($list === []) {
            return Engine::unknown;
        }

        $key  = array_key_first($list);
        $code = mb_strtolower($key);

        return match ($code) {
            'safari' => Engine::webkit,
            'total browser', 'wavebrowser' => Engine::unknown,
            default => Engine::blink,
        };
    }
}
