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
use JsonClass\JsonInterface;
use Symfony\Component\Finder\Finder;

final class CompanyLoaderFactory implements SpecificLoaderFactoryInterface
{
    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    /**
     * @param \JsonClass\JsonInterface $jsonParser
     */
    public function __construct(JsonInterface $jsonParser)
    {
        $this->jsonParser = $jsonParser;
    }

    /**
     * @return SpecificLoaderInterface
     */
    public function __invoke(): SpecificLoaderInterface
    {
        /** @var CompanyLoader $loader */
        static $loader = null;

        if (null !== $loader) {
            return $loader;
        }

        $dataPath = __DIR__ . '/../../data/companies';

        $finder = new Finder();
        $finder->files();
        $finder->name('*.json');
        $finder->ignoreDotFiles(true);
        $finder->ignoreVCS(true);
        $finder->ignoreUnreadableDirs();
        $finder->in($dataPath);

        $loader = new CompanyLoader(
            new Data($finder, $this->jsonParser)
        );

        return $loader;
    }
}
