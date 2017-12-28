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

use BrowserDetector\Bits\Os as OsBits;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionInterface;
use Seld\JsonLint\JsonParser;
use UaResult\Company\CompanyLoader;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

class PlatformLoader implements ExtendedLoaderInterface
{
    /**
     * @var \stdClass[]
     */
    private $platforms = [];

    /**
     * @var self|null
     */
    private static $instance;

    /**
     * @throws \Seld\JsonLint\ParsingException
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
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return void
     */
    private function init(): void
    {
        $this->platforms = [];

        foreach ($this->getPlatforms() as $key => $data) {
            $this->platforms[$key] = $data;
        }
    }

    /**
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return \Generator|\stdClass[]
     */
    private function getPlatforms(): \Generator
    {
        static $platforms = null;

        if (null === $platforms) {
            $jsonParser = new JsonParser();
            $platforms  = $jsonParser->parse(
                file_get_contents(__DIR__ . '/../../data/platforms.json'),
                JsonParser::DETECT_KEY_CONFLICTS
            );
        }

        foreach ($platforms as $key => $data) {
            yield $key => $data;
        }
    }

    /**
     * @param string $platformCode
     *
     * @return bool
     */
    public function has(string $platformCode): bool
    {
        return array_key_exists($platformCode, $this->platforms);
    }

    /**
     * @param string      $platformCode
     * @param string      $useragent
     * @param string|null $inputVersion
     *
     * @return \UaResult\Os\OsInterface
     */
    public function load(string $platformCode, string $useragent = '', string $inputVersion = null): OsInterface
    {
        if (!$this->has($platformCode)) {
            throw new NotFoundException('the platform with key "' . $platformCode . '" was not found');
        }

        $platform = $this->platforms[$platformCode];

        $platformVersionClass = $platform->version->class;

        if (null !== $inputVersion && is_string($inputVersion)) {
            $version = VersionFactory::set($inputVersion);
        } elseif (!is_string($platformVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $platformVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $platform->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $platformVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        $name          = $platform->name;
        $marketingName = $platform->marketingName;
        $manufacturer  = CompanyLoader::getInstance()->load($platform->manufacturer);

        if ('Mac OS X' === $name
            && version_compare($version->getVersion(VersionInterface::IGNORE_MICRO), '10.12', '>=')
        ) {
            $name          = 'macOS';
            $marketingName = 'macOS';
        }

        $bits = (new OsBits($useragent))->getBits();

        return new Os($name, $marketingName, $manufacturer, $version, $bits);
    }
}
