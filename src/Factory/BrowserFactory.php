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

namespace BrowserDetector\Factory;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\VersionFactoryInterface;
use Psr\Log\LoggerInterface;
use stdClass;
use UaBrowserType\TypeLoaderInterface;
use UaBrowserType\Unknown;
use UaResult\Browser\Browser;
use UaResult\Browser\BrowserInterface;
use UaResult\Company\Company;

use function array_key_exists;
use function assert;

final class BrowserFactory
{
    use VersionFactoryTrait;

    private TypeLoaderInterface $typeLoader;

    private CompanyLoaderInterface $companyLoader;

    private LoggerInterface $logger;

    public function __construct(
        CompanyLoaderInterface $companyLoader,
        VersionFactoryInterface $versionFactory,
        TypeLoaderInterface $typeLoader,
        LoggerInterface $logger
    ) {
        $this->companyLoader  = $companyLoader;
        $this->versionFactory = $versionFactory;
        $this->typeLoader     = $typeLoader;
        $this->logger         = $logger;
    }

    /**
     * @param array<string, (int|stdClass|string|null)> $data
     * @phpstan-param array{name?: string|null, manufacturer?: string, version?: stdClass|string|null, type?: string|null, bits?: int|null, modus?: string|null} $data
     */
    public function fromArray(array $data, string $useragent): BrowserInterface
    {
        assert(array_key_exists('name', $data), '"name" property is required');
        assert(array_key_exists('manufacturer', $data), '"manufacturer" property is required');
        assert(array_key_exists('version', $data), '"version" property is required');
        assert(array_key_exists('type', $data), '"type" property is required');
        assert(array_key_exists('bits', $data), '"bits" property is required');
        assert(array_key_exists('modus', $data), '"modus" property is required');

        $name  = $data['name'];
        $modus = $data['modus'];
        $bits  = $data['bits'];
        $type  = new Unknown();

        if (null !== $data['type']) {
            try {
                $type = $this->typeLoader->load($data['type']);
            } catch (\UaBrowserType\NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $version = $this->getVersion($data['version'], $useragent, $this->logger);

        try {
            $manufacturer = $this->companyLoader->load($data['manufacturer'], $useragent);
        } catch (NotFoundException $e) {
            $this->logger->info($e);

            $manufacturer = new Company(
                'unknown',
                null,
                null
            );
        }

        return new Browser($name, $manufacturer, $version, $type, $bits, $modus);
    }
}
