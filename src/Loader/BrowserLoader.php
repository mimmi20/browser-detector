<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Loader;

use BrowserDetector\Bits\Browser;
use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use UaBrowserType\TypeLoader;

final class BrowserLoader implements BrowserLoaderInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Parser\EngineParserInterface
     */
    private $engineParser;

    /**
     * @var \BrowserDetector\Loader\Helper\DataInterface
     */
    private $initData;

    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @param \Psr\Log\LoggerInterface                       $logger
     * @param \BrowserDetector\Loader\Helper\DataInterface   $initData
     * @param \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader
     * @param \BrowserDetector\Parser\EngineParserInterface  $engineParser
     */
    public function __construct(
        LoggerInterface $logger,
        DataInterface $initData,
        CompanyLoaderInterface $companyLoader,
        EngineParserInterface $engineParser
    ) {
        $this->logger        = $logger;
        $this->engineParser  = $engineParser;
        $this->companyLoader = $companyLoader;

        $initData();

        $this->initData = $initData;
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
     * @return array
     */
    public function load(string $key, string $useragent = ''): array
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        $browserData = $this->initData->getItem($key);

        if (null === $browserData) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        $browserData->bits  = (new Browser())->getBits($useragent);
        $browserData->modus = null;

        $engineKey = $browserData->engine;
        $engine    = null;

        if (null !== $engineKey) {
            try {
                $engine = $this->engineParser->load($engineKey, $useragent);
            } catch (\UnexpectedValueException $e) {
                $this->logger->warning($e);
            }
        }

        $browser = (new BrowserFactory($this->companyLoader, new VersionFactory(), new TypeLoader()))->fromArray($this->logger, (array) $browserData, $useragent);

        return [$browser, $engine];
    }
}
