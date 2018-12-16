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
namespace BrowserDetector\Loader;

use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Parser\EngineParserInterface;
use Psr\Log\LoggerInterface;

final class BrowserLoader implements SpecificLoaderInterface
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
     * @var \BrowserDetector\Loader\Helper\Data
     */
    private $initData;

    /**
     * @var \BrowserDetector\Loader\CompanyLoader
     */
    private $companyLoader;

    /**
     * @param \Psr\Log\LoggerInterface                      $logger
     * @param \BrowserDetector\Loader\Helper\Data           $initData
     * @param \BrowserDetector\Loader\CompanyLoader         $companyLoader
     * @param \BrowserDetector\Parser\EngineParserInterface $engineParser
     */
    public function __construct(
        LoggerInterface $logger,
        Data $initData,
        CompanyLoader $companyLoader,
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
     *
     * @return array
     */
    public function __invoke(string $key, string $useragent = ''): array
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        $browserData = $this->initData->getItem($key);

        if (null === $browserData) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        $engineKey = $browserData->engine;
        $engine    = null;

        if (null !== $engineKey) {
            try {
                $engine = $this->engineParser->load($engineKey, $useragent);
            } catch (NotFoundException $e) {
                $this->logger->warning($e);
            }
        }

        $browser = (new BrowserFactory($this->companyLoader))->fromArray($this->logger, (array) $browserData, $useragent);

        return [$browser, $engine];
    }
}
