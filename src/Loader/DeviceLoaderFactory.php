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

namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Parser\PlatformParserInterface;
use Psr\Log\LoggerInterface;

use function array_key_exists;

final class DeviceLoaderFactory implements DeviceLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/devices/';

    private LoggerInterface $logger;

    private PlatformParserInterface $platformParser;

    private CompanyLoaderInterface $companyLoader;

    /** @var DeviceLoaderInterface[] */
    private array $loader = [];

    public function __construct(
        LoggerInterface $logger,
        CompanyLoaderInterface $companyLoader,
        PlatformParserInterface $platformParser
    ) {
        $this->logger         = $logger;
        $this->companyLoader  = $companyLoader;
        $this->platformParser = $platformParser;
    }

    public function __invoke(string $company = ''): DeviceLoaderInterface
    {
        if (array_key_exists($company, $this->loader)) {
            return $this->loader[$company];
        }

        $this->loader[$company] = new DeviceLoader(
            $this->logger,
            new Data(self::DATA_PATH . $company, 'json'),
            $this->companyLoader,
            $this->platformParser
        );

        return $this->loader[$company];
    }
}
