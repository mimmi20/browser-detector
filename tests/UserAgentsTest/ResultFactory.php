<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
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
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use UaBrowserType\TypeLoader;
use UaDeviceType\Unknown;
use UaRequest\GenericRequest;
use UaRequest\GenericRequestFactory;
use UaResult\Browser\Browser;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UaResult\Engine\Engine;
use UaResult\Os\Os;
use UaResult\Result\Result;
use UnexpectedValueException;

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
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
     * @return \UaResult\Result\Result|null
     */
    public function fromArray(LoggerInterface $logger, array $data): ?Result
    {
        if (!array_key_exists('headers', $data)) {
            return null;
        }

        $headers        = (array) $data['headers'];
        $request        = $this->buildRequest($headers);
        $versionFactory = new VersionFactory();

        $device = new Device(
            null,
            null,
            new Company('Unknown', null, null),
            new Company('Unknown', null, null),
            new Unknown(),
            new Display(null, new \UaDisplaySize\Unknown(), null)
        );
        if (array_key_exists('device', $data)) {
            $deviceFactory = new DeviceFactory(
                $this->companyLoader,
                new \UaDeviceType\TypeLoader(),
                new DisplayFactory(new \UaDisplaySize\TypeLoader())
            );
            $device = $deviceFactory->fromArray($logger, (array) $data['device'], $request->getDeviceUserAgent());
        }

        $browserUa = $request->getBrowserUserAgent();

        $browser = new Browser(
            null,
            new Company('Unknown', null, null),
            new Version('0'),
            new \UaBrowserType\Unknown(),
            null,
            null
        );
        if (array_key_exists('browser', $data)) {
            $browser = (new BrowserFactory($this->companyLoader, $versionFactory, new TypeLoader()))->fromArray($logger, (array) $data['browser'], $browserUa);
        }

        $os = new Os(
            null,
            null,
            new Company('Unknown', null, null),
            new Version('0'),
            null
        );
        if (array_key_exists('os', $data)) {
            $os = (new PlatformFactory($this->companyLoader, $versionFactory))->fromArray($logger, (array) $data['os'], $request->getPlatformUserAgent());
        }

        $engine = new Engine(
            null,
            new Company('Unknown', null, null),
            new Version('0')
        );
        if (array_key_exists('engine', $data)) {
            $engine = (new EngineFactory($this->companyLoader, $versionFactory))->fromArray($logger, (array) $data['engine'], $browserUa);
        }

        return new Result($headers, $device, $os, $browser, $engine);
    }

    /**
     * @param array|\Psr\Http\Message\MessageInterface|string|\UaRequest\GenericRequest $request
     *
     * @throws \UnexpectedValueException
     *
     * @return \UaRequest\GenericRequest
     */
    private function buildRequest($request): GenericRequest
    {
        if ($request instanceof GenericRequest) {
            return $request;
        }

        $requestFactory = new GenericRequestFactory();

        if ($request instanceof MessageInterface) {
            return $requestFactory->createRequestFromPsr7Message($request);
        }

        if (is_array($request)) {
            return $requestFactory->createRequestFromArray($request);
        }

        if (is_string($request)) {
            return $requestFactory->createRequestFromString($request);
        }

        throw new UnexpectedValueException(
            'the request parameter has to be a string, an array or an instance of \Psr\Http\Message\MessageInterface'
        );
    }
}
