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
use UaBrowserType\TypeLoader;
use UaBrowserType\Unknown;
use UaResult\Browser\Browser;
use UaResult\Browser\BrowserInterface;

final class BrowserFactory
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
     * @return \UaResult\Browser\BrowserInterface
     */
    public function fromArray(LoggerInterface $logger, array $data, string $useragent): BrowserInterface
    {
        $name  = isset($data['name']) ? (string) $data['name'] : null;
        $modus = isset($data['modus']) ? (string) $data['modus'] : null;
        $bits  = (new \BrowserDetector\Bits\Browser($useragent))->getBits();

        $type = new Unknown();
        if (isset($data['type'])) {
            try {
                $type = (new TypeLoader())->load((string) $data['type']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        $version = (new VersionFactory())->set('0');
        if (isset($data['version'])) {
            $versionFactory = new VersionFactory();

            if ($data['version'] instanceof \stdClass) {
                if ('VersionFactory' !== $data['version']->class) {
                    $className      = $data['version']->class;
                    $versionFactory = new $className();
                }

                $version = $versionFactory->detectVersion($useragent, $data['version']->search ?? []);
            } elseif (is_string($data['version'])) {
                $version = $versionFactory->set((string) $data['version']);
            }
        }

        $companyLoader = $this->companyLoader;

        $manufacturer = $companyLoader('Unknown');
        if (isset($data['manufacturer'])) {
            try {
                $manufacturer = $companyLoader((string) $data['manufacturer']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        return new Browser($name, $manufacturer, $version, $type, $bits, $modus);
    }
}
