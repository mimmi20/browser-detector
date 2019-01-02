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
namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;

final class DeviceLoaderFactory implements DeviceLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/devices/';

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    /**
     * @var \BrowserDetector\Parser\PlatformParserInterface
     */
    private $platformParser;

    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @var \Symfony\Component\Finder\Finder
     */
    private $finder;

    /**
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \JsonClass\JsonInterface                        $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoaderInterface  $companyLoader
     * @param \BrowserDetector\Parser\PlatformParserInterface $platformParser
     * @param \Symfony\Component\Finder\Finder                $finder
     */
    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoaderInterface $companyLoader,
        PlatformParserInterface $platformParser,
        Finder $finder
    ) {
        $this->logger         = $logger;
        $this->jsonParser     = $jsonParser;
        $this->companyLoader  = $companyLoader;
        $this->platformParser = $platformParser;
        $this->finder         = $finder;
    }

    /**
     * @param string $company
     *
     * @return DeviceLoaderInterface
     */
    public function __invoke(string $company = ''): DeviceLoaderInterface
    {
        /** @var DeviceLoaderInterface[] $loader */
        static $loader = [];

        if (array_key_exists($company, $loader)) {
            return $loader[$company];
        }

        $this->finder->files();
        $this->finder->name('*.json');
        $this->finder->ignoreDotFiles(true);
        $this->finder->ignoreVCS(true);
        $this->finder->ignoreUnreadableDirs();
        $this->finder->in(self::DATA_PATH . $company);

        $loader[$company] = new DeviceLoader(
            $this->logger,
            new Data($this->finder, $this->jsonParser),
            $this->companyLoader,
            $this->platformParser
        );

        return $loader[$company];
    }
}
