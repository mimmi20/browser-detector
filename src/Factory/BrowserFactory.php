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
        $name  = array_key_exists('name', $data) ? (string) $data['name'] : null;
        $modus = array_key_exists('modus', $data) ? (string) $data['modus'] : null;
        $bits  = (new \BrowserDetector\Bits\Browser($useragent))->getBits();

        $type = new Unknown();
        if (array_key_exists('type', $data)) {
            try {
                $type = (new TypeLoader())->load((string) $data['type']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        $version      = $this->getVersion($data, $useragent);
        $manufacturer = $this->getCompany($logger, $data, 'manufacturer');

        return new Browser($name, $manufacturer, $version, $type, $bits, $modus);
    }

    use VersionFactoryTrait;
    use CompanyFactoryTrait;
}
