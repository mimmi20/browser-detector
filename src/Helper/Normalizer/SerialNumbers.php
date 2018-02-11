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
namespace BrowserDetector\Helper\Normalizer;

/**
 * User Agent Normalizer - removes serial numbers from user agent
 */
class SerialNumbers implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize(string $userAgent): string
    {
        $userAgent = preg_replace('/\/SN[\dX]+/', '', $userAgent);
        $userAgent = preg_replace('/\[(ST|TF|NT)[\dX]+\]/', '', $userAgent);

        return $userAgent;
    }
}
