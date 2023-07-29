<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use Psr\Log\LoggerInterface;

final class EngineLoaderFactory implements EngineLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/engines';

    private EngineLoaderInterface | null $loader = null;

    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CompanyLoaderInterface $companyLoader,
    ) {
        // nothing to do
    }

    /** @throws void */
    public function __invoke(): EngineLoaderInterface
    {
        if ($this->loader !== null) {
            return $this->loader;
        }

        $this->loader = new EngineLoader(
            $this->logger,
            new Data(self::DATA_PATH, 'json'),
            $this->companyLoader,
        );

        return $this->loader;
    }
}
