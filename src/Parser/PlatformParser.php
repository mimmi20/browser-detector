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

use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\PlatformLoaderFactory;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;
use UaResult\Os\OsInterface;

final class PlatformParser implements PlatformParserInterface
{
    /**
     * @var \BrowserDetector\Loader\PlatformLoaderFactory
     */
    private $loaderFactory;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    private const GENERIC_FILE  = '/../../data/factories/platforms.json';
    private const SPECIFIC_FILE = '/../../data/factories/platforms/%s.json';

    /**
     * @param \Psr\Log\LoggerInterface              $logger
     * @param \JsonClass\JsonInterface              $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoader $companyLoader
     */
    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoader $companyLoader
    ) {
        $this->loaderFactory = new PlatformLoaderFactory($logger, $jsonParser, $companyLoader);
        $this->jsonParser    = $jsonParser;
    }

    use CascadedParserTrait;

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
