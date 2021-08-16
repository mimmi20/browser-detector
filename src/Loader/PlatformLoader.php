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

use BrowserDetector\Bits\Os;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

final class PlatformLoader implements PlatformLoaderInterface
{
    private LoggerInterface $logger;

    private DataInterface $initData;

    private CompanyLoaderInterface $companyLoader;

    public function __construct(
        LoggerInterface $logger,
        DataInterface $initData,
        CompanyLoaderInterface $companyLoader
    ) {
        $this->logger        = $logger;
        $this->companyLoader = $companyLoader;

        $initData();

        $this->initData = $initData;
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): OsInterface
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the platform with key "' . $key . '" was not found');
        }

        $platformData = $this->initData->getItem($key);

        if (null === $platformData) {
            throw new NotFoundException('the platform with key "' . $key . '" was not found');
        }

        $platformData->bits = (new Os())->getBits($useragent);

        return (new PlatformFactory($this->companyLoader, new VersionFactory(), $this->logger))->fromArray((array) $platformData, $useragent);
    }
}
