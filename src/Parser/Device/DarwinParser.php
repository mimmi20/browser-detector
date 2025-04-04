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

namespace BrowserDetector\Parser\Device;

use BrowserDetector\Parser\Helper\RulefileParserInterface;
use Override;

use function sprintf;

final readonly class DarwinParser implements DarwinParserInterface
{
    private const string GENERIC_FILE = __DIR__ . '/../../../data/factories/devices/darwin.json';

    private const string SPECIFIC_FILE = __DIR__ . '/../../../data/factories/devices/%s/apple.json';

    /** @throws void */
    public function __construct(private RulefileParserInterface $fileParser)
    {
        // nothing to do
    }

    /**
     * Gets the information about the device by User Agent
     *
     * @return non-empty-string
     *
     * @throws void
     */
    #[Override]
    public function parse(string $useragent): string
    {
        $mode = $this->fileParser->parseFile(self::GENERIC_FILE, $useragent, 'unknown');

        $key = $this->fileParser->parseFile(
            sprintf(self::SPECIFIC_FILE, $mode),
            $useragent,
            'unknown',
        );

        return 'apple=' . $key;
    }
}
