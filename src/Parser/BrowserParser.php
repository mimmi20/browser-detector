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

use BrowserDetector\Loader\BrowserLoaderFactoryInterface;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use SplFileInfo;
use UaResult\Browser\BrowserInterface;
use UaResult\Engine\EngineInterface;
use UnexpectedValueException;

use function assert;
use function get_class;
use function sprintf;

final class BrowserParser implements BrowserParserInterface
{
    private const GENERIC_FILE  = __DIR__ . '/../../data/factories/browsers.json';
    private const SPECIFIC_FILE = __DIR__ . '/../../data/factories/browsers/%s.json';
    private BrowserLoaderFactoryInterface $loaderFactory;

    private RulefileParserInterface $fileParser;

    public function __construct(
        BrowserLoaderFactoryInterface $loaderFactory,
        RulefileParserInterface $fileParser
    ) {
        $this->loaderFactory = $loaderFactory;
        $this->fileParser    = $fileParser;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return array<int, (BrowserInterface|EngineInterface|null)>
     * @phpstan-return array(0: BrowserInterface, 1: EngineInterface|null)
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

        return $this->load($key, $useragent);
    }

    /**
     * @return array<int, (BrowserInterface|EngineInterface|null)>
     * @phpstan-return array(0: BrowserInterface, 1: EngineInterface|null)
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): array
    {
        $loaderFactory = $this->loaderFactory;

        $loader = $loaderFactory();
        assert($loader instanceof BrowserLoaderInterface, sprintf('$loader should be an instance of %s, but is %s', BrowserLoaderInterface::class, get_class($loader)));

        return $loader->load($key, $useragent);
    }
}
