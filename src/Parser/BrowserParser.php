<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Parser;

use BrowserDetector\Loader\BrowserLoaderFactoryInterface;
use BrowserDetector\Parser\Helper\RulefileParserInterface;

final class BrowserParser implements BrowserParserInterface
{
    /**
     * @var \BrowserDetector\Loader\BrowserLoaderFactoryInterface
     */
    private $loaderFactory;

    /**
     * @var \BrowserDetector\Parser\Helper\RulefileParserInterface
     */
    private $fileParser;

    private const GENERIC_FILE  = __DIR__ . '/../../data/factories/browsers.json';
    private const SPECIFIC_FILE = __DIR__ . '/../../data/factories/browsers/%s.json';

    /**
     * BrowserParser constructor.
     *
     * @param \BrowserDetector\Loader\BrowserLoaderFactoryInterface  $loaderFactory
     * @param \BrowserDetector\Parser\Helper\RulefileParserInterface $fileParser
     */
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
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
     * @return array
     */
    public function parse(string $useragent): array
    {
        $mode = $this->fileParser->parseFile(
            new \SplFileInfo(self::GENERIC_FILE),
            $useragent,
            'unknown'
        );

        $key = $this->fileParser->parseFile(
            new \SplFileInfo(sprintf(self::SPECIFIC_FILE, $mode)),
            $useragent,
            'unknown'
        );

        return $this->load($key, $useragent);
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
     * @return array
     */
    public function load(string $key, string $useragent = ''): array
    {
        $loaderFactory = $this->loaderFactory;

        /** @var \BrowserDetector\Loader\BrowserLoader $loader */
        $loader = $loaderFactory();

        return $loader->load($key, $useragent);
    }
}
