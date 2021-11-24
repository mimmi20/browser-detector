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

namespace UserAgentsTest;

use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\DisplayFactory;
use BrowserDetector\Factory\EngineFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\RequestBuilder;
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use stdClass;
use UaBrowserType\TypeLoader;
use UaDeviceType\Unknown;
use UaResult\Browser\Browser;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UaResult\Engine\Engine;
use UaResult\Os\Os;
use UaResult\Result\Result;
use UnexpectedValueException;

use function array_key_exists;

final class ResultFactory
{
    private const UNKNOWN = 'Unknown';
    private CompanyLoaderInterface $companyLoader;

    private LoggerInterface $logger;

    public function __construct(CompanyLoaderInterface $companyLoader, LoggerInterface $logger)
    {
        $this->companyLoader = $companyLoader;
        $this->logger        = $logger;
    }

    /**
     * @param array<string, array<string, string>> $data
     * @phpstan-param array{headers?: array<string, string>, device?: (stdClass|array{deviceName?: (string|null), marketingName?: (string|null), manufacturer?: string, brand?: string, type?: (string|null), display?: (null|array{width?: (int|null), height?: (int|null), touch?: (bool|null), size?: (int|float|null)}|stdClass)}), browser?: (stdClass|array{name?: (string|null), manufacturer?: string, version?: (stdClass|string|null), type?: (string|null), bits?: (int|null), modus?: (string|null)}), os?: (stdClass|array{name?: (string|null), marketingName?: (string|null), manufacturer?: string, version?: (stdClass|string|null), bits?: (int|null)}), engine?: (stdClass|array{name?: (string|null), manufacturer?: string, version?: (stdClass|string|null)})} $data
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws NotNumericException
     */
    public function fromArray(LoggerInterface $logger, array $data): ?Result
    {
        if (!array_key_exists('headers', $data)) {
            return null;
        }

        $headers        = $data['headers'];
        $request        = (new RequestBuilder())->buildRequest(new NullLogger(), $headers);
        $versionFactory = new VersionFactory();

        $device = new Device(
            null,
            null,
            new Company(self::UNKNOWN, null, null),
            new Company(self::UNKNOWN, null, null),
            new Unknown(),
            new Display(null, null, null, null)
        );

        if (array_key_exists('device', $data)) {
            $deviceFactory = new DeviceFactory(
                $this->companyLoader,
                new \UaDeviceType\TypeLoader(),
                new DisplayFactory(),
                $logger
            );

            $device = $deviceFactory->fromArray((array) $data['device'], $request->getDeviceUserAgent());
        }

        $browserUa = $request->getBrowserUserAgent();

        $browser = new Browser(
            null,
            new Company(self::UNKNOWN, null, null),
            new Version('0'),
            new \UaBrowserType\Unknown(),
            null,
            null
        );

        if (array_key_exists('browser', $data)) {
            $browser = (new BrowserFactory($this->companyLoader, $versionFactory, new TypeLoader(), $this->logger))->fromArray((array) $data['browser'], $browserUa);
        }

        $os = new Os(
            null,
            null,
            new Company(self::UNKNOWN, null, null),
            new Version('0'),
            null
        );

        if (array_key_exists('os', $data)) {
            $os = (new PlatformFactory($this->companyLoader, $versionFactory, $this->logger))->fromArray((array) $data['os'], $request->getPlatformUserAgent());
        }

        $engine = new Engine(
            null,
            new Company(self::UNKNOWN, null, null),
            new Version('0')
        );

        if (array_key_exists('engine', $data)) {
            $engine = (new EngineFactory($this->companyLoader, $versionFactory, $this->logger))->fromArray((array) $data['engine'], $browserUa);
        }

        return new Result($headers, $device, $os, $browser, $engine);
    }
}
