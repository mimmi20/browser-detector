<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Header;

use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\NormalizerFactory;

use function in_array;
use function mb_strtolower;
use function preg_match;

final class XOperaminiPhoneUa implements HeaderInterface
{
    use HeaderTrait;

    private readonly string $normalizedValue;

    /** @throws Exception */
    public function __construct(
        string $value,
        private readonly DeviceParserInterface $deviceParser,
        private readonly EngineParserInterface $engineParser,
        private readonly NormalizerFactory $normalizerFactory,
    ) {
        $this->value = $value;

        $normalizer = $this->normalizerFactory->build();

        $this->normalizedValue = $normalizer->normalize($value);
    }

    /** @throws void */
    public function hasDeviceCode(): bool
    {
        if (in_array(mb_strtolower($this->value), ['mozilla/5.0 (bada 2.0.0)', 'motorola'], true)) {
            return false;
        }

        return (bool) preg_match(
            '/samsung|nokia|blackberry|smartfren|sprint|iphone|lava|gionee|philips|htc|pantech|lg|casio|zte|mi 2sc|sm-g900f|gt-i9000|gt-s5830i|sne-lx1/i',
            $this->value,
        );
    }

    /** @throws void */
    public function getDeviceCode(): string | null
    {
        $code = $this->deviceParser->parse($this->normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }

    /** @throws void */
    public function hasClientCode(): bool
    {
        return (bool) preg_match('/opera mini/i', $this->value);
    }

    /** @throws void */
    public function getClientCode(): string
    {
        return 'opera mini';
    }

    /** @throws void */
    public function hasClientVersion(): bool
    {
        return (bool) preg_match('/opera mini\/[\d\.]+/i', $this->value);
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getClientVersion(string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/opera mini\/(?P<version>[\d\.]+)/i', $this->value, $matches)) {
            return $matches['version'];
        }

        return null;
    }

    /** @throws void */
    public function hasPlatformCode(): bool
    {
        return (bool) preg_match(
            '/bada|android|blackberry|brew|iphone|mre|windows|mtk/i',
            $this->value,
        );
    }

    /** @throws void */
    public function getPlatformCode(): string | null
    {
        $matches = [];

        if (
            preg_match(
                '/(?P<platform>bada|android|blackberry|brew|iphone|mre|windows( ce)?|mtk)/i',
                $this->value,
                $matches,
            )
            && isset($matches['platform'])
        ) {
            $code = mb_strtolower($matches['platform']);

            return match ($code) {
                'bada', 'android', 'brew', 'mre', 'windows ce' => $code,
                'blackberry' => 'rim os',
                'windows' => 'windows phone',
                'iphone' => 'ios',
                'mtk' => 'nucleus os',
                default => null,
            };
        }

        return null;
    }

    /** @throws void */
    public function hasEngineCode(): bool
    {
        return (bool) preg_match('/trident|presto|webkit|gecko/i', $this->value);
    }

    /** @throws void */
    public function getEngineCode(string | null $code = null): string | null
    {
        $code = $this->engineParser->parse($this->normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
