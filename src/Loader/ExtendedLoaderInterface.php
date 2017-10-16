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

/**
 * Browser detection class
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
interface ExtendedLoaderInterface
{
    /**
     * @param string $browserKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return mixed
     */
    public function load(string $browserKey, string $useragent = '');

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;
}
