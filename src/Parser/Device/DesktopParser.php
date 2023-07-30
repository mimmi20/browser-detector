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
use UaResult\Device\DeviceInterface;
use UaResult\Os\OsInterface;
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
     * @return array<int, (DeviceInterface|OsInterface|null)>
     * @phpstan-return array{0:DeviceInterface, 1:OsInterface|null}
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function parse(string $useragent): array
    {
        $mode = $this->fileParser->parseFile(self::GENERIC_FILE, $useragent, 'unknown');

        $key = $this->fileParser->parseFile(
            sprintf(self::SPECIFIC_FILE, $mode),
            $useragent,
            'unknown',
        );

        return $this->load($mode, $key, $useragent);
    }

    /**
     * @return array<int, (DeviceInterface|OsInterface|null)>
     * @phpstan-return array{0:DeviceInterface, 1:OsInterface|null}
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $company, string $key, string $useragent = ''): array
    {
        $loaderFactory = $this->loaderFactory;
        $loader        = $loaderFactory($company);

        return $loader->load($key, $useragent);
    }
}
