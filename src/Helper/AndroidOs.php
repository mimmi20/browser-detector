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
namespace BrowserDetector\Helper;

use Stringy\Stringy;

/**
 * a helper to detect windows
 */
class AndroidOs
{
    /**
     * @var \Stringy\Stringy the user agent to handle
     */
    private $useragent;

    /**
     * Class Constructor
     *
     * @param \Stringy\Stringy $useragent
     */
    public function __construct(Stringy $useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isAndroid(): bool
    {
        if (preg_match('/(windows|palmsource)/i', (string) $this->useragent)) {
            return false;
        }

        if (preg_match('/(android|silk|juc ?\(linux;|adr |gingerbread|mtk;|ucweb\/2\.0 \(linux;|maui|spreadtrum|vre;|linux; googletv)/i', (string) $this->useragent)) {
            return true;
        }

        if (preg_match('/Puffin\/[\d\.]+A(T|P)/', (string) $this->useragent)) {
            return true;
        }

        if (preg_match('/(beyondpod)/i', (string) $this->useragent)) {
            return true;
        }

        if (preg_match('/(htc_sensation_z710e)/i', (string) $this->useragent)) {
            return true;
        }

        return false;
    }
}
