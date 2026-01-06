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

namespace BrowserDetector\Parser;

use BrowserDetector\Data\Engine;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use Override;
use UaData\EngineInterface;
use UaParser\EngineParserInterface;
use UnexpectedValueException;

final readonly class EngineParser implements EngineParserInterface
{
    private const string GENERIC_FILE = __DIR__ . '/../../data/factories/engines.json';

    /** @throws void */
    public function __construct(private RulefileParserInterface $fileParser)
    {
        // nothing to do
    }

    /**
     * Gets the information about the engine by User Agent
     *
     * @throws void
     */
    #[Override]
    public function parse(string $useragent): EngineInterface
    {
        $code = $this->fileParser->parseFile(self::GENERIC_FILE, $useragent, 'unknown');

        try {
            return Engine::fromName($code);
        } catch (UnexpectedValueException) {
            return Engine::unknown;
        }
    }
}
