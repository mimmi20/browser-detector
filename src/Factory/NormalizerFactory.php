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
namespace BrowserDetector\Factory;

use BrowserDetector\Helper\Normalizer;
use BrowserDetector\Helper\Normalizer\UserAgentNormalizer;

/**
 * factory to create a useragent normalizer
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class NormalizerFactory
{
    /**
     * builds a useragent normalizer chain
     *
     * @return \BrowserDetector\Helper\Normalizer\UserAgentNormalizer
     */
    public function build(): UserAgentNormalizer
    {
        return new UserAgentNormalizer(
            [
                new Normalizer\BabelFish(),
                new Normalizer\IISLogging(),
                new Normalizer\LocaleRemover(),
                new Normalizer\EncryptionRemover(),
                new Normalizer\Mozilla(),
                new Normalizer\Linux(),
                new Normalizer\KhtmlGecko(),
                new Normalizer\HexCode(),
                new Normalizer\WindowsNt(),
                new Normalizer\Tokens(),
                new Normalizer\NovarraGoogleTranslator(),
                new Normalizer\SerialNumbers(),
                new Normalizer\TransferEncoding(),
            ]
        );
    }
}
