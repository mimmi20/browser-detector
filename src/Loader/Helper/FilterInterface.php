<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader\Helper;

use Iterator;
use Symfony\Component\Finder\SplFileInfo;

interface FilterInterface
{
    /**
     * @return Iterator<SplFileInfo>
     */
    public function __invoke(string $path, string $extension): Iterator;
}
