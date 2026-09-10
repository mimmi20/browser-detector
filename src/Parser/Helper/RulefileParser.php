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

namespace BrowserDetector\Parser\Helper;

use Exception;
use JsonException;
use Override;
use Psr\Log\LoggerInterface;

use Symfony\Component\Yaml\Yaml;
use function array_filter;
use function array_first;
use function array_key_exists;
use function assert;
use function file_get_contents;
use function is_array;
use function is_int;
use function is_string;
use function json_decode;
use function preg_last_error;
use function preg_last_error_msg;
use function preg_match;
use function sprintf;

use function str_ends_with;
use const ARRAY_FILTER_USE_KEY;
use const JSON_THROW_ON_ERROR;

final class RulefileParser implements RulefileParserInterface
{
    /**
     * @var array<string, array{rules?: array<string, string>, generic?: string}>
     */
    private array $factories = [];

    /** @throws void */
    public function __construct(private readonly LoggerInterface $logger)
    {
        // nothing to do
    }

    /** @throws void */
    #[Override]
    public function parseFile(string $file, string $useragent, string $fallback): string
    {
        if (array_key_exists($file, $this->factories)) {
            $factories = $this->factories[$file];
        } else {
            $jsonFile = str_replace('yaml', 'json', $file);

            if (str_ends_with($file, 'yaml') && file_exists($file)) {
                $factories = Yaml::parseFile($file);

                if (file_exists($jsonFile)) {
                    unlink($jsonFile);
                }
            } elseif (str_ends_with($file, 'yaml') && !file_exists($file)) {
                $content = @file_get_contents($jsonFile);

                if ($content === false) {
                    $this->logger->error(
                        new Exception(sprintf('could not load file %s', $jsonFile)),
                    );

                    return $fallback;
                }

                try {
                    $factories = json_decode(json: $content, associative: true, flags: JSON_THROW_ON_ERROR);
                } catch (JsonException $e) {
                    $this->logger->error(
                        new Exception(sprintf('could not decode content of file %s', $file), 0, $e),
                    );

                    return $fallback;
                }

                file_put_contents($file, Yaml::dump($factories, 4, 2));

                echo $file, " rewritten to yaml", PHP_EOL;

                unlink($jsonFile);
            } else {
                return $fallback;
            }

            $this->factories[$file] = $factories;
        }

        assert(is_array($factories));
        $rules = $factories['rules'] ?? [];
        $mode  = null;

        if (is_array($rules)) {
            $mode = $this->getModeFromRules($rules, $file, $useragent);
        }

        if (!is_string($mode) && array_key_exists('generic', $factories)) {
            $mode = $factories['generic'];
        }

        if (!is_string($mode)) {
            return $fallback;
        }

        return $mode;
    }

    /**
     * @param array<int|string, string> $rules
     *
     * @throws void
     */
    private function getModeFromRules(array $rules, string $file, string $useragent): string | false
    {
        $filtered = array_filter(
            array: $rules,
            callback: function (string | int $rule) use ($file, $useragent): bool {
                if (is_int($rule)) {
                    $this->logger->error(
                        new Exception(
                            sprintf('invalid numeric rule "%s" found in file %s', $rule, $file),
                        ),
                    );

                    return false;
                }

                $match = @preg_match($rule, $useragent);

                if ($match === false) {
                    $error = preg_last_error();
                    $msg   = preg_last_error_msg();

                    $this->logger->error(
                        new Exception(
                            sprintf(
                                'could not match rule "%s" of file %s with useragent "%s": %s [%s]',
                                $rule,
                                $file,
                                $useragent,
                                $msg,
                                $error,
                            ),
                        ),
                    );
                }

                return $match === 1;
            },
            mode: ARRAY_FILTER_USE_KEY,
        );

        if ($filtered !== []) {
            return array_first($filtered);
        }

        return false;
    }
}
