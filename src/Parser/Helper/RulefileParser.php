<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Helper;

use Exception;
use JsonException;
use Psr\Log\LoggerInterface;

use function array_key_exists;
use function array_keys;
use function assert;
use function file_get_contents;
use function is_array;
use function is_int;
use function is_string;
use function json_decode;
use function preg_last_error;
use function preg_match;
use function sprintf;

use const JSON_THROW_ON_ERROR;

final class RulefileParser implements RulefileParserInterface
{
    /** @throws void */
    public function __construct(private readonly LoggerInterface $logger)
    {
        // nothing to do
    }

    /** @throws void */
    public function parseFile(string $file, string $useragent, string $fallback): string
    {
        if (!file_exists($file)) {
            $this->logger->error(
                new Exception(sprintf('file %s does not exist', $file)),
            );

            return $fallback;
        }

        $content = @file_get_contents($file);
        $mode    = null;

        if ($content === false) {
            $this->logger->error(
                new Exception(sprintf('could not load file %s', $file)),
            );

            return $fallback;
        }

        try {
            $factories = json_decode(json: $content, associative: true, flags: JSON_THROW_ON_ERROR);

            assert(is_array($factories));

            $rules = $factories['rules'] ?? [];
        } catch (JsonException $e) {
            $this->logger->error(
                new Exception(sprintf('could not decode content of file %s', $file), 0, $e),
            );

            return $fallback;
        }

        if (is_array($rules)) {
             $mode = $this->getModeFromRules($rules, $file, $useragent);
        }

        if (!is_string($mode) && array_key_exists('generic', $factories)) {
            $mode = $factories['generic'];
        }

        if (!is_string($mode)) {
            $mode = $fallback;
        }

        return $mode;
    }

    /**
     * @param array<int|string, string> $rules
     *
     * @throws void
     */
    private function getModeFromRules(array $rules, string $file, string $useragent): string | null
    {
        $mode = null;

        foreach (array_keys($rules) as $rule) {
            if (is_int($rule)) {
                $this->logger->error(
                    new Exception(sprintf('invalid numeric rule "%s" found in file %s', $rule, $file)),
                );

                continue;
            }

            $match = @preg_match($rule, $useragent);

            if ($match === false) {
                $error = preg_last_error();
                $this->logger->error(
                    new Exception(
                        sprintf('could not match rule "%s" of file %s: %s', $rule, $file, $error),
                    ),
                );

                continue;
            }

            if ($match) {
                $mode = $rules[$rule];

                break;
            }
        }

        return $mode;
    }
}
