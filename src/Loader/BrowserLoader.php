<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Version\VersionBuilderInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;
use stdClass;
use UaBrowserType\TypeLoaderInterface;
use UaBrowserType\Unknown;
use UnexpectedValueException;

use function array_key_exists;
use function assert;
use function is_string;

final class BrowserLoader implements BrowserLoaderInterface
{
    use VersionFactoryTrait;

    public const DATA_PATH = __DIR__ . '/../../data/browsers';

    /** @throws RuntimeException */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly DataInterface $initData,
        private readonly CompanyLoaderInterface $companyLoader,
        private readonly TypeLoaderInterface $typeLoader,
        VersionBuilderInterface $versionBuilder,
    ) {
        $this->versionBuilder = $versionBuilder;

        $initData();
    }

    /**
     * @return array{0: array{name: string|null, version: string|null, manufacturer: string, type: string, isbot: bool}, 1: string|null}
     *
     * @throws NotFoundException
     */
    public function load(string $key, string $useragent = ''): array
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        $browserData = $this->initData->getItem($key);

        if ($browserData === null) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        assert($browserData instanceof stdClass);

        assert(is_string($browserData->engine) || $browserData->engine === null);

        return [
            $this->fromArray((array) $browserData, $useragent),
            $browserData->engine,
        ];
    }

    /**
     * @param array<string, int|string|null> $data
     *
     * @return array{name: string|null, version: string|null, manufacturer: string, type: string, isbot: bool}
     *
     * @throws void
     */
    private function fromArray(array $data, string $useragent = ''): array
    {
        assert(
            array_key_exists('name', $data) && (is_string($data['name']) || $data['name'] === null),
            '"name" property is required',
        );
        assert(
            array_key_exists('manufacturer', $data)
            && (is_string($data['manufacturer']) || $data['manufacturer'] === null),
            '"manufacturer" property is required',
        );
        assert(
            array_key_exists('version', $data)
            && (
                is_string($data['version'])
                || $data['version'] === null
                || $data['version'] instanceof stdClass
            ),
            '"version" property is required',
        );
        assert(
            array_key_exists('type', $data) && (is_string($data['type']) || $data['type'] === null),
            '"type" property is required',
        );

        $name = $data['name'];
        $type = new Unknown();

        if ($data['type'] !== null) {
            try {
                $type = $this->typeLoader->load($data['type']);
            } catch (\UaBrowserType\NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $version      = $this->getVersion($data['version'], $useragent, $this->logger);
        $manufacturer = ['type' => 'unknown'];

        if ($data['manufacturer'] !== null) {
            try {
                $manufacturer = $this->companyLoader->load($data['manufacturer']);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
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
            'type' => $type->getType(),
            'isbot' => $type->isBot(),
        ];
    }
}
