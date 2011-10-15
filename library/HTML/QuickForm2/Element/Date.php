<?php
/**
 * Date element
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * Copyright (c) 2006-2011, Alexey Borzov <avb@php.net>,
 *                          Bertrand Mansion <golgote@mamasam.com>
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
 * @category   HTML
 * @package    HTML_QuickForm2
 * @author     Alexey Borzov <avb@php.net>
 * @author     Bertrand Mansion <golgote@mamasam.com>
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @version    SVN: $Id: Date.php 317439 2011-09-28 16:08:55Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Base class for HTML_QuickForm2 group of elements
 */
require_once 'HTML/QuickForm2/Container/Group.php';
/**
 * Base class for HTML_QuickForm2 select element
 */
require_once 'HTML/QuickForm2/Element/Select.php';

/**
 * Class for a group of elements used to input dates (and times).
 *
 * @category   HTML
 * @package    HTML_QuickForm2
 * @author     Alexey Borzov <avb@php.net>
 * @author     Bertrand Mansion <golgote@mamasam.com>
 * @version    Release: 0.6.1
 */
class HTML_QuickForm2_Element_Date extends HTML_QuickForm2_Container_Group
{
    public function getType()
    {
        return 'date';
    }

   /**
    * Various options to control the element's display.
    * @var      array
    */
    protected $data = array(
        'format'           => 'dMY',
        'minYear'          => 2001,
        'maxYear'          => null, // set in the constructor
        'addEmptyOption'   => false,
        'emptyOptionValue' => '',
        'emptyOptionText'  => '&nbsp;',
        'optionIncrement'  => array('i' => 1, 's' => 1),
        // request #4061: max and min hours (only for 'H' modifier)
        'minHour'          => 0,
        'maxHour'          => 23,
        // request #5957: max and min months
        'minMonth'         => 1,
        'maxMonth'         => 12
    );

   /**
    * Language code
    * @var  string
    */
    protected $language = null;

   /**
    * Message provider for option texts
    * @var  callback|HTML_QuickForm2_MessageProvider
    */
    protected $messageProvider;

   /**
    * Class constructor
    *
    * The following keys may appear in $data array:
    * - 'messageProvider': a callback or an instance of a class implementing
    *   HTML_QuickForm2_MessageProvider interface, this will be used to get
    *   localized names of months and weekdays. Some of the default ones will
    *   be used if not given.
    * - 'language': date language, use 'locale' here to display month / weekday
    *   names according to the current locale.
    * - 'format': Format of the date, based on PHP's date() function.
    *   The following characters are currently recognised in format string:
    *   <pre>
    *       D => Short names of days
    *       l => Long names of days
    *       d => Day numbers
    *       M => Short names of months
    *       F => Long names of months
    *       m => Month numbers
    *       Y => Four digit year
    *       y => Two digit year
    *       h => 12 hour format
    *       H => 24 hour format
    *       i => Minutes
    *       s => Seconds
    *       a => am/pm
    *       A => AM/PM
    *   </pre>
    * - 'minYear': Minimum year in year select
    * - 'maxYear': Maximum year in year select
    * - 'addEmptyOption': Should an empty option be added to the top of
    *    each select box?
    * - 'emptyOptionValue': The value passed by the empty option.
    * - 'emptyOptionText': The text displayed for the empty option.
    * - 'optionIncrement': Step to increase the option values by (works for 'i' and 's')
    * - 'minHour': Minimum hour in hour select (only for 24 hour format!)
    * - 'maxHour': Maximum hour in hour select (only for 24 hour format!)
    * - 'minMonth': Minimum month in month select
    * - 'maxMonth': Maximum month in month select
    *
    * @param    string  Element name
    * @param    mixed   Attributes (either a string or an array)
    * @param    array   Element data (label, options and data used for element creation)
    */
    public function __construct($name = null, $attributes = null, array $data = array())
    {
        if (isset($data['messageProvider'])) {
            if (!is_callable($data['messageProvider'])
                && !$data['messageProvider'] instanceof HTML_QuickForm2_MessageProvider
            ) {
                throw new HTML_QuickForm2_InvalidArgumentException(
                    "messageProvider: expecting a callback or an implementation"
                    . " of HTML_QuickForm2_MessageProvider"
                );
            }
            $this->messageProvider = $data['messageProvider'];
        } else {
            if (isset($data['language']) && 'locale' == $data['language']) {
                HTML_QuickForm2_Loader::loadClass('HTML_QuickForm2_MessageProvider_Strftime');
                $this->messageProvider = new HTML_QuickForm2_MessageProvider_Strftime();
            } else {
                HTML_QuickForm2_Loader::loadClass('HTML_QuickForm2_MessageProvider_Default');
                $this->messageProvider = HTML_QuickForm2_MessageProvider_Default::getInstance();
            }
        }
        if (isset($data['language'])) {
            $this->language = $data['language'];
        }
        unset($data['messageProvider'], $data['language']);

        // http://pear.php.net/bugs/bug.php?id=18171
        $this->data['maxYear'] = date('Y');

        parent::__construct($name, $attributes, $data);

        $backslash = false;
        $separators = array();
        $separator =  '';

        for ($i = 0, $length = strlen($this->data['format']); $i < $length; $i++) {
            $sign = $this->data['format'][$i];
            if ($backslash) {
                $backslash  = false;
                $separator .= $sign;
            } else {
                $loadSelect = true;
                switch ($sign) {
                    case 'D':
                        // Sunday is 0 like with 'w' in date()
                        $options = $this->messageProvider instanceof HTML_QuickForm2_MessageProvider
                                   ? $this->messageProvider->get(array('date', 'weekdays_short'), $this->language)
                                   : call_user_func($this->messageProvider, array('date', 'weekdays_short'), $this->language);
                        break;
                    case 'l':
                        $options = $this->messageProvider instanceof HTML_QuickForm2_MessageProvider
                                   ? $this->messageProvider->get(array('date', 'weekdays_long'), $this->language)
                                   : call_user_func($this->messageProvider, array('date', 'weekdays_long'), $this->language);
                        break;
                    case 'd':
                        $options = $this->createOptionList(1, 31);
                        break;
                    case 'M':
                    case 'm':
                    case 'F':
                        $options = $this->createOptionList(
                            $this->data['minMonth'],
                            $this->data['maxMonth'],
                            $this->data['minMonth'] > $this->data['maxMonth'] ? -1 : 1
                        );
                        if ('M' == $sign || 'F' == $sign) {
                            $key   = 'M' == $sign ? 'months_short' : 'months_long';
                            $names = $this->messageProvider instanceof HTML_QuickForm2_MessageProvider
                                     ? $this->messageProvider->get(array('date', $key), $this->language)
                                     : call_user_func($this->messageProvider, array('date', $key), $this->language);
                            foreach ($options as $k => &$v) {
                                $v = $names[$k - 1];
                            }
                        }
                        break;
                    case 'Y':
                        $options = $this->createOptionList(
                            $this->data['minYear'],
                            $this->data['maxYear'],
                            $this->data['minYear'] > $this->data['maxYear']? -1: 1
                        );
                        break;
                    case 'y':
                        $options = $this->createOptionList(
                            $this->data['minYear'],
                            $this->data['maxYear'],
                            $this->data['minYear'] > $this->data['maxYear']? -1: 1
                        );
                        array_walk($options, create_function('&$v,$k','$v = substr($v,-2);'));
                        break;
                    case 'h':
                        $options = $this->createOptionList(1, 12);
                        break;
                    case 'g':
                        $options = $this->createOptionList(1, 12);
                        array_walk($options, create_function('&$v,$k', '$v = intval($v);'));
                        break;
                    case 'H':
                        $options = $this->createOptionList(
                            $this->data['minHour'],
                            $this->data['maxHour'],
                            $this->data['minHour'] > $this->data['maxHour'] ? -1 : 1
                        );
                        break;
                    case 'i':
                        $options = $this->createOptionList(0, 59, $this->data['optionIncrement']['i']);
                        break;
                    case 's':
                        $options = $this->createOptionList(0, 59, $this->data['optionIncrement']['s']);
                        break;
                    case 'a':
                        $options = array('am' => 'am', 'pm' => 'pm');
                        break;
                    case 'A':
                        $options = array('AM' => 'AM', 'PM' => 'PM');
                        break;
                    case 'W':
                        $options = $this->createOptionList(1, 53);
                        break;
                    case '\\':
                        $backslash  = true;
                        $loadSelect = false;
                        break;
                    default:
                        $separator .= (' ' == $sign? '&nbsp;': $sign);
                        $loadSelect = false;
                }

                if ($loadSelect) {
                    if (0 < count($this)) {
                        $separators[] = $separator;
                    }
                    $separator = '';
                    // Should we add an empty option to the top of the select?
                    if (!is_array($this->data['addEmptyOption']) && $this->data['addEmptyOption'] ||
                        is_array($this->data['addEmptyOption']) && !empty($this->data['addEmptyOption'][$sign])) {

                        // Using '+' array operator to preserve the keys
                        if (is_array($this->data['emptyOptionText']) && !empty($this->data['emptyOptionText'][$sign])) {
                            $options = array($this->data['emptyOptionValue'] => $this->data['emptyOptionText'][$sign]) + $options;
                        } else {
                            $options = array($this->data['emptyOptionValue'] => $this->data['emptyOptionText']) + $options;
                        }
                    }
                    $this->addSelect($sign, array('id' => self::generateId($this->getName() . "[{$sign}]"))
                                            + $this->getAttributes())
                         ->loadOptions($options);
                }
            }
        }
        $separators[] = $separator . ($backslash? '\\': '');
        $this->setSeparator($separators);
    }

   /**
    * Creates an option list containing the numbers from the start number to the end, inclusive
    *
    * @param    int     The start number
    * @param    int     The end number
    * @param    int     Increment by this value
    * @return   array   An array of numeric options.
    */
    protected function createOptionList($start, $end, $step = 1)
    {
        for ($i = $start, $options = array(); $start > $end? $i >= $end: $i <= $end; $i += $step) {
            $options[$i] = sprintf('%02d', $i);
        }
        return $options;
    }

   /**
    * Trims leading zeros from the (numeric) string
    *
    * @param    string  A numeric string, possibly with leading zeros
    * @return   string  String with leading zeros removed
    */
    protected function trimLeadingZeros($str)
    {
        if (0 == strcmp($str, $this->data['emptyOptionValue'])) {
            return $str;
        }
        $trimmed = ltrim($str, '0');
        return strlen($trimmed)? $trimmed: '0';
    }


   /**
    * Tries to convert the given value to a usable date before setting the
    * element value
    * @param    int|string|array    A timestamp, a string compatible with strtotime()
    *                               or an array that fits the element names
    */
    public function setValue($value)
    {
        if (empty($value)) {
            $value = array();
        } elseif (is_scalar($value)) {
            if (!is_numeric($value)) {
                $value = strtotime($value);
            }
            // might be a unix epoch, then we fill all possible values
            $arr = explode('-', date('w-j-n-Y-g-G-i-s-a-A-W', (int)$value));
            $value = array(
                'D' => $arr[0],
                'l' => $arr[0],
                'd' => $arr[1],
                'M' => $arr[2],
                'm' => $arr[2],
                'F' => $arr[2],
                'Y' => $arr[3],
                'y' => $arr[3],
                'h' => $arr[4],
                'g' => $arr[4],
                'H' => $arr[5],
                'i' => $this->trimLeadingZeros($arr[6]),
                's' => $this->trimLeadingZeros($arr[7]),
                'a' => $arr[8],
                'A' => $arr[9],
                'W' => $this->trimLeadingZeros($arr[10])
            );
        } else {
            $value = array_map(array($this, 'trimLeadingZeros'), $value);
        }
        return parent::setValue($value);
    }

   /**
    * Called when the element needs to update its value from form's data sources
    *
    * Since the date element also accepts a timestamp as value, the default
    * group behavior is changed.
    */
    protected function updateValue()
    {
        $name = $this->getName();
        foreach ($this->getDataSources() as $ds) {
            if (null !== ($value = $ds->getValue($name))) {
                $this->setValue($value);
                return;
            }
        }
        parent::updateValue();
    }
}
?>