<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Global: includes global variables for Common3
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
 * @version  SVN: $Id: Globals.php 11 2010-10-10 19:17:21Z tmu $
 * @link     http://pear.php.net/package/\HTML\Common3\Global
 */

// {{{ \HTML\Common3\Globals

/**
 * \HTML\Common3\Global: includes global variables for Common3
 *
 * Implements methods for working with HTML attributes, parsing and generating
 * attribute strings. Port of HTML_Common class for PHP4 originally written by
 * Adam Daniel with contributions from numerous other developers.
 *
 * last updated on 2008-12-29 based on information from
 * http://www.w3.org/TR/2008/WD-html5-20080610/ from 2008-06-10
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 * @final
 */
final class Globals
{
    // {{{ properties

    /**
     * Array of HTML Elements which exists
     *
     * @var      array
     * @access   private
     * @static
     */
    private static $_allElements = array(
        /* A */
        'a' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'abbr' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true
        ),
        'acronym' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true,
            'html' => array(
                '5.0' => array(
                    'strict' => false
                )
            ),
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'address' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'div##',
            '#all' => true
        ),
        'applet' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'object',
            '#all' => true,
            'html' => array(
                '4.01' => array(
                    'strict' => false
                ),
                '5.0' => array(
                    'strict' => false
                )
            ),
            'xhtml' => array(
                '1.0' => array(
                    'strict' => false
                ),
                '1.1' => array(
                    '#all' => false
                ),
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'area' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            ),
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'article' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'div',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'aside' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'div',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'audio' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'object',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        /* B */
        'b' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'strong',
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'base' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            ),
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'bb' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'bdo' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'big' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true,
            'html' => array(
                '5.0' => array(
                    'strict' => false
                )
            ),
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'blockquote' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'body' => array(
            'type' => 'StructureContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'br' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            ),
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'button' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'input',
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false,
                    'empty' => false
                )
            )
        ),
        /* C */
        'canvas' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'caption' => array(
            'type' => 'TableContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'center' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'div##CSS(text-align:center;)',
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            )
        ),
        'cite' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true
        ),
        'code' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true
        ),
        'col' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            )
        ),
        'colgroup' => array(
            'type' => 'TableContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'command' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        /* D */
        'datagrid' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'datalist' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'select',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'datatemplate' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'dd' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'del' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS(text-decoration:strike-trought;)',
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'details' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'dfn' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'deprached' => true,
            'replace' => 'span##CSS()',
            '#all' => true
        ),
        'dialog' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'dl',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'dir' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'ul',
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            )
        ),
        'div' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'dl' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'dt' => array(
            'type' => 'Container',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        /* E */
        'em' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'embed' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            'replace' => 'object',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                ),
                'end' => false
            )
        ),
        'eventsource' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        /* F */
        'fieldset' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'figure' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'div',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'font' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            )
        ),
        'footer' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'div',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'form' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'frame' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true
                ),
                'end' => false
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true
                )
            )
        ),
        'frameset' => array(
            'type' => 'StructureContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true
                )
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true
                )
            )
        ),
        /* H */
        'h1' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'h2' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'h3' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'h4' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'h5' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'h6' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'head' => array(
            'type' => 'StructureContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'header' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'div',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'hr' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            ),
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'html' => array(
            'type' => 'StructureContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        /* I */
        'i' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'iframe' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true,
                    'transitional' => true
                ),
                '5.0' => array(
                    'strict' => true
                )
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            )
        ),
        'img' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            'replace' => 'object',
            '#all' => true,
            'html' => array(
                'end' => false
            ),
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false,
                    'empty' => false
                )
            )
        ),
        'input' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            ),
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'ins' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'isindex' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true,
                    'transitional' => true
                ),
                'end' => false
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            )
        ),
        /* K */
        'kbd' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true
        ),
        /* L */
        'label' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'legend' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'li' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            )
        ),
        'link' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            )
        ),
        /* M */
        'map' => array(
            'type' => 'Container',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'object',
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'mark' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'math' => array( //Element from MATHML namespace
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'namespace' => 'MathML',
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'menu' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'ul',
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true,
                    'transitional' => true
                ),
                '5.0' => array(
                    'strict' => true
                )
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            )
        ),
        'meta' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => true
        ),
        'meter' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        /* N */
        'nav' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'div',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'nest' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'noframes' => array(
            'type' => 'StructureContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            )
        ),
        'noscript' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        /* O */
        'object' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'ol' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'optgroup' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'option' => array(
            'type' => 'Container',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            ),
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        /* P */
        'p' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'param' => array(
            'type' => 'Empty',
            'hasChildren' => false,
            'hasAttributes' => true,
            '#all' => true
        ),
        'pre' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'progress' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        /* Q */
        'q' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        /* R */
        'rp' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'rt' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'ruby' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'rule' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        /* S */
        's' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            )
        ),
        'samp' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true
        ),
        'script' => array(
            'type' => 'Container',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'section' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'div',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'select' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'small' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'source' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'param',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'span' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'strike' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            )
        ),
        'strong' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true
        ),
        'style' => array(
            'type' => 'Container',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'sub' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true
        ),
        'sup' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true,
        ),
        'svg' => array( //Element from SVG namespace
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'namespace' => 'SVG',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        /* T */
        'table' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'tbody' => array(
            'type' => 'TableContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            )
        ),
        'td' => array(
            'type' => 'TableContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            )
        ),
        'textarea' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        'tfoot' => array(
            'type' => 'TableContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            )
        ),
        'th' => array(
            'type' => 'TableContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            )
        ),
        'thead' => array(
            'type' => 'TableContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            )
        ),
        'time' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        'title' => array(
            'type' => 'StructureContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        'tr' => array(
            'type' => 'TableContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true,
            'html' => array(
                'end' => false
            )
        ),
        'tt' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true,
            'html' => array(
                '5.0' => array(
                    'strict' => false
                )
            ),
            'xhtml' => array(
                '2.0' => array(
                    'strict' => false
                )
            )
        ),
        /* U */
        'u' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => false,
            'html' => array(
                '4.01' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            ),
            'xhtml' => array(
                '1.0' => array(
                    'frameset' => true,
                    'transitional' => true
                )
            )
        ),
        'ul' => array(
            'type' => 'BlockContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            '#all' => true
        ),
        /* V */
        'var' => array(
            'type' => 'InlineContainer',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'span##CSS()',
            '#all' => true
        ),
        'video' => array(
            'type' => 'FlowContent',
            'hasChildren' => true,
            'hasAttributes' => true,
            'replace' => 'object',
            '#all' => false,
            'html' => array(
                '5.0' => array(
                    'strict' => true
                )
            )
        ),
        /* Z */
        /* dummy Element for CDATA OR PCDATA */
        'zero' => array(
            'type' => 'PCDATA',
            'hasChildren' => false,
            'hasAttributes' => false,
            '#all' => true
        ),
        'if' => array(
            'type' => 'Dummy',
            'hasChildren' => true,
            'hasAttributes' => false,
            '#all' => true,
            'html' => array(
                'end' => false
            )
        )
    );

    /**
     * Array of Attibutes which exists
     *
     * @var      array
     * @access   private
     * @static
     */
    private static $_allAttributes = array(
        /* Core Attributes */
        'id' => array(
            'type' => '#ID',
            'sc' => true,
            'space' => false
        ),
        'class' => array(
            'type' => '#CNAME',
            'sc' => true
        ),
        'title' => array(
            'type' => '#CNAME'
        ),
        'xml:base' => array(
            'type' => '#URL'
        ),
        'irrelevant' => array(
            'type' => '#EMPTY'
        ),
        /* Language Attributes */
        'dir' => array(
            'type' => array('ltr', 'rtl'),
            'sc' => true,
            'space' => false
        ),
        'lang' => array(
            'type' => '#I18NLANG',
            'sc' => true,
            'replace' => 'xml:lang',
            'space' => false
        ),
        'xml:lang' => array(
            'type' => '#I18NLANG',
            'sc' => true,
            'space' => false
        ),
        /* Style Attributes */
        'style' => array(
            'type' => '#STYLE',
            'sc' => true
        ),
        /* JavaScript Application Attributes */
        'onblur' => array(
            'type' => '#SCRIPT'
        ),
        'onfocus' => array(
            'type' => '#SCRIPT'
        ),
        'onselect' => array(
            'type' => '#SCRIPT'
        ),
        /* JavaScript Interaction Attributes */
        'onclick' => array(
            'type' => '#SCRIPT'
        ),
        'ondblclick' => array(
            'type' => '#SCRIPT'
        ),
        'onkeydown' => array(
            'type' => '#SCRIPT'
        ),
        'onkeyup' => array(
            'type' => '#SCRIPT'
        ),
        'onkeypress' => array(
            'type' => '#SCRIPT'
        ),
        'onmouseover' => array(
            'type' => '#SCRIPT'
        ),
        'onmouseout' => array(
            'type' => '#SCRIPT'
        ),
        'onmousemove' => array(
            'type' => '#SCRIPT'
        ),
        'onmouseup' => array(
            'type' => '#SCRIPT'
        ),
        'onmousedown' => array(
            'type' => '#SCRIPT'
        ),
        /* JavaScript Form Attributes */
        'onsubmit' => array(
            'type' => '#SCRIPT'
        ),
        'onreset' => array(
            'type' => '#SCRIPT'
        ),
        /* JavaScript Input Attributes */
        'onchange' => array(
            'type' => '#SCRIPT'
        ),
        /* JavaScript Page Attributes */
        'onload' => array(
            'type' => '#SCRIPT'
        ),
        'onunload' => array(
            'type' => '#SCRIPT'
        ),
        /* Element related Attributes
         */
        /* td, th
         */
        'abbr' => array(
            'type' => '#CNAME',
            'sc' => true
        ),
        /* form, input
         */
        'accept' => array(
            'type' => '#MIME', /* mime type */
            'sc' => true
        ),
        /* form
         */
        'accept-charset'=> array(
            'type' => '#I18NENCODING',
            'sc' => true
        ),
        /* a, area, button, input, label, legend, textarea
         */
        'accesskey' => array(
            'type' => '##[^0-9a-z\\*\\#]',
            'sc' => true,
            'space' => false
        ),
        /* form
         */
        'action' => array(
            'type' => '#URL'
        ),
        /* applet, caption, col, colgroup, hr, iframe, img, legend, object, table,
         * tbody, tfoot, thead, td, th, tr
         */
        'applet:align' => array(
            'type' => array('top','middle','bottom','left','right'),
            'sc' => true
        ),
        'caption:align' => array(
            'type' => array('top','bottom','left','right'),
            'sc' => true
        ),
        'col:align' => array(
            'type' => array('left','center','right','justify','char'),
            'sc' => true
        ),
        'colgroup:align'=> array(
            'type' => array('left','center','right','justify','char'),
            'sc' => true
        ),
        'hr:align' => array(
            'type' => array('left','center','right'),
            'sc' => true
        ),
        'iframe:align' => array(
            'type' => array('top','middle','bottom','left','right'),
            'sc' => true
        ),
        'img:align' => array(
            'type' => array('top','middle','bottom','left','right'),
            'sc' => true
        ),
        'input:align' => array(
            'type' => array('top','middle','bottom','left','right'),
            'sc' => true
        ),
        'legend:align' => array(
            'type' => array('top','bottom','left','right'),
            'sc' => true
        ),
        'object:align' => array(
            'type' => array('top','middle','bottom','left','right'),
            'sc' => true
        ),
        'table:align' => array(
            'type' => array('left','center','right'),
            'sc' => true
        ),
        'tbody:align' => array(
            'type' => array('left','center','right','justify','char'),
            'sc' => true
        ),
        'tfoot:align' => array(
            'type' => array('left','center','right','justify','char'),
            'sc' => true
        ),
        'thead:align' => array(
            'type' => array('left','center','right','justify','char'),
            'sc' => true
        ),
        'td:align' => array(
            'type' => array('left','center','right','justify','char'),
            'sc' => true
        ),
        'th:align' => array(
            'type' => array('left','center','right','justify','char'),
            'sc' => true
        ),
        'tr:align' => array(
            'type' => array('left','center','right','justify','char'),
            'sc' => true
        ),
        'align' => array(
            'type' => array('left','center','right','justify'),
            'sc' => true,
            'replace' => 'style##text-align:{value};'
        ),
        /* body
         */
        'alink' => array(
            'type' => '#COLOR'
        ),
        /* applet, area, img, input
         */
        'alt' => array(
            'type' => '#CNAME'
        ),
        /* applet, object
         */
        'archive' => array(
            'type' => '#CNAME'
        ),
        /* script
         */
        'async' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* menu
         */
        'autosubmit' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* td, th
         */
        'axis' => array(
            'type' => '#CNAME'
        ),
        /* body
         */
        'background' => array(
            'type' => '#COLOR'
        ),
        /* body, col, table, tr
         */
        'bgcolor' => array(
            'type' => '#COLOR'
        ),
        /* table, img, object, table
         */
        'border' => array(
            'type' => '#NUMBER'
        ),
        /* table
         */
        'cellpadding' => array(
            'type' => '#NUMBER'
        ),
        /* table
         */
        'cellspacing' => array(
            'type' => '#NUMBER'
        ),
        /* col, colgroup, tbody, tfoot, thead, td, th, tr
         */
        'char' => array(
            'type' => '#CNAME',
            'sc' => true
        ),
        /* col, colgroup, tbody, tfoot, thead, td, th, tr
         */
        'charoff' => array(
            'type' => '#NUMBER',
            'sc' => true
        ),
        /* a, link, script
         */
        'charset' => array(
            'type' => '#I18NENCODING',
            'sc' => true
        ),
        /* input
         */
        'checked' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* blockquote, del, ins, q
         */
        'cite' => array(
            'type' => '#URL'
        ),
        /* object
         */
        'classid' => array(
            'type' => '#CNAME',
            'sc' => true
        ),
        /* br
         */
        'clear' => array(
            'type' => array('none','all','left','right'),
            'sc' => true
        ),
        /* applet
         */
        'code' => array(
            'type' => '#CNAME',
            'sc' => true
        ),
        /* applet, object
         */
        'codebase' => array(
            'type' => '#CNAME',
            'sc' => true
        ),
        /* object
         */
        'codetype' => array(
            'type' => '#CNAME',
            'sc' => true
        ),
        /* basefont, font
         */
        'color' => array(
            'type' => '#COLOR',
            'sc' => true
        ),
        /* frameset, textarea */
        'cols' => array(
            'type' => '#NUMBER',
            'sc' => true
        ),
        /* td, th
         */
        'colspan' => array(
            'type' => '#NUMBER',
            'sc' => true
        ),
        /* dir, dl, menu, ol, ul
         */
        'compact' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* rule
         */
        'condition' => array(
            'type' => '#CNAME'
        ),
        /* meta
         */
        'content' => array(
            'type' => '#CNAME'
        ),
        /* audio, video
         */
        'controls' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* a, area
         */
        'coords' => array(
            'type' => '#CNAME',
            'sc' => true
        ),
        /* object
         */
        'data' => array(
            'type' => '#CNAME'
        ),
        /* del, ins, time
         */
        'datetime' => array(
            'type' => '#TIME'
        ),
        /* object
         */
        'declare' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* command
         */
        'default' => array(
            'type' => '#EMPTY'
        ),
        /* script
         */
        'defer' => array(
            'type' => '#EMPTY'
        ),
        /* button, input, optgroup, option, select, textarea
         */
        'disabled' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* form
         */
        'enctype' => array(
            'type' => '#MIME' /* mime type */
        ),
        /* basefont, font
         */
        'face' => array(
            'type' => '#CNAME',
            'sc' => true,
            'replace' => 'style##'
        ),
        /* label
         */
        'for' => array(
            'type' => '#IDREF',
            'sc' => true,
            'space' => false
        ),
        /* table
         */
        'frame' => array(
            'type' => array('void','above','below','hsides','lhs','rhs',
                                 'vsides','box','border')
        ),
        /* frame, iframe
         */
        'frameborder' => array(
            'type' => array('1', '0')
        ),
        /* td, th */
        'headers' => array(
            'type' => '#IDREF'
        ),
        /* applet, iframe, img, object, td, th
         */
        'height' => array(
            'type' => '#NUMBER',
            'zero' => false
        ),
        /* progress
         */
        'high' => array(
            'type' => '#NUMBER'
        ),
        /* command
         */
        'hidden' => array(
            'type' => '#EMPTY'
        ),
        /* a, area, base, link
         */
        'href' => array(
            'type' => '#URL',
            'sc' => true,
            'space' => false
        ),
        /* a, link
         */
        'hreflang' => array(
            'type' => '#I18NLANG',
            'sc' => true,
            'space' => false
        ),
        /* applet, img, object
         */
        'hspace' => array(
            'type' => '#NUMBER'
        ),
        /* meta
         */
        'http-equiv' => array(
            'type' => array('content-type','content-style-type',
                                 'content-script-type','expires','pragma',
                                 'refresh','reply-to','content-language',
                                 'content-length','cache-control',
                                 'last-modified','#CNAME'),
            'sc' => true
        ),
        /* command
         */
        'icon' => array(
            'type' => '#URL'
        ),
        /* img, input
         */
        'ismap' => array(
            'type' => '#EMPTY'
        ),
        /* optgroup, option, command
         */
        'label' => array(
            'type' => '#CNAME'
        ),
        /* script
         */
        'language' => array(
            'type' => '#CNAME'
        ),
        /* body
         */
        'link' => array(
            'type' => '#COLOR'
        ),
        /* frame, iframe, img
         */
        'longdesc' => array(
            'type' => '#URL'
        ),
        /* progress
         */
        'low' => array(
            'type' => '#NUMBER'
        ),
        /* html
         */
        'manifest' => array(
            'type' => '#URL'
        ),
        /* frame, iframe
         */
        'marginheight' => array(
            'type' => '#NUMBER'
        ),
        /* frame, iframe
         */
        'marginwidth' => array(
            'type' => '#NUMBER'
        ),
        /* progress
         */
        'max' => array(
            'type' => '#NUMBER'
        ),
        /* input
         */
        'maxlength' => array(
            'type' => '#NUMBER'
        ),
        /* link, style
         */
        'media' => array(
            'type' => array('all','screen','aural','braille','embossed',
                                 'handheld','print','projection','tty','tv'/*,
                                 '#CNAME'*/)
        ),
        /* form
         */
        'method' => array(
            'type' => array('get', 'post')
        ),
        /* progress
         */
        'min' => array(
            'type' => '#NUMBER'
        ),
        /* rule
         */
        'mode' => array(
            'type' => '#CNAME'
        ),
        /* select
         */
        'multiple' => array(
            'type' => '#EMPTY'
        ),
        /* a, applet, button, form, frame, iframe, img, input, map, meta, object,
         * textarea
         */
        'meta:name' => array(
            'type' => array('abstract','audience','author','copyright',
                                 'date','description','generator','keywords',
                                 'page-type','page-topic','publisher',
                                 'revisit-after','robots','googlebot','msnbot',
                                 'slurp','viewport'/* for IPod */,'#CNAME')
        ),
        'name' => array(
            'type' => '#CNAME',
            'sc' => true,
            'replace' => 'id',
            'space' => false
        ),
        /* area
         */
        'nohref' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* frame
         */
        'noresize' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* hr
         */
        'noshade' => array(
            'type' => '#EMPTY'
        ),
        /* td, th
         */
        'nowrap' => array(
            'type' => '#EMPTY'
        ),
        /* applet
         */
        'object' => array(
            'type' => '#CNAME'
        ),
        /* details
         */
        'open' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* progress
         */
        'optimum' => array(
            'type' => '#NUMBER'
        ),
        /* a, area
         */
        'ping' => array(
            'type' => '#URL'
        ),
        /* source
         */
        'pixelratio' => array(
            'type' => '#NUMBER'
        ),
        /* video
         */
        'poster' => array(
            'type' => '#URL'
        ),
        /* head
         */
        'profile' => array(
            'type' => '#CNAME'
        ),
        /* isindex
         */
        'prompt' => array(
            'type' => '#CNAME'
        ),
        /* command
         */
        'radiogroup' => array(
            'type' => '#CNAME'
        ),
        /* input, textarea
         */
        'readonly' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* a, link, area
         */
        'link:rel' => array(
            'type' => array(
                'alternate',
                'alternate stylesheet',
                'appendix',
                'archives',
                'author',
                //'bookmark',
                'chapter',
                'contents',
                'copyright',
                //'external',
                'feed',
                'first',
                'glossary',
                'help',
                'icon',
                'index',
                'last',
                'license',
                'next',
                //'nofollow',
                //'noreferrer',
                'pingback',
                'prefetch',
                'prev',
                'search',
                'section',
                'sidebar',
                'start',
                'stylesheet',
                'subsection',
                'tag',
                'toc',
                'top',
                'up',
                '#CNAME'
            ),
            'sc' => true
        ),
        'rel' => array(
            'type' => array(
                'alternate',
                'alternate stylesheet',
                'appendix',
                'archives',
                'author',
                'bookmark',
                'chapter',
                'contents',
                'copyright',
                'external',
                'feed',
                'first',
                'glossary',
                'help',
                //'icon',
                'index',
                'last',
                'license',
                'next',
                'nofollow',
                'noreferrer',
                //'pingback',
                //'prefetch',
                'prev',
                'search',
                'section',
                'sidebar',
                'start',
                //'stylesheet',
                'subsection',
                'tag',
                'toc',
                'top',
                'up',
                '#CNAME'
            ),
            'sc' => true
        ),
        /* a, link
         */
        'link:rev' => array(
            'type' => array(
                'alternate',
                'alternate stylesheet',
                'appendix',
                'archives',
                'author',
                //'bookmark',
                'chapter',
                'contents',
                'copyright',
                //'external',
                'feed',
                'first',
                'glossary',
                'help',
                'icon',
                'index',
                'last',
                'license',
                'next',
                //'nofollow',
                //'noreferrer',
                'pingback',
                'prefetch',
                'prev',
                'search',
                'section',
                'sidebar',
                'start',
                'stylesheet',
                'subsection',
                'tag',
                'toc',
                'top',
                'up',
                '#CNAME'
            ),
            'sc' => true
        ),
        'rev' => array(
            'type' => array(
                'alternate',
                'alternate stylesheet',
                'appendix',
                'archives',
                'author',
                'bookmark',
                'chapter',
                'contents',
                'copyright',
                'external',
                'feed',
                'first',
                'glossary',
                'help',
                //'icon',
                'index',
                'last',
                'license',
                'next',
                'nofollow',
                'noreferrer',
                //'pingback',
                //'prefetch',
                'prev',
                'search',
                'section',
                'sidebar',
                'start',
                //'stylesheet',
                'subsection',
                'tag',
                'toc',
                'top',
                'up',
                '#CNAME'
            ),
            'sc' => true
        ),
        /* ol
         */
        'reversed' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* frameset, textarea
         */
        'rows' => array(
            'type' => '#NUMBER'
        ),
        /* td, th
         */
        'rowspan' => array(
            'type' => '#NUMBER'
        ),
        /* table
         */
        'rules' => array(
            'type' => array('none','groups','rows','cols','all')
        ),
        /* iframe
         */
        'sandbox' => array(
            'type' => array(
                'allow-same-origin allow-forms allow-scripts',
                'allow-same-origin allow-forms',
                'allow-same-origin allow-scripts',
                'allow-forms allow-scripts',
                'allow-same-origin',
                'allow-forms',
                'allow-scripts'
            )
        ),
        /* td, th
         */
        'scope' => array(
            'type' => array('col','row','colgroup','rowgroup')
        ),
        /* meta
         */
        'scheme' => array(
            'type' => '#CNAME',
            'sc' => true
        ),
        /* frame, iframe
         */
        'scrolling' => array(
            'type' => array('auto','yes','no'),
            'sc' => true
        ),
        /* iframe
         */
        'seamless' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* option
         */
        'selected' => array(
            'type' => '#EMPTY',
            'sc' => true
        ),
        /* a, area
         */
        'shape' => array(
            'type' => array('default','rect','circle','poly'),
            'sc' => true
        ),
        /* basefont, font, hr, input, select
         */
        'size' => array(
            'type' => '#NUMBER',
            'sc' => true
        ),
        /* col, colgroup
         */
        'span' => array(
            'type' => '#NUMBER',
            'sc' => true
        ),
        /* frame, iframe, img, input, script
         */
        'src' => array(
            'type' => '#URL'
        ),
        /* object
         */
        'standby' => array(
            'type' => '#CNAME'
        ),
        /* ol
         */
        'start' => array(
            'type' => '#NUMBER'
        ),
        /* table
         */
        'summary' => array(
            'type' => '#CNAME'
        ),
        /* a, area, button, input, object, select, textarea
         */
        'tabindex' => array(
            'type' => '#NUMBER'
        ),
        /* a, area, base, link
         */
        'target' => array(
            'type' => array('_self','parent','_top','_blank','#CNAME'),
            'sc' => true,
            'space' => false
        ),
        /* body
         */
        'text' => array(
            'type' => '#COLOR'
        ),
        /* a, button, input, li, object, ol, script, ul
         */
        'button:type' => array(
            'type' => array('button','submit','reset'),
            'sc' => true
        ),
        'input:type' => array(
            'type' => array('text','password','button','submit','reset',
                                 'checkbox','radio','file','hidden','image'),
            'sc' => true
        ),
        'li:type' => array(
            'type' => array('disc','circle','square','1','a','A','i','I'),
            'sc' => true
        ),
        'li:type' => array(
            'type' => '#MIME',
            'sc' => true,
            '_' => false
        ),
        'object:type' => array(
            'type' => '#MIME',
            'sc' => true,
            '_' => false
        ),
        'ol:type' => array(
            'type' => array('1','a','A','i','I'),
            'sc' => true
        ),
        'ul:type' => array(
            'type' => array('disc','circle','square'),
            'sc' => true
        ),
        'script:type' => array(
            'type' => array('text/javascript','text/vbscript'/*,'#CNAME'*/),
            'sc' => true,
            '_' => false
        ),
        'command:type' => array(
            'type' => array('command','checkbox','radio'),
            'sc' => true
        ),
        'menu:type' => array(// for HTML5
            'type' => array('list','toolbar','context'),
            'sc' => true
        ),
        'type' => array(
            'type' => '#CNAME',
            'sc' => true,
            '_' => false
        ),
        /* img, input, object
         */
        'usemap' => array(
            'type' => '#IDREFRAUTE'
        ),
        /* col, colgroup, tbody, tfoot, thead, td, th, tr
         */
        'valign' => array(
            'type' => array('top','middle','bottom','baseline'),
            'sc' => true,
            'replace' => 'style##vertical-align:{value};'
        ),
        /* button, param, input, li
         */
        'li:value' => array(
            'type' => '#NUMBER'
        ),
        'progress:value' => array(
            'type' => '#NUMBER'
        ),
        'value' => array(
            'type' => '#CNAME'
        ),
        /* param
         */
        'valuetype' => array(
            'type' => array('data','ref','object'),
            'sc' => true
        ),
        /* html
         */
        'version' => array(
            'type' => '#CNAME'
        ),
        /* body
         */
        'vlink' => array(
            'type' => '#COLOR'
        ),
        /* applet, img, object */
        'vspace' => array(
            'type' => '#NUMBER'
        ),
        /* applet, col, colgroup, hr, iframe, img, object, pre, table, td, th
         */
        'width' => array(
            'type' => '#NUMBER',
            'zero' => false
        ),
        /* html
         */
        'xmlns' => array(
            'type' => '#CNAME',
            'sc' => true
        ),
        /* html
         */
        'xmlns:xsi' => array(
            'type' => '#CNAME'
        ),
        /* script, pre
         */
        'xml:space' => array(
            'type' => array('preserve')
        ),
        /* html
         */
        'xsi:schemalocation' => array(
            'type' => '#CNAME'
        ),
    );

    /**
     * Array of all possible Doctypes for the document
     *
     * @var      array
     * @access   private
     * @static
     */
    private static $_doctypes = array(
        'html' => array(
            '4.01' => array(
                'strict' => array(
                    'HTML 4.01'
                ),
                'frameset' => array(
                    'HTML 4.01 Frameset'
                ),
                'transitional' => array(
                    'HTML 4.01 Transitional'
                )
            ),
            '5.0' => array(
                'strict' => array(
                    'HTML 5.0'
                ) /*,
                'transitional' => array(
                    'HTML 5.0 Transitional'
                ) /**/
            )
        ),
        'xhtml' => array(
            '1.0' => array(
                'strict' => array(
                    'XHTML 1.0 Strict'
                ),
                'frameset' => array(
                    'XHTML 1.0 Frameset'
                ),
                'transitional' => array(
                    'XHTML 1.0 Transitional'
                )
            ),
            '1.1' => array(
                'strict' => array(
                    'XHTML 1.1'
                )
            ),
            '2.0' => array(
                'strict' => array(
                    'XHTML 2.0'
                )
            )
        )
    );

    /**
     * DTD File for the document
     *
     * @var      array
     * @access   private
     * @static
     */
    private static $_dtd = array(
        'html' => array(
            '4.01' => array(
                'strict' => 'http://www.w3.org/TR/html4/strict.dtd',
                'frameset' => 'http://www.w3.org/TR/html4/frameset.dtd',
                'transitional' => 'http://www.w3.org/TR/html4/loose.dtd'
            ),
            '5.0' => array(
                'strict' => '' /*,
                'transitional' => ''
                /**/
            )
        ),
        'xhtml' => array(
            '1.0' => array(
                'strict' =>
                    'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd',
                'frameset' =>
                    'http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd',
                'transitional' =>
                    'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'
            ),
            '1.1' => array(
                'strict' =>
                    'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'
            ),
            '2.0' => array(
                'strict' => ''
            )
        )
    );

    /**
     * all possible Name spaces for the document
     *
     * @var      array
     * @access   private
     * @static
     */
    private static $_allNamespaces = array(
        'html' => array(
            '4.01' => 'http://www.w3.org/1999/xhtml',
            '5.0' => 'http://www.w3.org/1999/xhtml'
        ),
        'xhtml' => array(
            '1.0' => 'http://www.w3.org/1999/xhtml',
            '1.1' => 'http://www.w3.org/1999/xhtml',
            '2.0' => 'http://www.w3.org/2002/06/xhtml2'
        ),
        'xsi' => array(
            '#all' => 'http://www.w3.org/2001/XMLSchema-instance'
        ),
        'mathml' => array(
            '#all' => 'http://www.w3.org/1998/Math/MathML'
        ),
        'svg' => array(
            '#all' => 'http://www.w3.org/2000/svg'
        ),
        'xlink' => array(
            '#all' => 'http://www.w3.org/1999/xlink'
        ),
        'xml' => array(
            '#all' => 'http://www.w3.org/XML/1998/namespace'
        ),
        'xmlns' => array(
            '#all' => 'http://www.w3.org/2000/xmlns/'
        ),
        'xform' => array(
            '#all' => 'http://www.w3.org/2002/xforms'
        ),
        'xframe' => array(
            '#all' => 'http://www.w3.org/2002/06/xframes/'
        )
    );

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id: Globals.php 11 2010-10-10 19:17:21Z tmu $';

    // }}} properties
    // {{{ getAllAttributes

    /**
     * @access public
     * @return array
     * @static
     */
    public static function getAllAttributes()
    {
        return self::$_allAttributes;
    }

    // }}} getAllAttributes
    // {{{ getAllElements

    /**
     * @access public
     * @return array
     * @static
     */
    public static function getAllElements()
    {
        return self::$_allElements;
    }

    // }}} getAllElements
    // {{{ getAllDocTypes

    /**
     * @access public
     * @return array
     * @static
     */
    public static function getAllDocTypes()
    {
        return self::$_doctypes;
    }

    // }}} getAllDocTypes
    // {{{ getAllDtds

    /**
     * @access public
     * @return array
     * @static
     */
    public static function getAllDtds()
    {
        return self::$_dtd;
    }

    // }}} getAllDtds
    // {{{ getAllNamespaces

    /**
     * @access public
     * @return array
     * @static
     */
    public static function getAllNamespaces()
    {
        return self::$_allNamespaces;
    }

    // }}} getAllNamespaces
    // {{{ isElementEmpty

    /**
     * @access public
     * @return boolean|null NULL, if not defined in Globals
     * @static
     */
    public static function isElementEmpty($elementName, $type = 'xhtml',
    $version = '1.0')
    {
        $allElements = self::$_allElements;

        if (isset($allElements[$elementName][$type][$version]['empty'])) {
            if ($allElements[$elementName][$type][$version]['empty'] === true) {
                return true;
            } else {
                return false;
            }
        } else {
            return null;
        }
    }

    // }}} isElementEmpty
    // {{{ isElementEnabled

    /**
     * @access public
     * @return boolean|null NULL, if not defined in Globals
     * @static
     */
    public static function isElementEnabled($elementName, $type = 'xhtml',
    $version = '1.0', $variant = 'strict')
    {
        $allElements = self::$_allElements;

        if (isset($allElements[$elementName][$type][$version][$variant])) {
            $enabled = $allElements[$elementName][$type][$version][$variant];
        } elseif (isset($allElements[$elementName][$type][$version]['#all'])) {
            $enabled = $allElements[$elementName][$type][$version]['#all'];
        } elseif (isset($allElements[$elementName][$type]['#all'])) {
            $enabled = $allElements[$elementName][$type]['#all'];
        } elseif (isset($allElements[$elementName]['#all'])) {
            $enabled = $allElements[$elementName]['#all'];
        } else {
            $enabled = false;
        }

        if ($enabled) {
            return true;
        } else {
            return false;
        }
    }

    // }}} isElementEnabled
    // {{{ getReplacement

    /**
     * @access public
     * @return string|null NULL, if no replacement is defined
     * @static
     */
    public static function getReplacement($elementName)
    {
        $allElements = self::$_allElements;

        if (isset($allElements[$elementName]['replace'])) {
            return $allElements[$elementName]['replace'];
        } else {
            return null;
        }
    }

    // }}} getReplacement
    // {{{ getElementChildren

    /**
     * @access public
     * @return boolean
     * @static
     */
    public static function getElementChildren($elementName)
    {
        $allElements = self::$_allElements;

        if (isset($allElements[$elementName]['hasChildren'])) {
            return (boolean) $allElements[$elementName]['hasChildren'];
        } else {
            return false;
        }
    }

    // }}} getElementChildren
    // {{{ isAttributeLowerCased

    /**
     * @access public
     * @return boolean
     * @static
     */
    public static function isAttributeLowerCased($elementName, $attribute)
    {
        $allAttributes = self::$_allAttributes;
        $typeName      = self::getTypeName($elementName, $attribute);

        if (isset($allAttributes[$typeName]['sc'])) {
            return (boolean) $allAttributes[$typeName]['sc'];
        } else {
            return false;
        }
    }

    // }}} isAttributeLowerCased
    // {{{ getTypeName

    /**
     * @access public
     * @return string|null NULL, if the attribute is not defined
     * @static
     */
    public static function getTypeName($elementName, $attribute)
    {
        $allAttributes = self::$_allAttributes;

        if (array_key_exists($elementName . ':' . $attribute, $allAttributes)) {
            $typeName = $elementName . ':' . $attribute;
        } elseif (array_key_exists($attribute, $allAttributes)) {
            $typeName = $attribute;
        } else {
            //the attribute is not defined inside the global attributes
            $typeName = null;
        }

        return $typeName;
    }

    // }}} getTypeName
    // {{{ getAttributeType

    /**
     * @access public
     * @return mixed
     * @static
     */
    public static function getAttributeType($elementName, $attribute)
    {
        $allAttributes = self::$_allAttributes;
        $typeName      = self::getTypeName($elementName, $attribute);

        if (isset($allAttributes[$typeName]['type'])) {
            return $allAttributes[$typeName]['type'];
        } else {
            return null;
        }
    }

    // }}} getAttributeType
    // {{{ getAttributeReplacement

    /**
     * @access public
     * @return string|null
     * @static
     */
    public static function getAttributeReplacement($elementName, $attribute)
    {
        $allAttributes = self::$_allAttributes;
        $typeName      = self::getTypeName($elementName, $attribute);

        if (isset($allAttributes[$typeName]['replace'])) {
            return $allAttributes[$typeName]['replace'];
        } else {
            return null;
        }
    }

    // }}} getAttributeReplacement
    // {{{ getAttributeHasSpaces

    /**
     * @access public
     * @return string|null
     * @static
     */
    public static function getAttributeHasSpaces($elementName, $attribute)
    {
        $allAttributes = self::$_allAttributes;
        $typeName      = self::getTypeName($elementName, $attribute);

        if (isset($allAttributes[$typeName]['space'])) {
            return (boolean) $allAttributes[$typeName]['space'];
        } else {
            return true;
        }
    }

    // }}} getAttributeHasSpaces
    // {{{ isUnderScoreAllowed

    /**
     * @access public
     * @return boolean
     * @static
     */
    public static function isUnderScoreAllowed($elementName, $attribute)
    {
        $allAttributes = self::$_allAttributes;
        $typeName      = self::getTypeName($elementName, $attribute);

        if (isset($allAttributes[$typeName]['_'])) {
            return (boolean) $allAttributes[$typeName]['_'];
        } else {
            return false;
        }
    }

    // }}} isUnderScoreAllowed
}

// }}} \HTML\Common3\Global

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */