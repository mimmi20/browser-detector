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
namespace BrowserDetector\Helper\Normalizer;

interface NormalizerInterface
{
    /**
     * Return the normalized user agent
     *
     * @param string $userAgent
     *
     * @return string Normalized user agent
     */
    public function normalize(string $userAgent): string;
}
