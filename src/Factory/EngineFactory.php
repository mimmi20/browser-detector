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
use BrowserDetector\Loader\EngineLoaderFactory;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

class EngineFactory implements EngineFactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\EngineLoaderFactory
     */
    private $loaderFactory;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->loaderFactory = new EngineLoaderFactory($logger);
    }

    /**
     * Gets the information about the engine by User Agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function __invoke(string $useragent): EngineInterface
    {
        $loaderFactory = $this->loaderFactory;

        $loader = $loaderFactory();

        return $loader($useragent);
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return mixed
     */
    public function load(string $key, string $useragent = '')
    {
        $loaderFactory = $this->loaderFactory;

        $loader = $loaderFactory();

        return $loader->load($key, $useragent);
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function fromArray(LoggerInterface $logger, array $data): EngineInterface
    {
        $name = array_key_exists('name', $data) ? $data['name'] : null;

        $version = (new VersionFactory())->set('0');
        if (array_key_exists('version', $data)) {
            $version = (new VersionFactory())->set($data['version']);
        }

        $manufacturer = CompanyLoader::getInstance()->load('Unknown');
        if (array_key_exists('manufacturer', $data)) {
            try {
                $manufacturer = CompanyLoader::getInstance()->load($data['manufacturer']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        return new Engine($name, $manufacturer, $version);
    }
}
