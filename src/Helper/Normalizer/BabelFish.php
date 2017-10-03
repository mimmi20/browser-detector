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
 * User Agent Normalizer - removes BabelFish garbage from user agent
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class BabelFish implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return mixed|string
     */
    public function normalize(string $userAgent): string
    {
        return preg_replace('/\s*\(via babelfish.yahoo.com\)\s*/', '', $userAgent);
    }
}
