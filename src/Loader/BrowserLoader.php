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

use BrowserDetector\Bits\Browser as BrowserBits;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Seld\JsonLint\JsonParser;
use UaBrowserType\TypeLoader;
use UaResult\Browser\Browser;
use UaResult\Company\CompanyLoader;

class BrowserLoader implements ExtendedLoaderInterface
{
    /**
     * @var \stdClass[]
     */
    private $browsers = [];

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
        $this->browsers = [];

        foreach ($this->getBrowsers() as $key => $data) {
            $this->browsers[$key] = $data;
        }
    }

    /**
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return \Generator|\stdClass[]
     */
    private function getBrowsers(): \Generator
    {
        static $browsers = null;

        if (null === $browsers) {
            $jsonParser = new JsonParser();
            $browsers   = $jsonParser->parse(
                file_get_contents(__DIR__ . '/../../data/browsers.json'),
                JsonParser::DETECT_KEY_CONFLICTS
            );
        }

        foreach ($browsers as $key => $data) {
            yield $key => $data;
        }
    }

    /**
     * @param string $browserKey
     *
     * @return bool
     */
    public function has(string $browserKey): bool
    {
        return array_key_exists($browserKey, $this->browsers);
    }

    /**
     * @param string $browserKey
     * @param string $useragent
     *
     * @return array
     */
    public function load(string $browserKey, string $useragent = ''): array
    {
        if (!$this->has($browserKey)) {
            throw new NotFoundException('the browser with key "' . $browserKey . '" was not found');
        }

        $browserData         = $this->browsers[$browserKey];
        $browserVersionClass = $browserData->version->class;
        $manufacturer        = CompanyLoader::getInstance()->load($browserData->manufacturer);
        $type                = TypeLoader::getInstance()->load($browserData->type);

        if (!is_string($browserVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $browserVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $browserData->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $browserVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        $bits      = (new BrowserBits($useragent))->getBits();
        $engineKey = $browserData->engine;

        if (null !== $engineKey) {
            $engine = EngineLoader::getInstance()->load($engineKey, $useragent);
        } else {
            $engine = null;
        }

        $browser = new Browser($browserData->name, $manufacturer, $version, $type, $bits);

        return [$browser, $engine];
    }
}
