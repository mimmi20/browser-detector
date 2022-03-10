<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser;

use BrowserDetector\Loader\EngineLoaderFactoryInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use UaResult\Engine\EngineInterface;
use UnexpectedValueException;

final class EngineParser implements EngineParserInterface
{
    private const GENERIC_FILE = __DIR__ . '/../../data/factories/engines.json';
    private EngineLoaderFactoryInterface $loaderFactory;

    private RulefileParserInterface $fileParser;

    public function __construct(
        EngineLoaderFactoryInterface $loaderFactory,
        RulefileParserInterface $fileParser
    ) {
        $this->loaderFactory = $loaderFactory;
        $this->fileParser    = $fileParser;
    }

    /**
     * Gets the information about the engine by User Agent
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function parse(string $useragent): EngineInterface
    {
        $key = $this->fileParser->parseFile(
            self::GENERIC_FILE,
            $useragent,
            'unknown'
        );

        return $this->load($key, $useragent);
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): EngineInterface
    {
        $loaderFactory = $this->loaderFactory;
        $loader        = $loaderFactory();

        return $loader->load($key, $useragent);
    }
}
