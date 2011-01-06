<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3;

/* vim: __set expandtab tabstop=4 shiftwidth=4 __set softtabstop=4: */

/**
 * \HTML\Common3\Collection: This class implements Collection object in PHP
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
 * @author   Diogo Souza da Silva <manifesto@manifesto.blog.br>
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/\HTML\Common3\
 */

// {{{ \HTML\Common3\Collection

/**
 * Iterator Class for Common3
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Diogo Souza da Silva <manifesto@manifesto.blog.br>
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Collectionimplements \Iterator
{
    // {{{ properties

    /**
     * length of this Collection
     *
     * @var      integer
     * @access   protected
     */
    public $length = 0;

    /**
     * Array with all Elements of this Collection
     *
     * @var      array
     * @access   private
     */
    private $_elements = array();

    // }}} properties
    // {{{ __construct

    /**
     * Class constructor
     *
     * @param array|\HTML\Common3\Collection $array Array including all Elements which
     *                                             should be part of this
     *                                             Collection in the Beginning
     *
     * @access public
     * @return void
     */
    public function __construct($array = null)
    {
        if (is_array($array)) {
            $this->_elements = $array;
            $this->count();
        } elseif ($array instanceof \HTML\Common3\Collection) {
            $this->_elements = $array->toArray();
            $this->count();
        }
    }

    // }}} __construct
    // {{{ merge

    /**
     * Join(merge) an array or a collection into this one
     *
     * @param array|\HTML\Common3\Collection $array Array including all Elements which
     *                                             should be merged to this
     *                                             Collection
     *
     * @access public
     * @return \HTML\Common3\Collection
     */
    public function merge($array)
    {
        if (is_array($array)) {
            $this->_elements = array_merge($this->_elements, $array);
        } elseif ($array instanceof \HTML\Common3\Collection) {
            $this->_elements = array_merge($this->_elements, $array->toArray());
        }

        $this->count();

        return $this;
    }

    // }}} merge
    // {{{ add

    /**
     * Adds an object into collection
     *    if arg1 only is given, it will be the item at last index
     *    if arg1 and arg2 are given, arg1 will be the index(key) and
     *                                arg2 will be the value
     *
     * @param string $arg1 key or value for the new collection item
     * @param string $arg2 value for the new collection item
     *
     * @access public
     * @return \HTML\Common3\Collection
     */
    public function add($arg1, $arg2 = '')
    {
        if (!is_string($arg1) || !is_string($arg2)) {
            return $this;
        }

        if (!$arg2) {
            if (!array_key_exists($arg1, $this->_elements)) {
                $this->__set($arg1, $arg1);
            }
        } else {
            if (!array_key_exists($arg1, $this->_elements)) {
                $this->__set($arg1, $arg2);
            }
        }

        $this->count();

        return $this ;
    }

    // }}} add
    // {{{ append

    /**
     * Adds value at last index
     *
     * @param string $value value for the new collection item
     *
     * @access public
     * @return \HTML\Common3\Collection
     * @see    add()
     */
    public function append($value)
    {
        $this->_elements[] = $value;
        $this->count();

        return $this;
    }

    // }}} append
    // {{{ prepend

    /**
     * Adds value at last index
     *
     * @param string $value value for the new collection item
     *
     * @access public
     * @return \HTML\Common3\Collection
     * @see    add()
     */
    public function prepend($value)
    {
        array_unshift($this->_elements, $value);
        $this->count();

        return $this;
    }

    // }}} prepend
    // {{{ replace

    /**
     * Adds value at last index
     *
     * @param string $value value for the new collection item
     *
     * @access public
     * @return \HTML\Common3\Collection
     * @see    add()
     */
    public function replace($value)
    {
        $this->clear();

        $this->_elements[] = $value;
        $this->count();

        return $this;
    }

    // }}} replace
    // {{{ asort

    /**
     * Sort by values
     *
     * @param integer $flags sort_flags for sorting
     *                       Possible Constant Values:
     *                         SORT_REGULAR
     *                         SORT_NUMERIC
     *                         SORT_STRING
     *                         SORT_LOCALE_STRING
     *
     * @access public
     * @return \HTML\Common3\Collection
     */
    public function asort($flags = SORT_REGULAR)
    {
        asort($this->_elements, $flags);

        return $this;
    }

    // }}} asort
    // {{{ ksort

    /**
     * sort by key
     *
     * @param integer $flags sort_flags for sorting
     *                       Possible Constant Values:
     *                         SORT_REGULAR
     *                         SORT_NUMERIC
     *                         SORT_STRING
     *                         SORT_LOCALE_STRING
     *
     * @access public
     * @return \HTML\Common3\Collection
     */
    public function ksort($flags = SORT_REGULAR)
    {
        ksort($this->_elements, $flags);

        return $this;
    }

    // }}} ksort
    // {{{ sort

    /**
     * sort by natural order
     *
     * @param integer $flags sort_flags for sorting
     *                       Possible Constant Values:
     *                         SORT_REGULAR
     *                         SORT_NUMERIC
     *                         SORT_STRING
     *                         SORT_LOCALE_STRING
     *
     * @access public
     * @return \HTML\Common3\Collection
     */
    public function sort($flags = SORT_REGULAR)
    {
        sort($this->_elements, $flags);

        return $this;
    }

    // }}} sort
    // {{{ count

    /**
     * count number of items
     *
     * @access public
     * @return integer
     */
    public function count()
    {
        $this->length = count($this->_elements);

        return $this->length;
    }

    // }}} count
    // {{{ remove

    /**
     * Remove the $key item
     *
     * @param string $key Key for the Search inside the Collection
     *
     * @access public
     * @return \HTML\Common3\Collection
     */
    public function remove($key)
    {
        if (array_key_exists((string) $key, $this->_elements)) {
            unset($this->_elements[(string) $key]);

            $this->count();
        }

        return $this;
    }

    // }}} remove
    // {{{ keyExists

    /**
     * Verifies if this key is filled
     *
     * @param string $key Key for the Search inside the Collection
     *
     * @access public
     * @return boolean
     */
    public function keyExists($key)
    {
        return array_key_exists((string) $key, $this->_elements);
    }

    // }}} keyExists
    // {{{ next

    /**
     * Moves the cursor a step foward
     *
     * @access public
     * @return mixed
     */
    public function next()
    {
        return next($this->_elements);
    }

    // }}} next
    // {{{ seek

    /**
     * Moves cursor to given key
     *
     * @param string $key Key for the Search inside the Collection
     *
     * @access public
     * @return boolean
     */
    public function seek($key)
    {
        $key = (string) $key;
        $this->rewind();

        while ($this->valid()) {
            if ($this->key() == $key) {
                return true;
            }

            $this->next();
        }

        return false;
    }

    // }}} seek
    // {{{ search

    /**
     * Moves cursor to given key
     *
     * @param string $key Key for the Search inside the Collection
     *
     * @access public
     * @return boolean
     * @see    seek()
     */
    public function search($key)
    {
        return $this->seek($key);
    }

    // }}} search
    // {{{ back

    /**
     * Moves the cursor a step back
     *
     * @access public
     * @return mixed
     */
    public function back()
    {
        return prev($this->_elements);
    }

    // }}} back
    // {{{ prev

    /**
     * Moves the cursor a step back
     *
     * @access public
     * @return mixed
     * @see    back()
     */
    public function prev()
    {
        return $this->back();
    }

    // }}} prev
    // {{{ rewind

    /**
     * Puts the cursor at start
     *
     * @access public
     * @return mixed
     */
    public function rewind()
    {
        return reset($this->_elements);
    }

    // }}} rewind
    // {{{ first

    /**
     * Puts the cursor at start
     *
     * @access public
     * @return mixed
     * @see    rewind()
     */
    public function first()
    {
        return $this->rewind();
    }

    // }}} first
    // {{{ forward

    /**
     * Puts cursor at the end
     *
     * @access public
     * @return mixed
     */
    public function forward()
    {
        return end($this->elemets);
    }

    // }}} forward
    // {{{ last

    /**
     * Puts cursor at the end
     *
     * @access public
     * @return mixed
     * @see    forward
     */
    public function last()
    {
        return $this->forward();
    }

    // }}} last
    // {{{ current

    /**
     * Return the item in the cursor point
     *
     * @access public
     * @return mixed
     */
    public function current()
    {
        return current($this->_elements);
    }

    // }}} current
    // {{{ currentKey

    /**
     * Returns Actual cursor key
     *
     * @access public
     * @return mixed
     */
    public function currentKey()
    {
        return key($this->_elements);
    }

    // }}} currentKey
    // {{{ key

    /**
     * Returns Actual cursor key
     *
     * @access public
     * @return mixed
     * @see    currentKey()
     */
    public function key()
    {
        return $this->currentKey();
    }

    // }}} key
    // {{{ valid

    /**
     * Check if cursor is at a valid item
     *
     * @access public
     * @return boolean
     */
    public function valid()
    {
        if (!is_null($this->key())) {
            return true;
        } else {
            return false ;
        }
    }

    // }}} valid
    // {{{ isValid

    /**
     * same as valid()
     *
     * @access public
     * @return boolean
     * @see    valid()
     */
    public function isValid()
    {
        return $this->valid();
    }

    // }}} isValid
    // {{{ __get

    /**
     * Returns object for a given key
     *
     * @param string $key Key for the Search inside the Collection
     *
     * @access public
     * @return null|Collection Item
     */
    public function __get($key)
    {
        $key = (string) $key;

        if (isset($this->_elements[$key])) {
            return $this->_elements[$key];
        } else {
            return null;
        }
    }

    // }}} __get
    // {{{ get

    /**
     * Returns object for a given key
     *
     * @param string $key Key for the Search inside the Collection
     *
     * @access public
     * @return null|Collection Item
     * @see    __get()
     */
    public function get($key)
    {
        return $this->__get($key);
    }

    // }}} get
    // {{{ __set

    /**
     * sets the value for a given key
     * return the new element
     *
     * @param string $key  Key for the Search inside the Collection
     * @param mixed  $item Value for the Collection Item
     *
     * @access public
     * @return null|Collection Item
     */
    public function __set($key, $item)
    {
        $key = (string) $key;

        $this->_elements[$key] = $item;
        $this->count();

        return $this->__get($key);
    }

    // }}} __set
    // {{{ set

    /**
     * sets the value for a given key
     * return the new element
     *
     * @param string $key  Key for the Search inside the Collection
     * @param mixed  $item Value for the Collection Item
     *
     * @access public
     * @return null|Collection Item
     * @see    __set()
     */
    public function set($key, $item)
    {
        return $this->__set($key, $item);
    }

    // }}} set
    // {{{ clear

    /**
     * resets all the collection, including keys
     *
     * @access public
     * @return \HTML\Common3\Collection
     */
    public function clear()
    {
        $this->_elements = array();
        $this->length    = 0;

        return $this ;
    }

    // }}} clear
    // {{{ size

    /**
     * return the size of the collection
     *
     * @access public
     * @return integer
     * @see    count()
     */
    public function size()
    {
        return $this->count();
    }

    // }}} size
    // {{{ isEmpty

    /**
     * returns if the collection is empty or not
     *
     * @access public
     * @return boolean
     * @see    count()
     */
    public function isEmpty()
    {
        if ($this->count() < 1) {
            return true;
        } else {
            return false;
        }
    }

    // }}} isEmpty
    // {{{ contains

    /**
     * check if given object exists in collection
     *
     * @param mixed $obj Object|Item which should be searched inside the Collection
     *
     * @access public
     * @return boolean
     * @see    indexOf
     */
    public function contains($obj)
    {
        if ($this->indexOf($obj) === null) {
            return false;
        } else {
            return true;
        }
    }

    // }}} contains
    // {{{ indexOf

    /**
     * Return the (first) index(key) of given object
     *
     * @param mixed $obj Object|Item which should be seached inside the Collection
     *
     * @access public
     * @return mixed the index of the found Item, NULL if not found
     */
    public function indexOf($obj)
    {
        foreach ($this->_elements as $k => $element) {
            if ($element === $obj) {
                $this->rewind();
                return $k ;
            }
        }
        $this->rewind();

        return null;
    }

    // }}} indexOf
    // {{{ lastIndexOf

    /**
     * returns last index(key) of given object
     *
     * @param mixed $obj Object|Item which should be seached inside the Collection
     *
     * @access public
     * @return mixed the index of the found Item, NULL if not found
     */
    public function lastIndexOf($obj)
    {
        $return = null;

        foreach ($this->_elements as $k => $element) {
            if ($element === $obj) {
                $return = $k;
            }
        }
        $this->rewind();

        return $return;
    }

    // }}} lastIndexOf
    // {{{ subCollection

    /**
     * Return a new collection with a part of this collection
     *
     * @param integer $start first possition of the original Collection for the new
     *                       Collection
     * @param integer $end   last possition of the original Collection for the new
     *                       Collection
     *
     * @access public
     * @return \HTML\Common3\Collection|null
     */
    public function subCollection($start, $end)
    {
        $start = (int) $start;
        $end   = (int) $end;

        if ($start == 0 && $end == 0) {
            return null;
        }

        //sort start  + end, if they are in wrong order
        if ($start > $end) {
            $dummy = $end;
            $end   = $start;
            $start = $dummy;
        }

        $new = new Collection();
        $i   = 0;

        foreach ($this->_elements as $k => $element) {
            if ($i <= $end && $i >= $start) {
                $new->add($element);
            }

            $i++;
        }
        $this->rewind();

        return $new;
    }

    // }}} subCollection
    // {{{ trimToSize

    /**
     * Cut the array to given size
     *
     * @param integer $size new Size for the Collection
     *
     * @access public
     * @return \HTML\Common3\Collection
     */
    public function trimToSize($size)
    {
        $t               = array_chunk($this->_elements, (int) $size, true);
        $this->_elements = $t[0];
        $this->length    = count($this->_elements);

        return $this;
    }

    // }}} trimToSize
    // {{{ toXml

    /**
     * Return the xml of this collection
     *
     * @access public
     * @return string
     */
    public function toXml()
    {
        $xml = "\n<Collection>";
        foreach ($this->_elements as $k=>$v) {
            $xml .= "\n\t<element key=\"{$k}\"";
            if (is_string($v)) {
                $xml .= "value=\"{$v}\">";
            } else {
                $xml .= ">";
                if (is_object($v) && method_exists($v, "toXml()")) {
                    $xml .= $v->toXml();
                } elseif (is_object($v) && method_exists($v, "__toString()")) {
                    $xml .= $v->__toString();
                }
            }
            $xml .= "</element>";
        }
        $xml .= "\n</Collection>";
        $this->rewind();

        return $xml ;
    }

    // }}} toXml
    // {{{ toArray

    /**
     * Returns as an array of all Collection items
     *
     * @access public
     * @return array
     */
    public function toArray()
    {
        return $this->_elements;
    }

    // }}} toArray
    // {{{ asArray

    /**
     * Alias to __toArray()
     *
     * @access public
     * @return array
     * @see    __toArray()
     */
    public function asArray()
    {
        return $this->__toArray();
    }

    // }}} asArray
}

// }}} \HTML\Common3\Collection

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */