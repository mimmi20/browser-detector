<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller\Helper;

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: GetParam.php 24 2011-02-01 20:55:24Z tmu $
 */

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Decode extends \Zend\Controller\Action\Helper\AbstractHelper
{
    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link log} verwendet
     *
     * @param string  $text     the string to decode
     * @param boolean $entities an flag,
     *                          if TRUE the string will be encoded with
     *                          htmlentities
     *
     * @return null|array
     */
    public function direct($text, $entities = true)
    {
        return $this->_decode($text, $entities);
    }

    /**
     * decodes an value from utf-8 to iso
     *
     * @param string  $text     the string to decode
     * @param boolean $entities an flag,
     *                          if TRUE the string will be encoded with
     *                          htmlentities
     *
     * @return string
     * @access public
     * @static
     */
    private function _decode($text, $entities = true)
    {
        if (is_string($text) && $text != '') {
            $encoding = mb_detect_encoding($text . ' ', 'UTF-8,ISO-8859-1');

            if ('UTF-8' == $encoding) {
                $text = utf8_decode($text);
            }

            if ($entities) {
                $text = htmlentities($text, ENT_QUOTES, 'iso-8859-1', true);
            }
        }

        return $text;
    }
}