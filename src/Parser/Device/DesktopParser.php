<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Device;

use BrowserDetector\Parser\Helper\RulefileParserInterface;
use Override;

use function sprintf;

final readonly class DesktopParser implements DesktopParserInterface
{
    private const string GENERIC_FILE = __DIR__ . '/../../../data/factories/devices/desktop.json';

    private const string SPECIFIC_FILE = __DIR__ . '/../../../data/factories/devices/desktop/%s.json';

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
        $company = $this->fileParser->parseFile(self::GENERIC_FILE, $useragent, 'unknown');

        $key = $this->fileParser->parseFile(
            sprintf(self::SPECIFIC_FILE, $company),
            $useragent,
            'unknown',
        );

        return $company . '=' . $key;
    }
}
