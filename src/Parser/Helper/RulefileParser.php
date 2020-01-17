<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Parser\Helper;

use ExceptionalJSON\DecodeErrorException;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;

final class RulefileParser implements RulefileParserInterface
{
    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \JsonClass\JsonInterface $jsonParser
     * @param LoggerInterface          $logger
     */
    public function __construct(JsonInterface $jsonParser, LoggerInterface $logger)
    {
        $this->jsonParser = $jsonParser;
        $this->logger     = $logger;
    }

    /**
     * @param \SplFileInfo $file
     * @param string       $useragent
     * @param string       $fallback
     *
     * @return string
     */
    public function parseFile(\SplFileInfo $file, string $useragent, string $fallback): string
    {
        $content = @file_get_contents($file->getPathname());

        if (false === $content) {
            $this->logger->error(
                new \Exception(sprintf('could not load file %s', $file->getPathname()))
            );

            $mode  = $fallback;
            $rules = [];
        } else {
            try {
                $factories = $this->jsonParser->decode(
                    $content,
                    true
                );

                $mode  = $factories['generic'] ?? $fallback;
                $rules = $factories['rules'] ?? [];
            } catch (DecodeErrorException $e) {
                $this->logger->error(
                    new \Exception(sprintf('could not decode content of file %s', $file->getPathname()), 0, $e)
                );

                $mode  = $fallback;
                $rules = [];
            }
        }

        foreach (array_keys($rules) as $rule) {
            $match = @preg_match($rule, $useragent);

            if (false === $match) {
                $error = preg_last_error();
                $this->logger->error(
                    new \Exception(sprintf('could not match rule "%s" of file %s: %s', $rule, $file->getPathname(), $error))
                );
            } elseif (0 < $match) {
                $mode = $rules[$rule];
                break;
            }
        }

        return $mode;
    }
}
