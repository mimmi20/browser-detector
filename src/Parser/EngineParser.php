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

namespace BrowserDetector\Parser;

use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use UnexpectedValueException;

final class EngineParser implements EngineParserInterface
{
    private const GENERIC_FILE = __DIR__ . '/../../data/factories/engines.json';

    /** @throws void */
    public function __construct(
        private readonly EngineLoaderInterface $loader,
        private readonly RulefileParserInterface $fileParser,
    ) {
        // nothing to do
    }

    /**
     * Gets the information about the engine by User Agent
     *
     * @throws void
     */
    public function parse(string $useragent): string
    {
        return $this->fileParser->parseFile(self::GENERIC_FILE, $useragent, 'unknown');
    }

    /**
     * @return array{name: string|null, version: string|null, manufacturer: string}
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): array
    {
        return $this->loader->load($key, $useragent);
    }
}
