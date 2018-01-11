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
 * User Agent Normalizer - removes Novarra garbage from user agent
 */
class NovarraGoogleTranslator implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize(string $userAgent): string
    {
        return preg_replace('/(\sNovarra-Vision.*)|(,gzip\(gfe\)\s+\(via translate.google.com\))/', '', $userAgent);
    }
}
