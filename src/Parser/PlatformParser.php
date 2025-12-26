<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser;

use BrowserDetector\Data\Os;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use Override;
use UaData\OsInterface;
use UaParser\PlatformParserInterface;
use UnexpectedValueException;

use function sprintf;

final readonly class PlatformParser implements PlatformParserInterface
{
    private const string GENERIC_FILE = __DIR__ . '/../../data/factories/platforms.json';

    private const string SPECIFIC_FILE = __DIR__ . '/../../data/factories/platforms/%s.json';

    /** @throws void */
    public function __construct(private RulefileParserInterface $fileParser)
    {
        // nothing to do
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @throws void
     */
    #[Override]
    public function parse(string $useragent): OsInterface
    {
        $mode = $this->fileParser->parseFile(self::GENERIC_FILE, $useragent, 'unknown');

        $code = $this->fileParser->parseFile(
            sprintf(self::SPECIFIC_FILE, $mode),
            $useragent,
            'unknown',
        );

        try {
            return Os::fromName($code);
        } catch (UnexpectedValueException) {
            return Os::unknown;
        }
    }
}
