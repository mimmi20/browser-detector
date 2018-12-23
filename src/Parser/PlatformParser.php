<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Parser;

use BrowserDetector\Loader\PlatformLoaderFactoryInterface;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use Symfony\Component\Finder\SplFileInfo;
use UaResult\Os\OsInterface;

final class PlatformParser implements PlatformParserInterface
{
    /**
     * @var \BrowserDetector\Loader\PlatformLoaderFactoryInterface
     */
    private $loaderFactory;

    /**
     * @var \BrowserDetector\Parser\Helper\RulefileParserInterface
     */
    private $fileParser;

    private const GENERIC_FILE  = __DIR__ . '/../../data/factories/platforms.json';
    private const SPECIFIC_FILE = __DIR__ . '/../../data/factories/platforms/%s.json';

    /**
     * PlatformParser constructor.
     *
     * @param \BrowserDetector\Loader\PlatformLoaderFactoryInterface $loaderFactory
     * @param \BrowserDetector\Parser\Helper\RulefileParserInterface $fileParser
     */
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
     * @param string $useragent
     *
     * @throws \ExceptionalJSON\DecodeErrorException
     *
     * @return OsInterface
     */
    public function __invoke(string $useragent): OsInterface
    {
        $mode = $this->fileParser->parseFile(
            new SplFileInfo(self::GENERIC_FILE, '', ''),
            $useragent,
            'unknown'
        );

        $key = $this->fileParser->parseFile(
            new SplFileInfo(sprintf(self::SPECIFIC_FILE, $mode), '', ''),
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
     *
     * @return OsInterface
     */
    public function load(string $key, string $useragent = ''): OsInterface
    {
        $loaderFactory = $this->loaderFactory;

        /** @var \BrowserDetector\Loader\PlatformLoader $loader */
        $loader = $loaderFactory();

        return $loader($key, $useragent);
    }
}
