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
namespace BrowserDetector\Loader\Helper;

interface DataInterface extends \Countable
{
    /**
     * @return void
     */
    public function __invoke(): void;

    /**
     * @param string $cacheId
     *
     * @return mixed
     */
    public function getItem(string $cacheId);

    /**
     * @param string $cacheId
     *
     * @return bool
     */
    public function hasItem(string $cacheId): bool;
}
