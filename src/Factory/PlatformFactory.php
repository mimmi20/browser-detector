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
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

final class PlatformFactory
{
    /**
     * @var \BrowserDetector\Loader\CompanyLoader
     */
    private $companyLoader;

    /**
     * BrowserFactory constructor.
     *
     * @param \BrowserDetector\Loader\CompanyLoader $companyLoader
     */
    public function __construct(CompanyLoader $companyLoader)
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

        $version = (new VersionFactory())->set('0');
        if (array_key_exists('version', $data)) {
            $versionFactory = new VersionFactory();

            if ($data['version'] instanceof \stdClass) {
                if ('VersionFactory' !== $data['version']->class) {
                    $className      = $data['version']->class;
                    $versionFactory = new $className();
                }

                $version = $versionFactory->detectVersion($useragent, $data['version']->search ?? null);
            } elseif (is_string($data['version'])) {
                $version = $versionFactory->set((string) $data['version']);
            }
        }

        $companyLoader = $this->companyLoader;

        $manufacturer = $companyLoader('Unknown');
        if (array_key_exists('manufacturer', $data)) {
            try {
                $manufacturer = $companyLoader($data['manufacturer']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        return new Os($name, $marketingName, $manufacturer, $version, $bits);
    }
}
