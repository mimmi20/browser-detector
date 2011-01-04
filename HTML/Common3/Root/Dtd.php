<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Dtd: Class for a DTD
 *
 * PHP versions 5 and 6
 *
 * LICENSE:
 *
 * Copyright (c) 2007 - 2009, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright
 * notice, this list of conditions and the following disclaimer in the
 * documentation and/or other materials provided with the distribution.
 * * The names of the authors may not be used to endorse or promote products
 * derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
 * OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @version  SVN: $Id: Dtd.php 11 2010-10-10 19:17:21Z tmu $
 * @link     http://pear.php.net/package/\HTML\Common3\
 */

require_once 'HTML/Common3/Root/Zero.php';

/**
 * class Interface for \HTML\Common3\
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Root\Dtd

/**
 * Class for a DTD
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Dtdextends \HTML\Common3\Root\Zeroimplements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * Array of additional Elements and Attributes in the DTD (ELEMENT)
     *
     * @var      array
     * @access   protected
     */
    protected $_dtdElements = array();

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id: Dtd.php 11 2010-10-10 19:17:21Z tmu $';

    // }}} properties
    // {{{ addDtdAttribute

    /**
     * add an forbidden Attribute to the DTD to make it possible
     *
     * @param string $elementName the name of the element which should add the new
     *                            attribute for
     * @param string $attribute   the name of the attribute which should be added
     * @param string $type        (Optional) the type for the new attribute
     * @param string $need        (Optional) the need level for the new attribute
     *
     * @return \HTML\Common3\Root\Dtd
     * @access public
     */
    public function addDtdAttribute($elementName, $attribute, $type = 'CDATA',
                                    $need = '#IMPLIED')
    {
        $elementName = strtolower((string) $elementName);
        $attribute   = strtolower((string) $attribute);

        if ($elementName !== '' && $attribute !== '') {
            $type = (string) $type;
            $need = strtoupper((string) $need);

            if ($type == '') {
                $type = 'CDATA';
            }

            if ($need == '') {
                $need = '#IMPLIED';
            }

            $this->_dtdElements[$elementName][$attribute]['type'] = $type;
            $this->_dtdElements[$elementName][$attribute]['need'] = $need;
        }

        return $this;
    }

    // }}} addDtdAttribute
    // {{{ unsetDtdAttribute

    /**
     * unsets an forbidden Attribute to the DTD to make it unpossible
     *
     * @param string $elementName the name of the element which should add the new
     *                            attribute for
     * @param string $attribute   the name of the attribute which should be added
     * @param string $type        (Optional) the type for the new attribute
     * @param string $need        (Optional) the need level for the new attribute
     *
     * @return \HTML\Common3\Root\Dtd
     * @access public
     */
    public function unsetDtdAttribute($elementName, $attribute)
    {
        $elementName = strtolower((string) $elementName);
        $attribute   = strtolower((string) $attribute);

        if ($elementName !== '' && $attribute !== '' &&
        isset($this->_dtdElements[$elementName][$attribute])) {
            unset($this->_dtdElements[$elementName][$attribute]);
        }

        return $this;
    }

    // }}} unsetDtdAttribute
    // {{{ addDtdElement

    /**
     * add an forbidden Element to the DTD to make it possible
     *
     * @param string            $elementName the name of the element which should add
     *                                       the new attribute for
     * @param string|array|null $subElements the name of the attribute which should
     *                                       be added
     *
     * @return \HTML\Common3\Root\Dtd
     * @access public
     */
    public function addDtdElement($elementName, $subElements = null)
    {
        $elementName = strtolower((string) $elementName);

        if ($elementName !== '') {
            if (is_string($subElements) && $subElements !== null) {
                if ($subElements == '') {
                    $subElements = '#PCDATA';
                }
                $this->_dtdElements[$elementName]['addedNew'][] = $subElements;
            } elseif (is_array($subElements)) {
                foreach ($subElements as $subElementName) {
                    if ($subElementName == '') {
                        $subElementName = '#PCDATA';
                    }
                    $this->_dtdElements[$elementName]['addedNew'][] =
                        $subElementName;
                }
            } elseif ($subElements === null) {
                $this->_dtdElements[$elementName]['addedNew'] = array();
            }
        }

        return $this;
    }

    // }}} addDtdElement
    // {{{ toHtml

    /**
     * Returns the Element structure as HTML, works recursive
     *
     * @param int     $step     the level in which should startet the output,
     *                          the internal level is updated
     * @param boolean $dump     if TRUE an dump of the class is created
     * @param boolean $comments if TRUE comments were added to the output
     * @param boolean $levels   if TRUE the levels are added,
     *                          if FALSE the levels will be ignored
     *
     * @return string
     * @access public
     */
    public function toHtml($step = 0, $dump = false, $comments = false,
                               $levels = true)
    {
        $txt = '';
        $dtd = \HTML\Common3\Globals::getAllDtds();

        $this->setIndentLevel(1);
        $docType   = $this->getDoctype(false);
        $type      = $docType['type'];
        $version   = $docType['version'];
        $variant   = $docType['variant'];
        $dtdType   = $dtd[$type][$version][$variant];
        $docType   = $this->getDoctype(true);
        $begin_txt = $this->getIndent();
        $lineEnd   = $this->getOption('linebreak');

        $txt .= '<!DOCTYPE html';        if ($docType && $dtdType) {            $txt .= ' PUBLIC "-//W3C//DTD ' . $docType . '//EN" "' . $dtdType                 . '"';

            if (count($this->_dtdElements) > 0) {
                $txt .= $lineEnd . $begin_txt . '[' . $lineEnd;

                foreach ($this->_dtdElements as $element => $attribute) {
                    if (isset($attribute['addedNew'])) {
                        //new element
                        $txt .= $begin_txt . '<!ELEMENT ' . $element . ' ';

                        if (count($attribute['addedNew'])) {
                            $txt .= '(' . implode(' | ', $attribute['addedNew']) . ')';
                        } else {
                            $txt .= 'EMPTY';
                        }

                        $txt .= '>' . $lineEnd;

                        foreach ($attribute['addedNew'] as $subElement) {
                            if (!isset($this->_dtdElements[$subElement])) {
                                $this->_dtdElements[$subElement]['addedNew'] = array();
                            }
                        }
                    }

                    if (count($attribute) > 0) {
                        $txt .= $begin_txt . '<!ATTLIST ' . $element . $lineEnd;

                        foreach ($attribute as $attributeName => $properties) {
                            if ($attributeName !== 'addedNew') {
                                $type = $properties['type'];
                                $need = $properties['need'];

                                $txt .= $begin_txt . '          ' . $attributeName . ' '
                                                   . $type . ' ' . $need . $lineEnd;
                            }
                        }

                        $txt .= $begin_txt . '>' . $lineEnd;
                    }
                }

                $txt .= $begin_txt . ']';
            }        }

        $txt .= '>' . $lineEnd;

        return $txt;
    }

    // }}} toHtml
}

// }}} \HTML\Common3\Root\Dtd

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */