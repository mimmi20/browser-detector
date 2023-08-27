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

use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use UnexpectedValueException;

use function sprintf;

final class PlatformParser implements PlatformParserInterface
{
    private const GENERIC_FILE = __DIR__ . '/../../data/factories/platforms.json';

    private const SPECIFIC_FILE = __DIR__ . '/../../data/factories/platforms/%s.json';

    /** @throws void */
    public function __construct(
        private readonly PlatformLoaderInterface $loader,
        private readonly RulefileParserInterface $fileParser,
    ) {
        // nothing to do
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @throws void
     */
    public function parse(string $useragent): string
    {
        $mode = $this->fileParser->parseFile(self::GENERIC_FILE, $useragent, 'unknown');

        return $this->fileParser->parseFile(
            sprintf(self::SPECIFIC_FILE, $mode),
            $useragent,
            'unknown',
        );
    }

    /**
     * @return array{name: string|null, marketingName: string|null, version: string|null, manufacturer: string, bits: int|null}
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): array
    {
        return $this->loader->load($key, $useragent);
    }
}
