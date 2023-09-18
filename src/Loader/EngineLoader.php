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

use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Version\VersionBuilderInterface;
use Psr\Log\LoggerInterface;
use stdClass;
use UnexpectedValueException;

use function array_key_exists;
use function assert;

final class EngineLoader implements EngineLoaderInterface
{
    use VersionFactoryTrait;

    public const DATA_PATH = __DIR__ . '/../../data/engines';

    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly DataInterface $initData,
        private readonly CompanyLoaderInterface $companyLoader,
        VersionBuilderInterface $versionBuilder,
    ) {
        $this->versionBuilder = $versionBuilder;

        $initData();
    }

    /**
     * @return array{name: string|null, version: string|null, manufacturer: string}
     *
     * @throws NotFoundException
     */
    public function load(string $key, string $useragent = ''): array
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the engine with key "' . $key . '" was not found');
        }

        $engineData = $this->initData->getItem($key);

        if ($engineData === null) {
            throw new NotFoundException('the engine with key "' . $key . '" was not found');
        }

        /** @phpstan-var array{name: (string|null), manufacturer: string, version: (stdClass|string|null)} $data */
        $data = (array) $engineData;

        assert(array_key_exists('name', $data), '"name" property is required');
        assert(array_key_exists('manufacturer', $data), '"manufacturer" property is required');
        assert(array_key_exists('version', $data), '"version" property is required');

        $name         = $data['name'];
        $version      = $this->getVersion($data['version'], $useragent, $this->logger);
        $manufacturer = ['type' => 'unknown'];

        try {
            $manufacturer = $this->companyLoader->load($data['manufacturer']);
        } catch (NotFoundException $e) {
            $this->logger->info($e);
        }

        try {
            $versionString = $version->getVersion();
        } catch (UnexpectedValueException $e) {
            $this->logger->info($e);

            $versionString = null;
        }

        return [
            'name' => $name,
            'version' => $versionString,
            'manufacturer' => $manufacturer['type'],
        ];
    }
}
