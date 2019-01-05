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
namespace BrowserDetector\Parser\Device;

use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\Helper\RulefileParserInterface;

final class MobileParser implements DeviceParserInterface
{
    /**
     * @var \BrowserDetector\Loader\DeviceLoaderFactoryInterface
     */
    private $loaderFactory;

    /**
     * @var \BrowserDetector\Parser\Helper\RulefileParserInterface
     */
    private $fileParser;

    private const GENERIC_FILE  = __DIR__ . '/../../../data/factories/devices/mobile.json';
    private const SPECIFIC_FILE = __DIR__ . '/../../../data/factories/devices/mobile/%s.json';

    /**
     * @param \BrowserDetector\Parser\Helper\RulefileParserInterface $fileParser
     * @param \BrowserDetector\Loader\DeviceLoaderFactoryInterface   $loaderFactory
     */
    public function __construct(RulefileParserInterface $fileParser, DeviceLoaderFactoryInterface $loaderFactory)
    {
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
     * @return array
     */
    public function __invoke(string $useragent): array
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

        return $this->load($mode, $key, $useragent);
    }

    /**
     * @param string $company
     * @param string $key
     * @param string $useragent
     *
     * @return array
     */
    public function load(string $company, string $key, string $useragent = ''): array
    {
        $loaderFactory = $this->loaderFactory;

        /** @var \BrowserDetector\Loader\DeviceLoader $loader */
        $loader = $loaderFactory($company);

        return $loader($key, $useragent);
    }
}
