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

use BrowserDetector\Loader\BrowserLoaderFactory;
use BrowserDetector\Loader\CompanyLoader;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;

final class BrowserParser implements BrowserParserInterface
{
    /**
     * @var \BrowserDetector\Loader\BrowserLoaderFactory
     */
    private $loaderFactory;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    private const GENERIC_FILE  = '/../../data/factories/browsers.json';
    private const SPECIFIC_FILE = '/../../data/factories/browsers/%s.json';

    /**
     * @param \Psr\Log\LoggerInterface                      $logger
     * @param \JsonClass\JsonInterface                      $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoader         $companyLoader
     * @param \BrowserDetector\Parser\EngineParserInterface $engineParser
     */
    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoader $companyLoader,
        EngineParserInterface $engineParser
    ) {
        $this->loaderFactory = new BrowserLoaderFactory($logger, $jsonParser, $companyLoader, $engineParser);
        $this->jsonParser    = $jsonParser;
    }

    use CascadedParserTrait;

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    public function load(string $key, string $useragent = ''): array
    {
        $loaderFactory = $this->loaderFactory;

        /** @var \BrowserDetector\Loader\BrowserLoader $loader */
        $loader = $loaderFactory();

        return $loader($key, $useragent);
    }
}
