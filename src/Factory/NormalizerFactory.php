<?php


namespace BrowserDetector\Factory;

use UaNormalizer\Generic;
use UaNormalizer\UserAgentNormalizer;

/**
 * detection class using regexes
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class NormalizerFactory
{
    /**
     * builds a useragent normalizer chain
     *
     * @return \UaNormalizer\UserAgentNormalizer
     */
    public function build()
    {
        return new UserAgentNormalizer(
            [
                new Generic\BabelFish(),
                new Generic\IISLogging(),
                new Generic\LocaleRemover(),
                new Generic\EncryptionRemover(),
                new Generic\Mozilla(),
                new Generic\Linux(),
                new Generic\KhtmlGecko(),
                new Generic\HexCode(),
                new Generic\WindowsNt(),
                new Generic\Tokens(),
                new Generic\NovarraGoogleTranslator(),
                new Generic\SerialNumbers(),
                new Generic\TransferEncoding(),
                new Generic\YesWAP(),
            ]
        );
    }
}
