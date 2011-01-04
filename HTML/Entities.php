<?php
/* vim: set noai expandtab ts=4 st=4 sw=4: */

/**
 * Convert utf8 (or other text encoding) to HTML entities, and vice-versa
 *
 * PHP versions 5
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *  * Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *  * Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *  * The names of its contributors may not be used to endorse or promote
 *    products derived from this software without specific prior written
 *    permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category HTML
 * @package  HTML_Entities
 * @author   Charles Brunet <charles.fmj@gmail.com>
 * @license  http://www.opensource.org/licenses/bsd-license.html BSD License
 * @version  CVS: $Id: Entities.php 4111 2010-11-18 17:38:16Z t.mueller $
 * @link     http://pear.php.net/package/HTML_Entities
 */

require_once 'HTML/Entities/Exception.php';

/**
 * Convert utf8 (or other text encoding) to HTML entities, and vice-versa
 *
 * All functions are static. Functions use utf8 encoding. It uses
 * utf8_encode and utf8_decode functions to deal with latin1 (iso-8859-1)
 * and iconv (if available) to deal with other charsets.
 *
 * The default behavior is to encode utf8 strings using named entities
 * compatible with HTML 4.0, and to decode all entities.
 *
 * Examples:
 *
 * $myencodedtext = HTML_Entities::encode($mytext);
 * $mytextagain = HTML_Entities::decode($myencodedtext);
 *
 * To encode using numerical entities:
 * $myencodedtext = HTML_Entities::encode($mytext, HTML_Entities::CODES)
 *
 * To encode HTML, without touching HTML tags:
 * $myencodedtext = HTML_Entities::encode($mytext, HTML_Entities::NAMES,
 * HTML_Entities::HTML40 | HTML_Entities::IGNORE_SPECIAL_CHARS)
 *
 * To decode to latin1:
 * HTML_Entities::decode($mytext, HTML_Entities::ALL, 'latin1');
 *
 * The list of entities was taken here:
 * http://en.wikipedia.org/wiki/List_of_XML_and_HTML_character_entity_references
 *
 * @category HTML
 * @package  HTML_Entities
 * @author   Charles Brunet <charles.fmj@gmail.com>
 * @license  http://www.opensource.org/licenses/bsd-license.html BSD License
 * @version  Release: 0.2.2
 * @link     http://pear.php.net/package/HTML_Entities
 */
class HTML_Entities
{
    /**
     * Convert special chars to named entities.
     */
    const NAMES = 0x01;

    /**
     * Convert special chars to code entities.
     */
    const CODES =  0x02;

    /**
     * Entities defined in HTML 2.0
     */
    const HTML20 = 0x01;

    /**
     * Entities defined in HTML 3.2
     */
    const HTML32 = 0x02;

    /**
     * Entities defined in HTML 4.0 
     */
    const HTML40 = 0x04;

    /**
     * Entities defined in XML 
     */
    const XML = 0x10;

    /**
     * What to do with illegal chars during conversions.
     *
     * If we are in XML, then illegal chars are x00-x08 x0b x0c x0e-x1f
     * xd800-xdfff xfffe xffff x110000 and greater.
     *
     * Otherwise, illegal characters can be encountered when converting
     * to other charsets.
     */
    const IGNORE_ILLEGAL_CHARS      = 0x00;
    const DROP_ILLEGAL_CHARS        = 0x80;
    const EXCEPTION_ON_ILLEGAL_CHAR = 0xf0;

    /**
     * Entities defined in XHTML 1.0 
     */
    const XHTML10 = 0x14;   // self::HTML40 | self::XML;

    /**
     * Do not convert < > " ' &
     */
    const IGNORE_SPECIAL_CHARS = 0x40;

    /**
     * Convert ALL entities 
     */
    const ALL = 0x3f;

    /**
     * Encode $text with HTML entities.
     *
     * @param string $text    The text to encode
     * @param int    $what    What kind of encoding to use (names and/or codes)
     * @param int    $compat  Compatibility mode (HTML 2.0, 3.2, 4.0, XHTML 1.0)
     * @param string $charset Charset of the input string
     *
     * @return string The encoded text
     * @access public
     * @static
     */
    public static function encode($text,
            $what = self::NAMES,
            $compat = self::HTML40, 
            $charset = 'utf-8')
    {
        // Convert $text to utf-8
        switch ($charset) {
        case 'utf-8':
        case 'utf8':
        case 'UTF-8':
        case 'UTF8':
            // Nothing to do
            $charset = 'utf-8';
            break;
        case 'iso-8859-1':
        case 'latin-1':
        case 'latin1':
        case 'ISO-8859-1':
            $charset = 'iso-8859-1';
            $text    = utf8_encode($text);
            break;
        default:
            if (function_exists('iconv')) {
                if ($compat & self::DROP_ILLEGAL_CHARS) {
                    $outset = 'UTF-8//IGNORE';
                } else {
                    $outset = 'UTF-8//TRANSLIT';
                }
                $text = iconv($charset, $outset, $text);
                if ($test === false) {
                    throw new HTML_Entities_Exception('HTML_Entities:
                        iconv conversion error');
                }
            } else {
                throw new HTML_Entities_Exception('HTML_Entities:
                        iconv function not available.'); 
            }
            break;
        }

        if ($what & self::NAMES) {
            $t    = self::getTranslationTable($compat);
            $text = strtr($text, $t);
        }

        if ($what & self::CODES) {
            // Remplace remaining chars with numerical entities 
            if ($compat & self::XML) {
                if (!($compat & self::NAMES)) {
                    $search_str = '/[\x22\x26\x27\x3c\x3e]/';
                } else {
                    $search_str = null;
                }
            } else {
                $search_str = '/[';
                if ($compat & self::IGNORE_SPECIAL_CHARS) {
                    $search_str .= '';
                } else {
                    $search_str .= '\x22\x27\x3c\x3e';
                    if (!($what & self::NAMES)) {
                        // replace & only if we dont have named entities.
                        $search_str .= '\x26';
                    }
                    $search_str .= ']|';
                }
                $search_str .= '[\xc0-\xdf][\x80-\xbf]|'.
                    '[\xe0-\xef][\x80-\xbf][\x80-\xbf]|'.
                    '[\xf0-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/';
            }
            if (!is_null($search_str)) {
                $text = preg_replace_callback($search_str,
                        'HTML_Entities::_utf8ord', $text);
            }
        } else if ($charset == 'iso-8859-1') {
            $text = utf8_decode($text);
        } else if ($charset != 'utf-8') {
            $text = iconv('utf-8', $charset, $text);
        }

        return $text;
    }

    /**
     * Return unicode numerical entity from a utf8 char.
     * 
     * @param array $matches The array returned by preg_replace. Indice 0 is
     * 						 the utf8 char to convert.
     *
     * @static
     * @access private
     * @return string HTML numerical entity.
     */
    private static function _utf8ord($matches)
    {
        $str = $matches[0];
        // $str can be 1, 2, 3 or 4 bytes long
        switch (strlen($str)) {
        case 2:
            $y = ord($str[0]) & 0x1f;
            $z = ord($str[1]) & 0x3f;
            $c = dechex(($y << 6) + $z);
            break;
        case 3:
            $x = ord($str[0]) & 0x0f;
            $y = ord($str[1]) & 0x3f;
            $z = ord($str[2]) & 0x3f;
            $c = dechex(($x << 12) + ($y << 6) + $z);
            break;
        case 4:
            $w = ord($str[0]) & 0x07;
            $x = ord($str[1]) & 0x3f;
            $y = ord($str[2]) & 0x3f;
            $z = ord($str[3]) & 0x3f;
            $c = dechex(($w << 18) + ($x << 12) + ($y << 6) + $z);
            if (strlen($c) == 5) {
                // It is best to have a even number of digits.
                $c = "0".$c;
            }
        default:
            $c = dechex(ord($str[0]));
        }
        // It is best to have 4 digits minimum.
        $c = str_pad($c, 4, "0", STR_PAD_LEFT);
        return "&#x".$c.";";
    }

    /**
     * Decode $text
     *
     * @param string $text    The text to decode
     * @param int    $options Compatibility mode (HTML 2.0, 3.2, 4.0, XHTML 1.0)
     * @param string $charset Charset of the output
     *
     * @return string The encoded text
     * @access public
     * @static
     */
    public static function decode($text,
            $options = self::ALL,
            $charset = 'utf-8')
    {
        // Convert numerical entities
        $text = preg_replace_callback('/&#(x[0-9a-f]+|[0-9]+);/i',
                'HTML_Entities::_utf8chr', $text);

        // Handle illegal chars...
        if ($options & self::XML) {
            if ($options & self::DROP_ILLEGAL_CHARS) {
                // illegal characters in XML
                $text = preg_replace('/[\x00-\x08\x0b\x0c\x0e-\x1f]|'.
                        '[\xed][\xa0-\xbf][\x80-\xbf]|'.
                        '[\xed][\xef][\xbe\xbf]/', '', $text);
            } elseif ($options & self::EXCEPTION_ON_ILLEGAL_CHAR) {
                if (preg_match('/[\x00-\x08\x0b\x0c\x0e-\x1f]|'.
                            '[\xed][\xa0-\xbf][\x80-\xbf]|'.
                            '[\xed][\xef][\xbe\xbf]/', $text)) {
                    throw new HTML_Entities_Exception('HTML_Entities: 
                        illegal character in XML');
                }
            }
        }

        // Convert named entities
        $t    = self::getTranslationTable($options);
        $t    = array_flip($t);
        $text = strtr($text, $t);

        switch ($charset) {
        case 'utf-8':
        case 'utf8':
        case 'UTF-8':
        case 'UTF8':
            // Nothing to do
            break;
        case 'iso-8859-1':
        case 'latin-1':
        case 'latin1':
        case 'ISO-8859-1':
            $text = utf8_decode($text);
            break;
        default:
            if (function_exists('iconv')) {
                $text = iconv('utf-8', $charset, $text);
            } else {
                throw new HTML_Entities_Exception('HTML_Entities: iconv
                        function not available.'); 
            }
            break;
        }

        return $text;
    }

    /**
     * Convert html nemurical entity to utf8 char.
     * 
     * @param array $matches Array returned from preg_replace. The indice
     *                       1 contains the code, in decimal or hexadecimal.
     *
     * @static
     * @access private
     * @return string An utf8 char.
     */
    private static function _utf8chr($matches)
    {
        $c = $matches[1];
        if ($c[0] == "x") {
            // If we have an hexadecimal number, convert it.
            $c = substr($c, 1);
            $c = ltrim($c, '0');
            $c = hexdec($c);
        } else {
            $c = intval($c);
        }
        // convert unicode to utf8
        if ($c < 0x80) {
            $s = chr($c);
        } elseif ($c < 0x0800) {
            $y = ($c & 0x07c0) >> 6;
            $z = ($c & 0x003f);
            $s = chr(0xc0 | $y).chr(0x80 | $z);
        } elseif ($c < 0x010000) {
            $x = ($c & 0xf000) >> 12;
            $y = ($c & 0x0fc0) >> 6;
            $z = ($c & 0x003f);
            $s = chr(0xe0 | $x).chr(0x80 | $y).chr(0x80 | $z);
        } else {
            $w = ($c & 0x1c0000) >> 18;
            $x = ($c & 0x03f000) >> 12;
            $y = ($c & 0x000fc0) >> 6;
            $z = ($c & 0x00003f);
            $s = chr(0xf0 | $w).chr(0x80 | $x).chr(0x80 | $y).
                chr(0x80 | $z);
        }
        return $s;
    }

    /**
     * Get the translation table.
     * 
     * @param int $options Compatibility mode. 
     * 
     * @return array The array of named entities, associated with utf8 chars.
     * @access public
     * @static
     */
    public static function getTranslationTable($options = self::ALL)
    {
        $a = array();

        if ($options & self::HTML40) {
            $options |= self::HTML32;
        }
        if ($options & self::HTML32) {
            $options |= self::HTML20;
        }

        if ($options & self::HTML20) {
            $a = array_merge($a, array(
                        "\xc3\x80"	=>	"&Agrave;",	
                        "\xc3\x81"	=>	"&Aacute;",	
                        "\xc3\x82"	=>	"&Acirc;",	
                        "\xc3\x83"	=>	"&Atilde;",	
                        "\xc3\x84"	=>	"&Auml;",	
                        "\xc3\x85"	=>	"&Aring;",	
                        "\xc3\x86"	=>	"&AElig;",	
                        "\xc3\x87"	=>	"&Ccedil;",	
                        "\xc3\x88"	=>	"&Egrave;",	
                        "\xc3\x89"	=>	"&Eacute;",	
                        "\xc3\x8a"	=>	"&Ecirc;",	
                        "\xc3\x8b"	=>	"&Euml;",	
                        "\xc3\x8c"	=>	"&Igrave;",	
                        "\xc3\x8d"	=>	"&Iacute;",	
                        "\xc3\x8e"	=>	"&Icirc;",	
                        "\xc3\x8f"	=>	"&Iuml;",	
                        "\xc3\x90"	=>	"&ETH;",	
                        "\xc3\x91"	=>	"&Ntilde;",	
                        "\xc3\x92"	=>	"&Ograve;",	
                        "\xc3\x93"	=>	"&Oacute;",	
                        "\xc3\x94"	=>	"&Ocirc;",	
                        "\xc3\x95"	=>	"&Otilde;",	
                        "\xc3\x96"	=>	"&Ouml;",	
                        "\xc3\x98"	=>	"&Oslash;",	
                        "\xc3\x99"	=>	"&Ugrave;",	
                        "\xc3\x9a"	=>	"&Uacute;",	
                        "\xc3\x9b"	=>	"&Ucirc;",	
                        "\xc3\x9c"	=>	"&Uuml;",	
                        "\xc3\x9d"	=>	"&Yacute;",	
                        "\xc3\x9e"	=>	"&THORN;",	
                        "\xc3\x9f"	=>	"&szlig;",	
                        "\xc3\xa0"	=>	"&agrave;",	
                        "\xc3\xa1"	=>	"&aacute;",	
                        "\xc3\xa2"	=>	"&acirc;",	
                        "\xc3\xa3"	=>	"&atilde;",	
                        "\xc3\xa4"	=>	"&auml;",	
                        "\xc3\xa5"	=>	"&aring;",	
                        "\xc3\xa6"	=>	"&aelig;",	
                        "\xc3\xa7"	=>	"&ccedil;",	
                        "\xc3\xa8"	=>	"&egrave;",	
                        "\xc3\xa9"	=>	"&eacute;",	
                        "\xc3\xaa"	=>	"&ecirc;",	
                        "\xc3\xab"	=>	"&euml;",	
                        "\xc3\xac"	=>	"&igrave;",	
                        "\xc3\xad"	=>	"&iacute;",	
                        "\xc3\xae"	=>	"&icirc;",	
                        "\xc3\xaf"	=>	"&iuml;",	
                        "\xc3\xb0"	=>	"&eth;",	
                        "\xc3\xb1"	=>	"&ntilde;",	
                        "\xc3\xb2"	=>	"&ograve;",	
                        "\xc3\xb3"	=>	"&oacute;",	
                        "\xc3\xb4"	=>	"&ocirc;",	
                        "\xc3\xb5"	=>	"&otilde;",	
                        "\xc3\xb6"	=>	"&ouml;",	
                        "\xc3\xb8"	=>	"&oslash;",	
                        "\xc3\xb9"	=>	"&ugrave;",	
                        "\xc3\xba"	=>	"&uacute;",	
                        "\xc3\xbb"	=>	"&ucirc;",	
                        "\xc3\xbc"	=>	"&uuml;",	
                        "\xc3\xbd"	=>	"&yacute;",	
                        "\xc3\xbe"	=>	"&thorn;",	
                        "\xc3\xbf"	=>	"&yuml;",	
                        ));
        }

        if ($options & self::HTML32) {
            $a = array_merge($a, array(
                        "\xc2\xa0"	=>	"&nbsp;",	
                        "\xc2\xa1"	=>	"&iexcl;",	
                        "\xc2\xa2"	=>	"&cent;",	
                        "\xc2\xa3"	=>	"&pound;",	
                        "\xc2\xa4"	=>	"&curren;",	
                        "\xc2\xa5"	=>	"&yen;",	
                        "\xc2\xa6"	=>	"&brvbar;",	
                        "\xc2\xa7"	=>	"&sect;",	
                        "\xc2\xa8"	=>	"&uml;",	
                        "\xc2\xa9"	=>	"&copy;",	
                        "\xc2\xaa"	=>	"&ordf;",	
                        "\xc2\xab"	=>	"&laquo;",	
                        "\xc2\xac"	=>	"&not;",	
                        "\xc2\xad"	=>	"&shy;",	
                        "\xc2\xae"	=>	"&reg;",	
                        "\xc2\xaf"	=>	"&macr;",	
                        "\xc2\xb0"	=>	"&deg;",	
                        "\xc2\xb1"	=>	"&plusmn;",	
                        "\xc2\xb2"	=>	"&sup2;",	
                        "\xc2\xb3"	=>	"&sup3;",	
                        "\xc2\xb4"	=>	"&acute;",	
                        "\xc2\xb5"	=>	"&micro;",	
                        "\xc2\xb6"	=>	"&para;",	
                        "\xc2\xb7"	=>	"&middot;",	
                        "\xc2\xb8"	=>	"&cedil;",	
                        "\xc2\xb9"	=>	"&sup1;",	
                        "\xc2\xba"	=>	"&ordm;",	
                        "\xc2\xbb"	=>	"&raquo;",	
                        "\xc2\xbc"	=>	"&frac14;",	
                        "\xc2\xbd"	=>	"&frac12;",	
                        "\xc2\xbe"	=>	"&frac34;",	
                        "\xc2\xbf"	=>	"&iquest;",	
                        "\xc3\x97"	=>	"&times;",	
                        "\xc3\xb7"	=>	"&divide;",	
                        ));
        }

        if ($options & self::HTML40) {
            $a = array_merge($a, array(
                        "\xc5\x92"	=>	"&OElig;",	
                        "\xc5\x93"	=>	"&oelig;",	
                        "\xc5\xa0"	=>	"&Scaron;",	
                        "\xc5\xa1"	=>	"&scaron;",	
                        "\xc5\xb8"	=>	"&Yuml;",	
                        "\xc6\x92"	=>	"&fnof;",	
                        "\xcb\x86"	=>	"&circ;",	
                        "\xcb\x9c"	=>	"&tilde;",	
                        "\xce\x91"	=>	"&Alpha;",	
                        "\xce\x92"	=>	"&Beta;",	
                        "\xce\x93"	=>	"&Gamma;",	
                        "\xce\x94"	=>	"&Delta;",	
                        "\xce\x95"	=>	"&Epsilon;",
                        "\xce\x96"	=>	"&Zeta;",	
                        "\xce\x97"	=>	"&Eta;",	
                        "\xce\x98"	=>	"&Theta;",	
                        "\xce\x99"	=>	"&Iota;",	
                        "\xce\x9a"	=>	"&Kappa;",	
                        "\xce\x9b"	=>	"&Lambda;",	
                        "\xce\x9c"	=>	"&Mu;",		
                        "\xce\x9d"	=>	"&Nu;",		
                        "\xce\x9e"	=>	"&Xi;",		
                        "\xce\x9f"	=>	"&Omicron;",
                        "\xce\xa0"	=>	"&Pi;",		
                        "\xce\xa1"	=>	"&Rho;",	
                        "\xce\xa3"	=>	"&Sigma;",	
                        "\xce\xa4"	=>	"&Tau;",	
                        "\xce\xa5"	=>	"&Upsilon;",
                        "\xce\xa6"	=>	"&Phi;",	
                        "\xce\xa7"	=>	"&Chi;",	
                        "\xce\xa8"	=>	"&Psi;",	
                        "\xce\xa9"	=>	"&Omega;",	
                        "\xce\xb1"	=>	"&alpha;",	
                        "\xce\xb2"	=>	"&beta;",	
                        "\xce\xb3"	=>	"&gamma;",	
                        "\xce\xb4"	=>	"&delta;",	
                        "\xce\xb5"	=>	"&epsilon;",
                        "\xce\xb6"	=>	"&zeta;",	
                        "\xce\xb7"	=>	"&eta;",	
                        "\xce\xb8"	=>	"&theta;",	
                        "\xce\xb9"	=>	"&iota;",	
                        "\xce\xba"	=>	"&kappa;",	
                        "\xce\xbb"	=>	"&lambda;",	
                        "\xce\xbc"	=>	"&mu;",		
                        "\xce\xbd"	=>	"&nu;",		
                        "\xce\xbe"	=>	"&xi;",		
                        "\xce\xbf"	=>	"&omicron;",
                        "\xcf\x80"	=>	"&pi;",		
                        "\xcf\x81"	=>	"&rho;",	
                        "\xcf\x82"	=>	"&sigmaf;",	
                        "\xcf\x83"	=>	"&sigma;",	
                        "\xcf\x84"	=>	"&tau;",	
                        "\xcf\x85"	=>	"&upsilon;",
                        "\xcf\x86"	=>	"&phi;",	
                        "\xcf\x87"	=>	"&chi;",	
                        "\xcf\x88"	=>	"&psi;",	
                        "\xcf\x89"	=>	"&omega;",	
                        "\xcf\x91"	=>	"&thetasym;",
                        "\xcf\x92"	=>	"&upsih;",
                        "\xcf\x96"	=>	"&piv;",
                        "\xe2\x80\x82"	=>	"&ensp;",	
                        "\xe2\x80\x83"	=>	"&emsp;",	
                        "\xe2\x80\x89"	=>	"&thinsp;",	
                        "\xe2\x80\x8c"	=>	"&zwnj;",	
                        "\xe2\x80\x8d"	=>	"&zwj;",	
                        "\xe2\x80\x8e"	=>	"&lrm;",	
                        "\xe2\x80\x8f"	=>	"&rlm;",	
                        "\xe2\x80\x93"	=>	"&ndash;",	
                        "\xe2\x80\x94"	=>	"&mdash;",	
                        "\xe2\x80\x98"	=>	"&lsquo;",	
                        "\xe2\x80\x99"	=>	"&rsquo;",	
                        "\xe2\x80\x9a"	=>	"&sbquo;",	
                        "\xe2\x80\x9c"	=>	"&ldquo;",	
                        "\xe2\x80\x9d"	=>	"&rdquo;",	
                        "\xe2\x80\x9e"	=>	"&bdquo;",	
                        "\xe2\x80\xa0"	=>	"&dagger;",	
                        "\xe2\x80\xa1"	=>	"&Dagger;",	
                        "\xe2\x80\xa2"	=>	"&bull;",	
                        "\xe2\x80\xa6"	=>	"&hellip;",	
                        "\xe2\x80\xb0"	=>	"&permil;",	
                        "\xe2\x80\xb2"	=>	"&prime;",	
                        "\xe2\x80\xb3"	=>	"&Prime;",	
                        "\xe2\x80\xb9"	=>	"&lsaquo;",	
                        "\xe2\x80\xba"	=>	"&rsaquo;",	
                        "\xe2\x80\xbe"	=>	"&oline;",	
                        "\xe2\x81\x84"	=>	"&frasl;",	
                        "\xe2\x82\xac"	=>  "&euro;",   
                        "\xe2\x84\x91"	=>  "&image;",  
                        "\xe2\x84\x98"	=>  "&weierp;", 
                        "\xe2\x84\x9c"	=>  "&real;",   
                        "\xe2\x84\xa2"	=>  "&trade;",  
                        "\xe2\x84\xb5"	=>  "&alefsym;",
                        "\xe2\x86\x90"	=>  "&larr;",   
                        "\xe2\x86\x91"	=>  "&uarr;",   
                        "\xe2\x86\x92"	=>  "&rarr;",   
                        "\xe2\x86\x93"	=>  "&darr;",   
                        "\xe2\x86\x94"	=>  "&harr;",   
                        "\xe2\x86\xb5"	=>  "&crarr;",  
                        "\xe2\x87\x90"	=>  "&lArr;",   
                        "\xe2\x87\x91"	=>  "&uArr;",   
                        "\xe2\x87\x92"	=>  "&rArr;",   
                        "\xe2\x87\x93"	=>  "&dArr;",   
                        "\xe2\x87\x94"	=>  "&hArr;",   
                        "\xe2\x88\x80"	=>  "&forall;", 
                        "\xe2\x88\x82"	=>  "&part;",   
                        "\xe2\x88\x83"	=>  "&exist;",  
                        "\xe2\x88\x85"	=>  "&empty;",  
                        "\xe2\x88\x87"	=>  "&nabla;",  
                        "\xe2\x88\x88"	=>  "&isin;",   
                        "\xe2\x88\x89"	=>  "&notin;",  
                        "\xe2\x88\x8b"	=>  "&ni;",     
                        "\xe2\x88\x8f"	=>  "&prod;",   
                        "\xe2\x88\x91"	=>  "&sum;",    
                        "\xe2\x88\x92"	=>  "&minus;",  
                        "\xe2\x88\x97"	=>  "&lowast;", 
                        "\xe2\x88\x9a"	=>  "&radic;",  
                        "\xe2\x88\x9d"	=>  "&prop;",   
                        "\xe2\x88\x9e"	=>  "&infin;",  
                        "\xe2\x88\xa0"	=>  "&ang;",    
                        "\xe2\x88\xa7"	=>  "&and;",    
                        "\xe2\x88\xa8"	=>  "&or;",     
                        "\xe2\x88\xa9"	=>  "&cap;",    
                        "\xe2\x88\xaa"	=>  "&cup;",    
                        "\xe2\x88\xab"	=>  "&int;",    
                        "\xe2\x88\xb4"	=>  "&there4;", 
                        "\xe2\x88\xbc"	=>  "&sim;",    
                        "\xe2\x89\x85"	=>  "&cong;",   
                        "\xe2\x89\x88"	=>  "&asymp;",  
                        "\xe2\x89\xa0"	=>  "&ne;",     
                        "\xe2\x89\xa1"	=>  "&equiv;",  
                        "\xe2\x89\xa4"	=>  "&le;",     
                        "\xe2\x89\xa5"	=>  "&ge;",     
                        "\xe2\x8a\x82"	=>  "&sub;",    
                        "\xe2\x8a\x83"	=>  "&sup;",    
                        "\xe2\x8a\x84"	=>  "&nsub;",   
                        "\xe2\x8a\x86"	=>  "&sube;",   
                        "\xe2\x8a\x87"	=>  "&supe;",   
                        "\xe2\x8a\x95"	=>  "&oplus;",  
                        "\xe2\x8a\x97"	=>  "&otimes;", 
                        "\xe2\x8a\xa5"	=>  "&perp;",   
                        "\xe2\x8b\x85"	=>  "&sdot;",   
                        "\xe2\x8c\x88"	=>  "&lceil;",  
                        "\xe2\x8c\x89"	=>  "&rceil;",  
                        "\xe2\x8c\x8a"	=>  "&lfloor;", 
                        "\xe2\x8c\x8b"	=>  "&rfloor;", 
                        "\xe2\x8c\xa9"	=>  "&lang;",   
                        "\xe2\x8c\xaa"	=>  "&rang;",   
                        "\xe2\x97\x8a"	=>  "&loz;",    
                        "\xe2\x99\xa0"	=>  "&spades;", 
                        "\xe2\x99\xa3"	=>  "&clubs;",  
                        "\xe2\x99\xa5"	=>  "&hearts;", 
                        "\xe2\x99\xa6"	=>  "&diams;",  
                        ));
        }

        if (!($options & self::IGNORE_SPECIAL_CHARS)) {
            $a = array_merge($a, array(
                        "\x22"  =>  "&quot;",   
                        "\x26"  =>  "&amp;",    
                        "\x3c"  =>  "&lt;",     
                        "\x3e"  =>  "&gt;",     
                        ));

            if ($options & self::XML) {
                $a = array_merge($a, array(
                            "\x27"  =>  "&apos;",
                            ));
            }
        }

        return $a;
    }
}

?>
