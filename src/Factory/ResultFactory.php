<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use UaBrowserType\TypeLoader;
use UaDeviceType\Unknown;
use UaResult\Browser\Browser;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UaResult\Device\Market;
use UaResult\Engine\Engine;
use UaResult\Os\Os;
use UaResult\Result\Result;

final class ResultFactory
{
    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * BrowserFactory constructor.
     *
     * @param \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader
     */
    public function __construct(CompanyLoaderInterface $companyLoader)
    {
        $this->companyLoader = $companyLoader;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Result\Result
     */
    public function fromArray(LoggerInterface $logger, array $data): Result
    {
        $headers = [];
        if (array_key_exists('headers', $data)) {
            $headers = (array) $data['headers'];
        }

        $versionFactory = new VersionFactory();

        $device = new Device(
            null,
            null,
            new Company('Unknown', null, null),
            new Company('Unknown', null, null),
            new Unknown(),
            new Display(null, null, null, new \UaDisplaySize\Unknown(), null),
            false,
            0,
            new Market([], [], []),
            []
        );
        if (array_key_exists('device', $data)) {
            $device = (new DeviceFactory($this->companyLoader))->fromArray($logger, (array) $data['device']);
        }

        $browser = new Browser(
            null,
            new Company('Unknown', null, null),
            new Version('0'),
            new \UaBrowserType\Unknown(),
            0,
            null
        );
        if (array_key_exists('browser', $data)) {
            $browser = (new BrowserFactory($this->companyLoader, $versionFactory, new TypeLoader()))->fromArray($logger, (array) $data['browser'], $headers['user-agent'] ?? '');
        }

        $os = new Os(
            null,
            null,
            new Company('Unknown', null, null),
            new Version('0'),
            null
        );
        if (array_key_exists('os', $data)) {
            $os = (new PlatformFactory($this->companyLoader, $versionFactory))->fromArray($logger, (array) $data['os'], $headers['user-agent'] ?? '');
        }

        $engine = new Engine(
            null,
            new Company('Unknown', null, null),
            new Version('0')
        );
        if (array_key_exists('engine', $data)) {
            $engine = (new EngineFactory($this->companyLoader, $versionFactory))->fromArray($logger, (array) $data['engine'], $headers['user-agent'] ?? '');
        }

        return new Result($headers, $device, $os, $browser, $engine);
    }
}
