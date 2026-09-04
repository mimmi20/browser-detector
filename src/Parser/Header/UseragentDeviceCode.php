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

use BrowserDetector\Iterator\FilterIterator;
use BrowserDetector\Parser\Helper\DeviceInterface;
use CallbackFilterIterator;
use JsonException;
use Override;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\DeviceCodeInterface;
use UaParser\DeviceParserInterface;
use UnexpectedValueException;

use function array_filter;
use function array_first;
use function array_key_exists;
use function array_key_first;
use function array_map;
use function assert;
use function explode;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function is_array;
use function is_string;
use function json_decode;
use function json_encode;
use function mb_strtolower;
use function mb_trim;
use function preg_match;
use function sprintf;
use function str_contains;
use function str_replace;

use const JSON_PRETTY_PRINT;
use const JSON_THROW_ON_ERROR;
use const PHP_EOL;

final readonly class UseragentDeviceCode implements DeviceCodeInterface
{
    /** @throws void */
    public function __construct(
        private DeviceParserInterface $deviceParser,
        private NormalizerInterface $normalizer,
        private DeviceInterface $device,
    ) {
        // nothing to do
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        return true;
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
        if (preg_match('/Android \d+; [A-Za-z0-9]{10}; U; [^;)]*\) AppleWebKit\/.+Chrome\//', $value)) {
            return 'unknown=general mobile phone';
        }

        try {
            $normalizedValue = $this->normalizer->normalize($value);
        } catch (Exception) {
            return null;
        }

        if ($normalizedValue === '' || $normalizedValue === null) {
            return null;
        }

        $matches = [];

        if (
            preg_match('/^WhatsApp\/[0-9.]+[ \/](?P<code>[ANWi])$/', $normalizedValue, $matches)
            && array_key_exists('code', $matches)
        ) {
            return match ($matches['code']) {
                'W' => 'unknown=windows desktop',
                'i' => 'apple=general apple device',
                'N' => 'apple=macintosh',
                default => 'unknown=general mobile phone',
            };
        }

        $regexes = [
            '/^mozilla\/[\d.]+ \((?:andr[o0]id|tizen) [\d.]+(?:[^;]+)?;(?: arm(?:_64)?;| harmonyos;| mobile;)? (?P<devicecode>[^;\/]+)(?:(?:\/[^ ]+)? +(?:build|hmscore))[^)]+\)/i',
            '/^mozilla\/[\d.]+ \((?:andr[o0]id|tizen) [\d.]+(?:[^;]+)?;(?: arm(?:_64)?;| harmonyos;| mobile;)? (?P<devicecode>[^);\/]+)[^)]*\)/i',
            '/^mozilla\/[\d.]+ \((?:smart-tv; )?(?:linux|andr[o0]id);(?: arm(?:_64)?;| x86;)? (?:andr[o0]id|tizen)? ?[\d.]+(?:[^;]+)?;(?: arm(?:_64)?;| harmonyos;| mobile;)? (?P<devicecode>[^;\/]+)(?:(?:\/[^ ]+)? +(?:build|hmscore))[^)]+\)/i',
            '/^mozilla\/[\d.]+ \((?:smart-tv; )?(?:linux|andr[o0]id);(?: arm(?:_64)?;| x86;)? (?:andr[o0]id|tizen)? ?[\d.]+(?:[^;]+)?;(?: arm(?:_64)?;| harmonyos;| mobile;)? (?P<devicecode>[^);\/]+)[^)]*\)/i',
            '/(?:androiddownloadmanager|mozilla|com\.[^\/]+|kodi|androidhttpclient|worksmobile|googletagmanager)\/[\d.]+ ?\(linux; (?:(?:andr[o0]id|tizen) [\d.]+(?:[^;]+)?;(?: harmonyos;)?) (?P<devicecode>[^;\/]+)(?:;? +(?:build|hmscore))[^)]+\)/i',
            '/(?:androiddownloadmanager|mozilla|com\.[^\/]+|kodi|androidhttpclient|worksmobile|googletagmanager)\/[\d.]+ ?\(linux; (?:(?:andr[o0]id|tizen) [\d.]+(?:[^;]+)?;(?: harmonyos;)?) (?P<devicecode>[^);\/]+)[^)]*\)/i',
            '/(?:androiddownloadmanager|mozilla|com\.[^\/]+|kodi|androidhttpclient|worksmobile|googletagmanager)\/[\d.]+ ?\(linux; (?:(?:andr[o0]id|tizen);(?: harmonyos;)?) (?P<devicecode>[^;\/]+)(?:;? +(?:build|hmscore))[^)]+\)/i',
            '/(?:androiddownloadmanager|mozilla|com\.[^\/]+|kodi|androidhttpclient|worksmobile|googletagmanager)\/[\d.]+ ?\(linux; (?:(?:andr[o0]id|tizen);(?: harmonyos;)?) (?P<devicecode>[^);\/]+)[^)]*\)/i',
            '/dalvik\/[\d.]+ \(linux; andr[o0]id [\d.]+(?:[^;]+)?; (?P<devicecode>[^);\/]+)(?:[);\/]?[^);\/]* +(?:build|hmscore|miui)[^)]+)\)/i',
            '/dalvik\/[\d.]+ \(linux; andr[o0]id [\d.]+(?:[^;]+)?; (?P<devicecode>[^);\/]+)(?:[);\/]?[^);\/]+)?\)/i',
            '/dalvik\/[\d.]+ \(linux; andr[o0]id [\d.]+\/viber [\d.]+ ; (?P<devicecode>[^);\/]+)[su]p1a/i',
            '/\(speedmode; proxy; android [\d.]+;(?P<devicecode>[^);\/]+)\)/i',
            '/ucweb\/[\d.]+ \((?:java; )?(?:midp-2\.0|linux); (?:adr [\d.]+;) (?P<devicecode>[^);\/]+)(?:[^)]+)?\)/i',
            '/ucweb\/[\d.]+ \((?:java; )?(?:midp-2\.0|linux); (?P<devicecode>[^);\/]+)(?:[^)]+)?\)/i',
            '/;fbdv\/(?P<devicecode>[^);\/]+);/i',
            '/slack\/[\d.]+ \((?P<devicecode>[^);\/]+)(?:;? (?:andr[o0]id|tizen) [\d.]+)(?:[^)]+)?\)/i',
            '/instagram [\d.]+ android \([\d.]+\/[\d.]+; \d+dpi; \d+x\d+; (?P<devicecode>[a-z\/]+; [^);\/]+);/i',
            '/instagram [\d.]+ android \([\d.]+\/[\d.]+; \d+dpi; \d+x\d+; [a-z\/]+; (?P<devicecode>[^);\/]+);/i',
            '/icq_android\/[\d.]+ \(android; \d+; [\d.]+; [^;]+; (?P<devicecode>[^);\/]+)/i',
            '/gg-android\/[\d.]+ \(os;android;\d+\) \([^);\/]+;[^);\/]+;(?P<devicecode>[^);\/]+);[\d.]+/i',
            '/imoandroid\/[\d.]+; \d+; REL; (?P<devicecode>[^);\/]+)/i',
            '/tivimate\/[\d.]+ \((?P<devicecode>[^);\/]+);/i',
            '/; model: (?P<devicecode>[^);\/]+)\)/i',
            '/(lbc|heart)\/[\d.]+ andr[o0]id [\d.]+\/(?P<devicecode>[^);\/]+)/i',
            '/mozilla\/[\d.]+ \(mobile; (?P<devicecode>[^;]+)(?:;android)?; rv:[^)]+\) gecko\/[\d.]+ firefox\/[\d.]+ kaios\/[\d.]+/i',
            '/mozilla\/[\d.]+ \(mobile; (?P<devicecode>[^;]+)(?:;android)?; rv:[^)]+\) gecko\/[\d.]+ firefox\/[\d.]+/i',
            '/virgin radio\/[\d.]+ \/ \(linux; andr[o0]id [\d.]+\) exoplayerlib\/[\d.]+ \/ samsung \((?P<devicecode>[^)]+)\)/i',
            '/pugpigbolt [\d.]+ \([^);\/,]+, (android|ios) [\d.]+\) on phone \(model (?P<devicecode>[^)]+)\)/i',
            '/nrc audio\/[\d.]+ \(nl\.nrc\.audio; build:[\d.]+; andr[o0]id [\d.]+; sdk:[\d.]+; manufacturer:[^;]+; model: (?P<devicecode>[^)]+)\) okhttp\/[\d.]+/i',
            '/luminary\/[\d.]+ \(andr[o0]id [\d.]+; (?P<devicecode>[^);\/]+); /i',
            '/emaudioplayer [\d.]+ \([\d.]+\) \/ andr[o0]id [\d.]+ \/ (?P<devicecode>[^);\/]+)/i',
            '/andr[o0]id [\d.]+(?:[^;]+)?; (?P<devicecode>[^);\/]+)\) applewebkit/i',
            '/classic fm\/[\d.]+ andr[o0]id [\d.]+\/(?P<devicecode>[^);\/]+)/i',
            '/mozilla\/[\d.]+ \([\d.]+mb; [\d.]+x[\d.]+; [\d.]+x[\d.]+; [\d.]+x[\d.]+; (?P<devicecode>[^);\/]+); [\d.]+\) applewebkit/i',
            '/kodi\/[\d\.a-ehlprt\-]+ \(linux; andr[o0]id [\d.]+; (?P<devicecode>[^);\/]+)(?:[);\/]?[^);\/]* +(?:build|hmscore|miui)[^)]+)\)/i',
            '/kodi\/[\d\.a-ehlprt\-]+ \(linux; andr[o0]id [\d.]+; (?P<devicecode>[^);\/]+)(?:[);\/]?[^);\/]*)\)/i',
            '/androidhttpclient \(linux; (?:(?:andr[o0]id|tizen) [\d.]+;(?: harmonyos;)?) (?P<devicecode>[^);\/]+)(?:;? +(?:build|hmscore))[^)]+\)/i',
            '/androidhttpclient \(linux; (?:(?:andr[o0]id|tizen) [\d.]+;(?: harmonyos;)?) (?P<devicecode>[^);\/]+)(?:;?)[^)]+\)/i',
            '/com\.huawei\.hmos\.browser \([^;]+;openharmony-[\d.]+;(?P<devicecode>[^)]+)\)/i',
            '/ucweb\/[\d.]+ ?\((?:midp-2\.0|linux); opera mini\/[^;]+; (?P<devicecode>[^);\/]+)(?:(?:\/[^ ]+)? +(?:build|hmscore))[^)]+\)/i',
            '/ucweb\/[\d.]+ ?\((?:midp-2\.0|linux); opera mini\/[^;]+; (?P<devicecode>[^);\/]+)/i',
            '/roku dynamic menu\/[\d.]+ \(roku [\d.]+; (?P<devicecode>[^;]+); build\/[\d.]+\)/i',
            '/roku dynamic menu\/[\d.]+ \(roku [\d.]+; (?P<devicecode>[^;]+)\)/i',
            '/snapchat\/[\d.]+ \((?P<devicecode>[^;]+); andr[o0]id [\d.]+#/i',
            '/samsung-(?P<devicecode>[^);\/]+)(?:.*)? (?:opera|netfront|build|syncml)/i',
            '/samsung-(?P<devicecode>[^);\/]+)(?:.*)?$/i',
            '/softbank\/[\d.]+\/(?P<devicecode>[^\/]+)\//i',
            '/mozilla\/[\d.]+ \(linux; os [\d.]+; (?P<devicecode>[^;\/]+) user\/(?:[^)]+)?\)/i',
            '/xbmc\/[\d\.a-ehlprt\-]+ \(linux; andr[o0]id [\d.]+; (?P<devicecode>[^);\/]+)(?:[);\/]?[^);\/]* +(?:build|hmscore|miui)[^)]+)\)/i',
            '/xbmc\/[\d\.a-ehlprt\-]+ \(linux; andr[o0]id [\d.]+; (?P<devicecode>[^);\/]+)(?:[);\/]?[^);\/]*)\)/i',
            '/mozilla\/[\d.]+ \(jig browser(?: web;|9i?| core)?(?: [\d.]+)?; (?P<devicecode>[^);]+)/i',
            '/^amazon;(?P<devicecode>[^);\/]+);/i',
            '/^smarttv_(?P<devicecode>[^);\/_]+)_build/i',
            '/^(?P<devicecode>[^);\/]+)(?:.*)? build\//i',
            '/mozilla\/[\d.]+ \(qtembedded; linux; c\) applewebkit\/[\d.]+ \(khtml, like gecko\) (?P<devicecode>[^);\/]+) stbapp ver:/i',
            '/com\.amazon\.sics\/[\d.]+ \((?P<devicecode>[^;]+); android [\d.]+;/i',
            '/bookshelf-android\/[\d.]+ \(android os\/[\d.]+; (?P<devicecode>[^);\/]+)\)/i',
            '/portalmmm\/[\d.]+ (?P<devicecode>[^);\/]+)(?:.*)?\(/i',
            '/samsung (?P<devicecode>[^);\/]+)(?:.*)? syncml_dm client/i',
            '/mozilla\/[\d.]+ \(samsung; (?P<devicecode>[^);\/]+)(?:.*)? tizen\/[\d.]+ like android;/i',
            '/goeuroandroid\/[\d.]+ \((?P<devicecode>[^);\/]+); android [\d.]+; okhttp\/[\d.]+\) webview/i',
            '/bitwarden_mobile\/[\d.]+ \(android [\d.]+; sdk [\d.]+; model (?P<devicecode>[^);\/]+)/i',
            '/amazon (?P<devicecode>[^);\/]+) kepler\/[\d.]+/i',
            '/kepler\/[\d.]+ \(linux; (?P<devicecode>[^);\/]+)\)/i',
            '/mozilla\/[\d.]+ \(linux; kepler [\d.]+; (?P<devicecode>[^);\/]+) user\/[\d.]+; wv\)/i',
            '/navermailapp\/[\d.]+ \(android [\d.]+; (?P<devicecode>[^);\/]+)\)/i',
            '/hulu\/[\d.]+ \(fire os [\d.]+ \([^)]+\);[^;]+; (?P<devicecode>[^);\/]+); build/i',
            '/(?P<devicecode>[^();\/]+)\(android\/[\d.]+\) aliapp\(aliexpress\/[\d.]+\)/i',
            '/gm-android\/[\d.]+ \([\d.]+; m:(?P<devicecode>[^();\/]+); o:[\d.]+; d:/i',
            '/mozilla\/[\d.]+ \(cloud phone [\d.]+; (?P<devicecode>[^();\/]+);/i',
            '/latina\/[\d.]+ \(android [\d.]+; (?P<devicecode>[^();\/]+)\)/i',
            '/device model: (?P<devicecode>[^);\/]+) firmware version:/i',
            '/\(lge[;,] (?P<devicecode>[^;,]+)[;,]/i',
            '/^mqqbrowser\/[\d.]+ \(linux; [\d.]+; (?P<devicecode>[^)]+)\)$/i',
            // should be the last entry in the list
            '/^(?P<devicecode>.+)$/i',
        ];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $normalizedValue),
        );

        $finds = array_map(
            static function (string $regex) use ($normalizedValue): string {
                $matches = [];

                preg_match($regex, $normalizedValue, $matches);

                return ($matches['devicecode'] ?? '')
                        |> mb_strtolower(...)
                        |> mb_trim(...);
            },
            $filtered,
        );

        $results = array_map(
            $this->device->getDeviceCode(...),
            $finds,
        );

        $results2 = array_filter(
            $results,
            is_string(...),
        );

        $code  = array_first($results2);
        $xcode = array_key_first($results2);

        if (is_string($code)) {
            if ($xcode !== null && array_key_exists($xcode, $finds) && $finds[$xcode] !== null) {
                $this->saveToMappingJson($finds[$xcode], $code);
            }

            return $code;
        }

        $matches = [];

        if (
            preg_match(
                '/dv\((?P<devicecode>[^);\/]+)(?:;? +(?:build|hmscore|miui)?[^)]+)?\);/',
                $normalizedValue,
                $matches,
            )
        ) {
            $code = $this->device->getDeviceCode(mb_trim(mb_strtolower($matches['devicecode'])));

            if (is_string($code)) {
                $this->saveToMappingJson(mb_trim(mb_strtolower($matches['devicecode'])), $code);

                return $code;
            }

            $code = $this->deviceParser->parse($matches['devicecode']);

            if ($code !== '') {
                $this->saveToMappingJson(mb_trim(mb_strtolower($matches['devicecode'])), $code);

                return $code;
            }
        }

        $code = $this->deviceParser->parse($normalizedValue);

        if ($code === '') {
            if ($xcode !== null && array_key_exists($xcode, $finds) && $finds[$xcode] !== null) {
                $this->saveToMappingJson($finds[$xcode], $code);
            }

            return null;
        }

        return $code;
    }

    /** @throws void */
    private function saveToMappingJson(string $devicecode, string $code): void
    {
        if ($code === 'A369i' || $code === 'test-device-code') {
            return;
        }

        [$company] = explode('=', $code, 2);

        if ($company === '') {
            return;
        }

        $file = sprintf('data/device-mapping/%s.json', $company);

        $devicesFromMappingFile = [];

        if (file_exists($file)) {
            try {
                $devicesFromMappingFile = json_decode(
                    (string) file_get_contents($file),
                    associative: true,
                    flags: JSON_THROW_ON_ERROR,
                );
            } catch (JsonException) {
                // do nothing
            }
        }

        if (
            !is_array($devicesFromMappingFile) || array_key_exists($devicecode, $devicesFromMappingFile)
        ) {
            return;
        }

        $devicesFromMappingFile[$devicecode] = $code;

        try {
            file_put_contents(
                $file,
                json_encode(
                    $devicesFromMappingFile,
                    JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT,
                ) . PHP_EOL,
            );
        } catch (JsonException) {
            return;
        }

        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator('../../../data/factories'),
            );
        } catch (UnexpectedValueException) {
            return;
        }

        $files = new FilterIterator($iterator, 'json');
        $files = new CallbackFilterIterator(
            $files,
            static fn (SplFileInfo $current): bool => str_contains(
                $current->getPathname(),
                $company,
            ),
        );

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            $content = @file_get_contents($filepath);

            assert($content === false || is_string($content));

            if ($content === false) {
                continue;
            }

            try {
                $fileData = json_decode($content, associative: true, flags: JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                continue;
            }

            assert(is_array($fileData));

            $newFileData = array_filter(
                $fileData,
                static fn (mixed $v): bool => is_string($v) && $v !== $code,
            );

            try {
                file_put_contents(
                    $filepath,
                    json_encode(
                        $newFileData,
                        JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT,
                    ) . PHP_EOL,
                );
            } catch (JsonException) {
                // do nothing
            }
        }
    }
}
