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
use Psr\Log\LoggerInterface;

final class PlatformLoaderFactory implements PlatformLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/platforms';

    private LoggerInterface $logger;

    private CompanyLoaderInterface $companyLoader;

    private ?PlatformLoaderInterface $loader = null;

    public function __construct(
        LoggerInterface $logger,
        CompanyLoaderInterface $companyLoader
    ) {
        $this->logger        = $logger;
        $this->companyLoader = $companyLoader;
    }

    public function __invoke(): PlatformLoaderInterface
    {
        if (null !== $this->loader) {
            return $this->loader;
        }

        $this->loader = new PlatformLoader(
            $this->logger,
            new Data(self::DATA_PATH, 'json'),
            $this->companyLoader
        );

        return $this->loader;
    }
}
