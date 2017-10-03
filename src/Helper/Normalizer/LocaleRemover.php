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

/**
 * User Agent Normalizer - removes locale information from user agent
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class LocaleRemover implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize(string $userAgent): string
    {
        if (preg_match('/(ca|fr)\-crawler/', $userAgent)) {
            return $userAgent;
        }

        return preg_replace('/; ?[a-z]{2}(?:[-_]r?[a-zA-Z]{2})?(?:\.utf8|\.big5)?\b-?(?!:)/', '', $userAgent);
    }
}
