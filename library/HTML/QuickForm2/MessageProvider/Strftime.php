<?php
/**
 * Provides lists of months and weekdays for date elements using current locale
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
 * @version    SVN: $Id: Strftime.php 311326 2011-05-22 12:46:00Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Interface for classes that supply (translated) messages for the elements */
require_once 'HTML/QuickForm2/MessageProvider.php';

/**
 * Provides lists of months and weekdays for date elements using current locale
 *
 * Uses locale-aware strftime() formatting function. The class does not try to
 * do anything with locale itself, so be sure to set it up properly before
 * adding date elements to the form.
 *
 * @category   HTML
 * @package    HTML_QuickForm2
 * @author     Alexey Borzov <avb@php.net>
 * @author     Bertrand Mansion <golgote@mamasam.com>
 * @version    Release: 0.6.1
 * @link       http://pear.php.net/bugs/bug.php?id=5558
 */
class HTML_QuickForm2_MessageProvider_Strftime implements HTML_QuickForm2_MessageProvider
{
   /**
    * Lists of month names and weekdays accorfing to current locale
    * @var array
    */
    protected $messages = array(
        'weekdays_short'=> array(),
        'weekdays_long' => array(),
        'months_short'  => array(),
        'months_long'   => array()
    );

   /**
    * Constructor, builds lists of month and weekday names
    */
    public function __construct()
    {
        for ($i = 1; $i <= 12; $i++) {
            $names = explode("\n", strftime("%b\n%B", mktime(12, 0, 0, $i, 1, 2011)));
            $this->messages['months_short'][] = $names[0];
            $this->messages['months_long'][]  = $names[1];
        }
        for ($i = 0; $i < 7; $i++) {
            $names = explode("\n", strftime("%a\n%A", mktime(12, 0, 0, 1, 2 + $i, 2011)));
            $this->messages['weekdays_short'][] = $names[0];
            $this->messages['weekdays_long'][]  = $names[1];
        }
    }

   /**
    * Returns name(s) of months and weekdays for date elements
    *
    * @param    array   Message ID
    * @param    string  Not used, current locale will define the language
    * @return   array|string|null
    * @throws   HTML_QuickForm2_InvalidArgumentException if $messageId doesn't
    *               start with 'date'
    */
    public function get(array $messageId, $langId = null)
    {
        if ('date' != array_shift($messageId)) {
            throw new HTML_QuickForm2_InvalidArgumentException('...');
        }

        $message = $this->messages;
        while (!empty($messageId)) {
            $key = array_shift($messageId);
            if (!isset($message[$key])) {
                return null;
            }
            $message = $message[$key];
        }
        return $message;
    }
}
?>
