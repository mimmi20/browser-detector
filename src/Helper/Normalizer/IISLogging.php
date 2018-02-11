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
 * User Agent Normalizer - clean IIS Logging from user agent
 */
class IISLogging implements NormalizerInterface
{
    /**
     * This method clean the IIS logging from user agent string.
     *
     * @param string $userAgent
     *
     * @return string Normalized user agent
     */
    public function normalize(string $userAgent): string
    {
        // If there are no spaces in a UA and more than 2 plus symbols, the UA is likely affected by IIS style logging issues
        if (0 === mb_substr_count($userAgent, ' ') && 2 < mb_substr_count($userAgent, '+')) {
            $userAgent = str_replace('+', ' ', $userAgent);
        }

        return $userAgent;
    }
}
