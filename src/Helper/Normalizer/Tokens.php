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
 * User Agent Normalizer - replaces damaged tokens in the user agent
 */
class Tokens implements NormalizerInterface
{
    /**
     * This method replaces some tokens in the user agent string.
     *
     * @param string $userAgent
     *
     * @return string Normalized user agent
     */
    public function normalize(string $userAgent): string
    {
        $userAgent = preg_replace('/([\d]+)EMobile/', '$1; IEMobile', $userAgent);

        $userAgent = str_replace(
            ['Macintoshntel', 'cpu=PPC=Mac'],
            ['Macintosh; Intel', 'cpu=PPC;os=Mac'],
            $userAgent
        );

        $userAgent = preg_replace('/([\\\\]+)/i', '', $userAgent);
        $userAgent = preg_replace('/Versio\//', 'Version/', $userAgent);

        $userAgent = str_replace(
            ['i686 (x86_64)', 'X11buntu', 'Chr0me', 'Web0S'],
            ['i686 on x86_64', 'X11; Ubuntu', 'Chrome', 'webOS'],
            $userAgent
        );

        return $userAgent;
    }
}
