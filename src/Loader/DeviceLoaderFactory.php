<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\FilterInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;

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
     * @var \BrowserDetector\Loader\Helper\FilterInterface
     */
    private $filter;

    /**
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \JsonClass\JsonInterface                        $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoaderInterface  $companyLoader
     * @param \BrowserDetector\Parser\PlatformParserInterface $platformParser
     * @param \BrowserDetector\Loader\Helper\FilterInterface  $filter
     */
    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoaderInterface $companyLoader,
        PlatformParserInterface $platformParser,
        FilterInterface $filter
    ) {
        $this->logger         = $logger;
        $this->jsonParser     = $jsonParser;
        $this->companyLoader  = $companyLoader;
        $this->platformParser = $platformParser;
        $this->filter         = $filter;
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

        $filter           = $this->filter;
        $loader[$company] = new DeviceLoader(
            $this->logger,
            new Data($filter(self::DATA_PATH . $company, 'json'), $this->jsonParser),
            $this->companyLoader,
            $this->platformParser
        );

        return $loader[$company];
    }
}
