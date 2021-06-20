<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Device;

use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use SplFileInfo;
use UaResult\Device\DeviceInterface;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function sprintf;

final class DarwinParser implements DarwinParserInterface
{
    private const GENERIC_FILE  = __DIR__ . '/../../../data/factories/devices/darwin.json';
    private const SPECIFIC_FILE = __DIR__ . '/../../../data/factories/devices/%s/apple.json';
    private DeviceLoaderFactoryInterface $loaderFactory;

    private RulefileParserInterface $fileParser;

    public function __construct(RulefileParserInterface $fileParser, DeviceLoaderFactoryInterface $loaderFactory)
    {
        $this->loaderFactory = $loaderFactory;
        $this->fileParser    = $fileParser;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return array<int, (OsInterface|DeviceInterface|null)>
     * @phpstan-return array(0:DeviceInterface, 1:OsInterface|null)
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function parse(string $useragent): array
    {
        $mode = $this->fileParser->parseFile(
            new SplFileInfo(self::GENERIC_FILE),
            $useragent,
            'unknown'
        );

        $key = $this->fileParser->parseFile(
            new SplFileInfo(sprintf(self::SPECIFIC_FILE, $mode)),
            $useragent,
            'unknown'
        );

        return $this->load('apple', $key, $useragent);
    }

    /**
     * @return array<int, (OsInterface|DeviceInterface|null)>
     * @phpstan-return array(0:DeviceInterface, 1:OsInterface|null)
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
