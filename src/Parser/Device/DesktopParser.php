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

namespace BrowserDetector\Parser\Device;

use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use UnexpectedValueException;

use function sprintf;

final class DesktopParser implements DesktopParserInterface
{
    private const GENERIC_FILE = __DIR__ . '/../../../data/factories/devices/desktop.json';

    private const SPECIFIC_FILE = __DIR__ . '/../../../data/factories/devices/desktop/%s.json';

    /** @throws void */
    public function __construct(
        private readonly RulefileParserInterface $fileParser,
        private readonly DeviceLoaderFactoryInterface $loaderFactory,
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
        $company = $this->fileParser->parseFile(self::GENERIC_FILE, $useragent, 'unknown');

        $key = $this->fileParser->parseFile(
            sprintf(self::SPECIFIC_FILE, $company),
            $useragent,
            'unknown',
        );

        return $company . '=' . $key;
    }

    /**
     * @return array<int, (array<mixed>|bool|string|null)>
     * @phpstan-return array{0:array{deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, dualOrientation: bool|null, simCount: int|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, type: string, ismobile: bool, istv: bool}, 1:string|null}
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $company, string $key): array
    {
        $loaderFactory = $this->loaderFactory;
        $loader        = $loaderFactory($company);

        return $loader->load($key);
    }
}
