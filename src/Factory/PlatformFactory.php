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
use BrowserDetector\Version\VersionInterface;
use Psr\Log\LoggerInterface;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

final class PlatformFactory
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
     * @param string                   $useragent
     *
     * @return \UaResult\Os\OsInterface
     */
    public function fromArray(LoggerInterface $logger, array $data, string $useragent): OsInterface
    {
        $name          = array_key_exists('name', $data) ? $data['name'] : null;
        $marketingName = array_key_exists('marketingName', $data) ? $data['marketingName'] : null;
        $bits          = (new \BrowserDetector\Bits\Os($useragent))->getBits();

        $version      = $this->getVersion($data, $useragent);
        $manufacturer = $this->getCompany($logger, $data, 'manufacturer');

        if ('Mac OS X' === $name
            && version_compare($version->getVersion(VersionInterface::IGNORE_MICRO), '10.12', '>=')
        ) {
            $name          = 'macOS';
            $marketingName = 'macOS';
        } elseif ('iOS' === $name
            && version_compare($version->getVersion(VersionInterface::IGNORE_MICRO), '4.0', '<')
        ) {
            $name          = 'iPhone OS';
            $marketingName = 'iPhone OS';
        }

        return new Os($name, $marketingName, $manufacturer, $version, $bits);
    }

    use VersionFactoryTrait;
    use CompanyFactoryTrait;
}
