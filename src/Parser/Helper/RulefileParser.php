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
use JsonClass\DecodeErrorException;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;
use SplFileInfo;

use function array_keys;
use function assert;
use function file_get_contents;
use function is_array;
use function is_int;
use function preg_last_error;
use function preg_match;
use function sprintf;

final class RulefileParser implements RulefileParserInterface
{
    private JsonInterface $jsonParser;

    private LoggerInterface $logger;

    public function __construct(JsonInterface $jsonParser, LoggerInterface $logger)
    {
        $this->jsonParser = $jsonParser;
        $this->logger     = $logger;
    }

    public function parseFile(SplFileInfo $file, string $useragent, string $fallback): string
    {
        $content = @file_get_contents($file->getPathname());

        if (false === $content) {
            $this->logger->error(
                new Exception(sprintf('could not load file %s', $file->getPathname()))
            );

            $mode  = $fallback;
            $rules = [];
        } else {
            try {
                $factories = $this->jsonParser->decode(
                    $content,
                    true
                );

                assert(is_array($factories));

                $mode  = $factories['generic'] ?? $fallback;
                $rules = $factories['rules'] ?? [];
            } catch (DecodeErrorException $e) {
                $this->logger->error(
                    new Exception(sprintf('could not decode content of file %s', $file->getPathname()), 0, $e)
                );

                $mode  = $fallback;
                $rules = [];
            }
        }

        foreach (array_keys($rules) as $rule) {
            if (is_int($rule)) {
                $this->logger->error(
                    new Exception(sprintf('invalid rule "%s" found in file %s', $rule, $file->getPathname()))
                );
                continue;
            }

            $match = @preg_match($rule, $useragent);

            if (false === $match) {
                $error = preg_last_error();
                $this->logger->error(
                    new Exception(sprintf('could not match rule "%s" of file %s: %s', $rule, $file->getPathname(), $error))
                );
            } elseif (0 < $match) {
                $mode = $rules[$rule];
                break;
            }
        }

        return $mode;
    }
}
