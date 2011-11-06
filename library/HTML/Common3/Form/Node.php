<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Form;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * Abstract base class for all Common3 Form Elements and Containers
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
 *    * Redistributions of source code must retain the above copyright
 *      notice, this list of conditions and the following disclaimer.
 *    * Redistributions in binary form must reproduce the above copyright
 *      notice, this list of conditions and the following disclaimer in the
 *      documentation and/or other materials provided with the distribution.
 *    * The names of the authors may not be used to endorse or promote products
 *      derived from this software without specific prior written permission.
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
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/HTMLCommon\
 */

/**
 * base class for HTMLCommon\
 */
use HTML\Common3 as HTMLCommon;

/**
 * class Interface for HTMLCommon\
 */
use HTML\Common3\ElementsInterface;

// {{{ HTMLCommon\Form\Node

/**
 * Abstract base class for all Common3 Form Elements and Containers
 *
 * This class is mostly here to define the interface that should be implemented
 * by the subclasses. It also contains static methods handling generation
 * of unique ids for elements which do not have ids explicitly set.
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/HTMLCommon\
 * @abstract
 */
abstract class Node extends HTMLCommon implements ElementsInterface
{
    // {{{ properties

    /**
     * Element's "frozen" status
     *
     * @var      boolean
     */
    protected $_frozen = false;

    /**
     * Whether element's value should persist when element is frozen
     *
     * @var      boolean
     */
    protected $_persistent = false;

    /**
     * the label for the element
     *
     * @var      pointer
     */
    protected $_label = null;

    /**
     * Element containing current
     *
     * @var      HTMLCommon\Form_Container
     */
    protected $_container = null;

    /**
     * SVN Version for this class
     *
     * @var     string
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ getLabel

    /**
     * Returns the element's label
     *
     * @return string|null
     */
    public function getLabel()
    {
        if ($this->label !== null) {
            return $this->label;
        }
        return null;
    }

    // }}} getLabel
    // {{{ setLabel

    /**
     * Sets the element's label(s)
     *
     * @param string $label Label for the element
     *
     * @return HTMLCommon\Form\Node
     */
    public function setLabel($label)
    {
        $this->label = (string) $label;
        return $this;
    }

    // }}} setLabel
    // {{{ toggleFrozen

    /**
     * Changes the element's frozen status
     *
     * @param boolean $freeze Whether the element should be frozen or editable. If
     *                        omitted, the method will not change the frozen status,
     *                        just return its current value
     *
     * @return boolean Old value of element's frozen status
     */
    public function toggleFrozen($freeze = null)
    {
        $old = $this->frozen;
        if (null !== $freeze) {
            $this->frozen = (boolean)$freeze;
        }
        return $old;
    }

    // }}} toggleFrozen
    // {{{ persistentFreeze

    /**
     * Changes the element's persistent freeze behaviour
     *
     * If persistent freeze is on, the element's value will be kept (and
     * submitted) in a hidden field when the element is frozen.
     *
     * @param boolean $persistent New value for "persistent freeze". If omitted, the
     *                            method will not set anything, just return the
     *                            current value of the flag.
     *
     * @return boolean Old value of "persistent freeze" flag
     */
    public function persistentFreeze($persistent = null)
    {
        $old = $this->persistent;
        if (null !== $persistent) {
            $this->persistent = (boolean)$persistent;
        }
        return $old;
    }

    // }}} persistentFreeze
    // {{{ setContainer

    /**
     * Adds the link to the element containing current
     *
     * @param HTMLCommon\Form_Container $container Element containing the current
     *                                               one,
     *                                               null if the link should really
     *                                               be removed (if removing from
     *                                               container)
     *
     * @throws HTMLCommon\InvalidArgumentException If trying to set a
     *                               child of an element as its container
     * @return HTMLCommon\Form\Node
     */
    protected function setContainer(HTMLCommon\Form_Container $container = null)
    {
        if (null !== $container) {
            $check = $container;
            do {
                if ($this === $check) {
                    throw new HTMLCommon\InvalidArgumentException(
                        'Cannot set an element or its child as its own container'
                    );
                }
            } while ($check = (boolean) $check->getContainer());

            if (null !== $this->container && $container !== $this->container) {
                $this->container->removeChild($this);
            }
        }

        $this->container = $container;        return $this;
    }

    // }}} setContainer
    // {{{ getContainer

    /**
     * Returns the element containing current
     *
     * @return HTMLCommon\Form_Container|null
     */
    public function getContainer()
    {
        return $this->container;
    }

    // }}} getContainer
}

// }}} HTMLCommon\Form\Node

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */