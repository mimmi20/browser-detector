<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Parser\Helper;

use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\SplFileInfo;

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
     * @param \Symfony\Component\Finder\SplFileInfo $file
     * @param string                                $useragent
     * @param string                                $fallback
     *
     * @return string
     */
    public function parseFile(SplFileInfo $file, string $useragent, string $fallback): string
    {
        try {
            $factories = $this->jsonParser->decode(
                $file->getContents(),
                true
            );

            $mode  = $factories['generic'] ?? $fallback;
            $rules = $factories['rules'] ?? [];
        } catch (\Throwable $e) {
            $this->logger->error($e);

            $mode  = $fallback;
            $rules = [];
        }

        foreach (array_keys($rules) as $rule) {
            if (preg_match($rule, $useragent)) {
                $mode = $rules[$rule];
                break;
            }
        }

        return $mode;
    }
}
