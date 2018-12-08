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

use BrowserDetector\Loader\BrowserLoaderFactory;
use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use UaBrowserType\TypeLoader;
use UaBrowserType\Unknown;
use UaResult\Browser\Browser;
use UaResult\Browser\BrowserInterface;

class BrowserFactory implements BrowserFactoryInterface
{
    private $factories = [
        '/edge/i' => 'edge',
        '/chrome|crmo|chr0me/i' => 'blink',
        '/webkit|safari|cfnetwork|dalvik|ipad|ipod|iphone|khtml/i' => 'webkit',
        '/iOS/' => 'webkit',
        '/presto|opera/i' => 'presto',
        '/trident|msie|like gecko/i' => 'trident',
        '/gecko|firefox|minefield|shiretoko|bonecho|namoroka/i' => 'gecko',
    ];

    /**
     * @var \BrowserDetector\Loader\BrowserLoaderFactory
     */
    private $loaderFactory;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->loaderFactory = new BrowserLoaderFactory($logger);
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
    {
        $loaderFactory = $this->loaderFactory;

        foreach ($this->factories as $rule => $mode) {
            if (preg_match($rule, $useragent)) {
                $loader = $loaderFactory($mode);

                return $loader($useragent);
            }
        }

        $loader = $loaderFactory('genericbrowser');

        return $loader($useragent);
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Browser\BrowserInterface
     */
    public static function fromArray(LoggerInterface $logger, array $data): BrowserInterface
    {
        $name  = isset($data['name']) ? (string) $data['name'] : null;
        $modus = isset($data['modus']) ? (string) $data['modus'] : null;
        $bits  = isset($data['bits']) ? (int) $data['bits'] : null;

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
            $version = (new VersionFactory())->set((string) $data['version']);
        }

        $manufacturer = CompanyLoader::getInstance()->load('Unknown');
        if (isset($data['manufacturer'])) {
            try {
                $manufacturer = CompanyLoader::getInstance()->load((string) $data['manufacturer']);
            } catch (NotFoundException $e) {
                $logger->info($e);
            }
        }

        return new Browser($name, $manufacturer, $version, $type, $bits, $modus);
    }
}
