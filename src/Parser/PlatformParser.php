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

namespace BrowserDetector\Parser;

use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoaderFactoryInterface;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function sprintf;

final class PlatformParser implements PlatformParserInterface
{
    private const GENERIC_FILE  = __DIR__ . '/../../data/factories/platforms.json';
    private const SPECIFIC_FILE = __DIR__ . '/../../data/factories/platforms/%s.json';
    private PlatformLoaderFactoryInterface $loaderFactory;

    private RulefileParserInterface $fileParser;

    public function __construct(
        PlatformLoaderFactoryInterface $loaderFactory,
        RulefileParserInterface $fileParser
    ) {
        $this->loaderFactory = $loaderFactory;
        $this->fileParser    = $fileParser;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function parse(string $useragent): OsInterface
    {
        $mode = $this->fileParser->parseFile(
            self::GENERIC_FILE,
            $useragent,
            'unknown'
        );

        $key = $this->fileParser->parseFile(
            sprintf(self::SPECIFIC_FILE, $mode),
            $useragent,
            'unknown'
        );

        return $this->load($key, $useragent);
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): OsInterface
    {
        $loaderFactory = $this->loaderFactory;
        $loader        = $loaderFactory();

        return $loader->load($key, $useragent);
    }
}
