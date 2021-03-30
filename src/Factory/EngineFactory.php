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

namespace BrowserDetector\Factory;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\VersionFactoryInterface;
use Psr\Log\LoggerInterface;
use stdClass;
use UaResult\Company\Company;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;
use UnexpectedValueException;

use function array_key_exists;
use function assert;
use function is_string;

final class EngineFactory
{
    use VersionFactoryTrait;

    private CompanyLoaderInterface $companyLoader;

    public function __construct(CompanyLoaderInterface $companyLoader, VersionFactoryInterface $versionFactory)
    {
        $this->companyLoader  = $companyLoader;
        $this->versionFactory = $versionFactory;
    }

    /**
     * @param array<string, (string|stdClass|null)> $data
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function fromArray(LoggerInterface $logger, array $data, string $useragent): EngineInterface
    {
        assert(array_key_exists('name', $data), '"name" property is required');
        assert(array_key_exists('manufacturer', $data), '"manufacturer" property is required');
        assert(array_key_exists('version', $data), '"version" property is required');

        $name    = $data['name'];
        $version = $this->getVersion($data['version'], $useragent, $logger);

        assert(is_string($name) || null === $name);
        assert(is_string($data['manufacturer']));

        try {
            $manufacturer = $this->companyLoader->load($data['manufacturer'], $useragent);
        } catch (NotFoundException $e) {
            $logger->info($e);

            $manufacturer = new Company(
                'unknown',
                null,
                null
            );
        }

        return new Engine($name, $manufacturer, $version);
    }
}
