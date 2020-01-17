<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\FilterInterface;
use JsonClass\JsonInterface;

final class CompanyLoaderFactory implements CompanyLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/companies';

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    /**
     * @var \BrowserDetector\Loader\Helper\FilterInterface
     */
    private $filter;

    /**
     * @param \JsonClass\JsonInterface                       $jsonParser
     * @param \BrowserDetector\Loader\Helper\FilterInterface $filter
     */
    public function __construct(JsonInterface $jsonParser, FilterInterface $filter)
    {
        $this->jsonParser = $jsonParser;
        $this->filter     = $filter;
    }

    /**
     * @return CompanyLoaderInterface
     */
    public function __invoke(): CompanyLoaderInterface
    {
        /** @var CompanyLoader|null $loader */
        static $loader = null;

        if (null !== $loader) {
            return $loader;
        }

        $filter = $this->filter;
        $loader = new CompanyLoader(
            new Data($filter(self::DATA_PATH, 'json'), $this->jsonParser)
        );

        return $loader;
    }
}
