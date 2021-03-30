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

namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\FilterInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;

use function array_key_exists;

final class DeviceLoaderFactory implements DeviceLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/devices/';

    private LoggerInterface $logger;

    private JsonInterface $jsonParser;

    private PlatformParserInterface $platformParser;

    private CompanyLoaderInterface $companyLoader;

    private FilterInterface $filter;

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
