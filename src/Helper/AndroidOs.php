<?php


namespace BrowserDetector\Helper;

/**
 * a helper to detect windows
 */
class AndroidOs
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = '';

    /**
     * Class Constructor
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Helper\AndroidOs
     */
    public function __construct($useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isAndroid()
    {
        if (preg_match('/(windows|palmsource)/i', $this->useragent)) {
            return false;
        }

        if (preg_match('/(android|silk|juc ?\(linux;|adr |gingerbread|mtk;|ucweb\/2\.0 \(linux;|maui|spreadtrum|vre;|linux; googletv)/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/Puffin\/[\d\.]+A(T|P)/', $this->useragent)) {
            return true;
        }

        if (preg_match('/(beyondpod)/i', $this->useragent)) {
            return true;
        }

        return false;
    }
}
