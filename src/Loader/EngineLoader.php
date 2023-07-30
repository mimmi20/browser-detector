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

use BrowserDetector\Factory\EngineFactory;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use stdClass;
use UaResult\Engine\EngineInterface;
use UnexpectedValueException;

final class EngineLoader implements EngineLoaderInterface
{
    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly DataInterface $initData,
        private readonly CompanyLoaderInterface $companyLoader,
    ) {
        $initData();
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): EngineInterface
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the engine with key "' . $key . '" was not found');
        }

        $engineData = $this->initData->getItem($key);

        if ($engineData === null) {
            throw new NotFoundException('the engine with key "' . $key . '" was not found');
        }

        /**
         * @var array<string, (stdClass|string|null)> $engineDataArray
         * @phpstan-var array{name?: (string|null), manufacturer?: string, version?: (stdClass|string|null)} $engineDataArray
         */
        $engineDataArray = (array) $engineData;

        return (new EngineFactory(
            $this->companyLoader,
            new VersionFactory(),
            $this->logger,
        ))->fromArray($engineDataArray, $useragent);
    }
}
