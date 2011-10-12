<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Dialog: Class for HTML <dialog> Elements
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
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/\HTML\Common3\
 */

require_once 'HTML/Common3/Lists.php';

/**
 * class Interface for \HTML\Common3\
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Root\Dialog

/**
 * Class for HTML <dialog> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Dialogextends \HTML\Common3\Listsimplements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'dialog';

    /**
     * Associative array of attributes
     *
     * @var      array
     * @access   protected
     */
    protected $_attributes = array();

    /**
     * List of attributes to which will be announced via
     * {@link onAttributeChange()} method rather than performed by
     * \HTML\Common3\ class itself
     *
     * contains all required attributes
     *
     * @var      array
     * @see      onAttributeChange()
     * @see      getWatchedAttributes()
     * @access   protected
     * @readonly
     */
    protected $_watchedAttributes = array();

    /**
     * Array of HTML Elements which are possible as child elements
     *
     * @var      array
     * @access   protected
     */
    protected $_posElements = array(
        '#all' => array(
            'dd',
            'dt'
        )
    );

    /**
     * Array of Attibutes which are possible for an Element
     *
     * @var      array
     * @access   protected
     */
    protected $_posAttributes = array(
        '#all' => array(
            'class',
            'dir',
            'id',
            'style',
            'title',
            'onclick',
            'ondblclick',
            'onmousedown',
            'onmouseup',
            'onmouseover',
            'onmousemove',
            'onmouseout',
            'onkeypress',
            'onkeydown',
            'onkeyup'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '4.01' => array(
                'frameset' => array(
                    'compact'
                ),
                'transitional' => array(
                    'compact'
                )
            ),
            '5.0' => array(
                'transitional' => array(
                    'compact'
                )
            )
        ),
        'xhtml' => array(
            '#all' => array(
                'xml:lang'
            ),
            '1.0' => array(
                '#all' => array(
                    'lang'
                ),
                'frameset' => array(
                    'compact'
                ),
                'transitional' => array(
                    'compact'
                )
            )
        )
    );

    /**
     * List of li-Elements in this list
     *
     * @var      array
     * @see      onAttributeChange()
     * @access   protected
     */
    protected $_list = array(
        'dd' => array(),
        'dt' => array()
    );

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ writeInner

    /**
     * Returns the inner Element structure as HTML, works recursive
     *
     * @param boolean $dump     if TRUE an dump of the class is created
     * @param boolean $comments if TRUE comments were added to the output
     * @param boolean $levels   if TRUE the levels are added,
     *                          if FALSE the levels will be ignored
     *
     * @return string
     * @access public
     */
    public function writeInner($dump = false, $comments = false, $levels = true)
    {
        if ($this->_elementEmpty) {
            return '';
        }

        $step     = (int)     $this->getIndentLevel() + 1;
        $dump     = (boolean) $dump;
        $comments = (boolean) $comments;
        $levels   = (boolean) $levels;
        $txt      = '';
        //$lineEnd = $this->getOption('linebreak');

        foreach (array_keys($this->list['dd']) as $index) {
            if (isset($this->list['dd'][$index]) &&
                isset($this->list['dt'][$index]) &&
                is_object($this->list['dd'][$index]) &&
                is_object($this->list['dt'][$index])
               ) {
                $txt .= $this->list['dd'][$index]->toHtml($step, $dump,
                                                          $comments, $levels);
                $txt .= $this->list['dt'][$index]->toHtml($step, $dump,
                                                          $comments, $levels);
            }
        }

        return $txt;
    }

    // }}} writeInner
}

// }}} \HTML\Common3\Root\Dialog

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */