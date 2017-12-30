<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Loader;

use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use UaDeviceType\TypeLoader;
use UaResult\Company\CompanyLoader;
use UaResult\Device\Device;

class DeviceLoader implements ExtendedLoaderInterface
{
    /**
     * @var \stdClass[]
     */
    private $devices = [];

    /**
     * @var self|null
     */
    private static $instance;

    /**
     * @throws \RuntimeException
     */
    private function __construct()
    {
        $this->init();
    }

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    public static function resetInstance(): void
    {
        self::$instance = null;
    }

    /**
     * initializes cache
     *
     * @throws \RuntimeException
     *
     * @return void
     */
    private function init(): void
    {
        $this->devices = [];

        foreach ($this->getDevices() as $key => $data) {
            $this->devices[$key] = $data;
        }
    }

    /**
     * @throws \RuntimeException
     *
     * @return \Generator|\stdClass[]
     */
    private function getDevices(): \Generator
    {
        static $devices = null;

        if (null === $devices) {
            $sourceDirectory = __DIR__ . '/../../data/devices/';
            $iterator        = new \RecursiveDirectoryIterator($sourceDirectory);
            $jsonParser      = new JsonParser();
            $devices         = [];

            foreach (new \RecursiveIteratorIterator($iterator) as $file) {
                /* @var $file \SplFileInfo */
                if (!$file->isFile() || 'json' !== $file->getExtension()) {
                    continue;
                }

                try {
                    $devicesFile = $jsonParser->parse(
                        file_get_contents($file->getPathname()),
                        JsonParser::DETECT_KEY_CONFLICTS
                    );
                } catch (ParsingException $e) {
                    throw new \RuntimeException('file "' . $file->getPathname() . '" contains invalid json', 0, $e);
                }

                foreach ($devicesFile as $deviceKey => $deviceData) {
                    if (array_key_exists($deviceKey, $devices)) {
                        throw new \RuntimeException('device key "' . $deviceKey . '" was defined more then once');
                    }

                    $devices[$deviceKey] = $deviceData;
                }
            }
        }

        foreach ($devices as $key => $data) {
            yield $key => $data;
        }
    }

    /**
     * @param string $deviceKey
     *
     * @return bool
     */
    public function has(string $deviceKey): bool
    {
        return array_key_exists($deviceKey, $this->devices);
    }

    /**
     * @param string $deviceKey
     * @param string $useragent
     *
     * @return array
     */
    public function load(string $deviceKey, string $useragent = ''): array
    {
        if (!$this->has($deviceKey)) {
            throw new NotFoundException('the device with key "' . $deviceKey . '" was not found');
        }

        $deviceData      = $this->devices[$deviceKey];
        $platformKey     = $deviceData->platform;

        if (null === $platformKey) {
            $platform = null;
        } else {
            $platform = PlatformLoader::getInstance()->load($platformKey, $useragent);
        }

        $companyLoader = CompanyLoader::getInstance();
        $typeLoader    = TypeLoader::getInstance();

        $device = new Device(
            $deviceData->codename,
            $deviceData->marketingName,
            $companyLoader->load($deviceData->manufacturer),
            $companyLoader->load($deviceData->brand),
            $typeLoader->load($deviceData->type),
            $deviceData->pointingMethod,
            $deviceData->resolutionWidth,
            $deviceData->resolutionHeight,
            $deviceData->dualOrientation
        );

        return [$device, $platform];
    }
}
