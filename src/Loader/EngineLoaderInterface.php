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

use UaResult\Engine\EngineInterface;

interface EngineLoaderInterface
{
    /**
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return EngineInterface
     */
    public function __invoke(string $useragent): EngineInterface;

    /**
     * @param string $engineKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function load(string $engineKey, string $useragent = ''): EngineInterface;
}
