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

use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Seld\JsonLint\JsonParser;
use UaResult\Company\CompanyLoader;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

class EngineLoader implements ExtendedLoaderInterface
{
    /**
     * @var \stdClass[]
     */
    private $engines = [];

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
        $this->engines = [];

        foreach ($this->getEngines() as $key => $data) {
            $this->engines[$key] = $data;
        }
    }

    /**
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return \Generator|\stdClass[]
     */
    private function getEngines(): \Generator
    {
        static $engines = null;

        if (null === $engines) {
            $jsonParser = new JsonParser();
            $engines    = $jsonParser->parse(
                file_get_contents(__DIR__ . '/../../data/engines.json'),
                JsonParser::DETECT_KEY_CONFLICTS
            );
        }

        foreach ($engines as $key => $data) {
            yield $key => $data;
        }
    }

    /**
     * @param string $engineKey
     *
     * @return bool
     */
    public function has(string $engineKey): bool
    {
        return array_key_exists($engineKey, $this->engines);
    }

    /**
     * @param string $engineKey
     * @param string $useragent
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function load(string $engineKey, string $useragent = ''): EngineInterface
    {
        if (!$this->has($engineKey)) {
            throw new NotFoundException('the engine with key "' . $engineKey . '" was not found');
        }

        $engine             = $this->engines[$engineKey];
        $engineVersionClass = $engine->version->class;
        $manufacturer       = CompanyLoader::getInstance()->load($engine->manufacturer);

        if (!is_string($engineVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $engineVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $engine->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $engineVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        return new Engine(
            $engine->name,
            $manufacturer,
            $version
        );
    }
}
