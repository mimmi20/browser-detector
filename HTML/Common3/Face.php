<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Face:
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
 * @category  HTML
 * @package   \HTML\Common3\
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/bsd-license.php New BSD License
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/\HTML\Common3\
 */

// {{{ \HTML\Common3\Face

interface Face
{
    public function __construct($attributes = null,
    \HTML\Common3 $parent = null, \HTML\Common3 $html = null);
    public static function apiVersion();
    public function getApiVersion();
    public function getVersion();
    public function getElementName();
    public function setAttribute($name, $value = null);
    public function getAttribute($name);
    public function getWatchedAttributes();
    public function setOption($name, $value);
    public function getOption($name);
    public function getElementEmpty();
    public function getIsRootElement();
    public function getElements();
    public function setDisabled($disabled = false);
    public function getDisabled();
    public function getParent();
    public function getHtml();
    public function setCache($cache = false);
    public function getCache();
    public function setDoctype($type = 'XHTML 1.0 Strict');
    public function getDoctype($asString = false);
    public function setMime($mime = 'text/html');
    public function getMime();
    public function getPosElements();
    public function getForbidElements();
    public function getPosAttributes();
    public function setIDs(array $elements);
    public function getIDs();
    public function setElementNamespace($namespace = '');
    public function setNamespace($namespace = '', $prefix = '');
    public function setAddToDtd($addToDtd = false);
    public function getAddToDtd();
    public function setLang($lang);
    public function getLang();
    public function existsAttribute($attr);
    public function setAttributes($attributes);
    public function getAttributes($asString = false);
    public function mergeAttributes($attributes, $parse = true);
    public function removeAttribute($attribute);
    public function setId($id = null);
    public function getId();
    public function updateAttributes($attributes);
    public function getName();
    public function setName($name);
    public function setTabOffset($offset);
    public function setIndentLevel($level);
    public function getTabOffset();
    public function getIndentLevel();
    public function setTab($tab = "    ");
    public function getTab();
    public function setLineEnd($break = "\12");
    public function getLineEnd();
    public function setComment($comment);
    public function getComment();
    public function setCharset($charset = 'iso-8859-1');
    public function charset($newCharset = null);
    public function getCharset();
    public function changeLevel($level = null, $recursive = true);
    public function __set($name, $value);
    public function __get($name);
    public function __isset($name);
    public function __unset($name);
    public function __toString();
    public function __call($m, $a);
    public function getEmpty();
    public function setMimeEncoding($mime = 'text/html');
    public function getMimeEncoding();
    public function getType();
    public function isEmpty();
    public function isEnabled();
    public function disable();
    public function enable();
    public function getChildren();
    public function count();
    public function addElement($type, $attributes = null, $flag = HTML_APPEND);
    public function getElementById($id);
    public function getElementsByName($name);
    public function toHtml($step = 0, $dump = false, $comments = false,
                           $levels = true);
    public function toFile($filename);
    public function display();
    public function displayInner();
    public function writeInner($dump = false, $comments = false, $levels = true);
    public function setValue($value, $flag = HTML_REPLACE);
    public function getValue();
    public function getDoctypeString();
    public function replace($str, $what = '');
    public function getRoot();
    public function isRoot();
    public function addDtdAttribute($elementName, $attribute, $type = 'CDATA',
        $need = '#IMPLIED');
    public function setAddingToDtd($addToDtd = false);
    public function getAddingToDtd();
}

// }}} \HTML\Common3\Face

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */