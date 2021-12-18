<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Helper;

use Exception;
use JsonException;
use Psr\Log\LoggerInterface;

use function array_keys;
use function assert;
use function file_get_contents;
use function is_array;
use function is_int;
use function json_decode;
use function preg_last_error;
use function preg_match;
use function sprintf;

use const JSON_THROW_ON_ERROR;

final class RulefileParser implements RulefileParserInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function parseFile(string $file, string $useragent, string $fallback): string
    {
        $content = @file_get_contents($file);

        if (false === $content) {
            $this->logger->error(
                new Exception(sprintf('could not load file %s', $file))
            );

            $mode  = $fallback;
            $rules = [];
        } else {
            try {
                $factories = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

                assert(is_array($factories));

                $mode  = $factories['generic'] ?? $fallback;
                $rules = $factories['rules'] ?? [];
            } catch (JsonException $e) {
                $this->logger->error(
                    new Exception(sprintf('could not decode content of file %s', $file), 0, $e)
                );

                $mode  = $fallback;
                $rules = [];
            }
        }

        foreach (array_keys($rules) as $rule) {
            if (is_int($rule)) {
                $this->logger->error(
                    new Exception(sprintf('invalid rule "%s" found in file %s', $rule, $file))
                );
                continue;
            }

            $match = @preg_match($rule, $useragent);

            if (false === $match) {
                $error = preg_last_error();
                $this->logger->error(
                    new Exception(sprintf('could not match rule "%s" of file %s: %s', $rule, $file, $error))
                );
            } elseif (0 < $match) {
                $mode = $rules[$rule];
                break;
            }
        }

        return $mode;
    }
}
