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

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\Rules;
use Psr\Log\LoggerInterface;

class GenericLoader implements GenericLoaderInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Loader\Helper\Rules
     */
    private $initRules;

    /**
     * @var \BrowserDetector\Loader\Helper\Data
     */
    private $initData;

    /**
     * @var \BrowserDetector\Loader\SpecificLoaderInterface
     */
    private $specificLoader;

    /**
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \BrowserDetector\Loader\Helper\Rules            $initRules
     * @param \BrowserDetector\Loader\Helper\Data             $initData
     * @param \BrowserDetector\Loader\SpecificLoaderInterface $load
     */
    public function __construct(
        LoggerInterface $logger,
        Rules $initRules,
        Data $initData,
        SpecificLoaderInterface $load
    ) {
        $this->logger         = $logger;
        $this->initRules      = $initRules;
        $this->initData       = $initData;
        $this->specificLoader = $load;
    }

    /**
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return mixed
     */
    public function __invoke(string $useragent)
    {
        $this->init();

        $rules   = $this->initRules->getRules();
        $generic = $this->initRules->getDefault();

        return $this->detectInArray($rules, $generic, $useragent);
    }

    /**
     * initializes cache
     *
     * @return void
     */
    public function init(): void
    {
        if (!$this->initData->isInitialized()) {
            $initData = $this->initData;
            $initData();
        }

        if (!$this->initRules->isInitialized()) {
            $initRules = $this->initRules;
            $initRules();
        }
    }

    /**
     * @param array  $rules
     * @param string $generic
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return mixed
     */
    private function detectInArray(array $rules, string $generic, string $useragent)
    {
        foreach ($rules as $search => $key) {
            $matches = [];

            if (!preg_match($search, $useragent, $matches)) {
                continue;
            }

            if (is_array($key)) {
                return $this->detectInArray($key, $generic, $useragent);
            }

            return $this->load(strtolower(trim(preg_replace($search, $key, $matches[0]))), $useragent);
        }

        return $this->load($generic, $useragent);
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
        $load = $this->specificLoader;

        return $load($key, $useragent);
    }
}
