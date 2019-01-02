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
     * @var \Symfony\Component\Finder\Finder
     */
    private $finder;

    /**
     * @param \JsonClass\JsonInterface         $jsonParser
     * @param \Symfony\Component\Finder\Finder $finder
     */
    public function __construct(JsonInterface $jsonParser, Finder $finder)
    {
        $this->jsonParser = $jsonParser;
        $this->finder     = $finder;
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

        $this->finder->files();
        $this->finder->name('*.json');
        $this->finder->ignoreDotFiles(true);
        $this->finder->ignoreVCS(true);
        $this->finder->ignoreUnreadableDirs();
        $this->finder->in($dataPath);

        $loader = new CompanyLoader(
            new Data($this->finder, $this->jsonParser)
        );

        return $loader;
    }
}
