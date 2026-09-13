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
use Override;
use Psr\Log\LoggerInterface;
use Symfony\Component\Yaml\Yaml;

use function array_filter;
use function array_first;
use function array_key_exists;
use function assert;
use function is_array;
use function is_int;
use function is_string;
use function preg_last_error;
use function preg_last_error_msg;
use function preg_match;
use function sprintf;

use const ARRAY_FILTER_USE_KEY;

final class RulefileParser implements RulefileParserInterface
{
    /** @var array<string, array{rules?: array<string, string>, generic?: string}> */
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
            $factories = Yaml::parseFile($file);

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
