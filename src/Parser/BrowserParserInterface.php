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
namespace BrowserDetector\Parser;

interface BrowserParserInterface
{
    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array
     */
    public function __invoke(string $useragent);

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    public function load(string $key, string $useragent = ''): array;
}
