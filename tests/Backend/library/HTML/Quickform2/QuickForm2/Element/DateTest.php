<?php
/**
 * Unit tests for HTML_QuickForm2 package
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
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @version    SVN: $Id: DateTest.php 102 2011-10-25 21:18:56Z  $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Date element */
require_once 'HTML/QuickForm2/Element/Date.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

class HTML_QuickForm2_Element_DateTest extends PHPUnit_Framework_TestCase
{
   /**
    * @expectedException HTML_QuickForm2_InvalidArgumentException
    */
    public function testInvalidMessageProvider()
    {
        $invalid = new HTML_QuickForm2_Element_Date('invalid', null, array('messageProvider' => array()));
    }

    public function testCallbackMessageProvider()
    {
        $date = new HTML_QuickForm2_Element_Date('callback', null, array(
            'format'          => 'l',
            'messageProvider' => create_function(
                '$messageId, $langId',
                "return array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Caturday');"
            )
        ));
        $this->assertContains('<option value="6">Caturday</option>', $date->__toString());
    }

    public function testObjectMessageProvider()
    {
        $mockProvider = $this->getMock('HTML_QuickForm2_MessageProvider',
                                       array('get'));
        $mockProvider->expects($this->once())->method('get')
                     ->will($this->returnValue(array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Caturday')));
        $date = new HTML_QuickForm2_Element_Date('object', null, array(
            'format'          => 'l',
            'messageProvider' => $mockProvider
        ));
        $this->assertContains('<option value="6">Caturday</option>', $date->__toString());
    }

   /**
    * Support for minHour and maxHour
    * @see http://pear.php.net/bugs/4061
    */
    public function testRequest4061()
    {
        $date = new HTML_QuickForm2_Element_Date('MaxMinHour', null, array(
            'format' => 'H', 'minHour' => 22, 'maxHour' => 6
        ));
        $this->assertRegexp(
            '!<option value="22">22</option>.+<option value="6">06</option>!is',
            $date->__toString()
        );
        $this->assertNotContains(
            '<option value="5">05</option>',
            $date->__toString()
        );
    }

   /**
    * Support for minMonth and maxMonth
    * @see http://pear.php.net/bugs/5957
    */
    public function testRequest5957()
    {
        $date = new HTML_QuickForm2_Element_Date('MaxMinMonth', null, array(
            'format' => 'F', 'minMonth' => 10, 'maxMonth' => 3
        ));
        $this->assertRegexp('!October.+March!is', $date->__toString());
        $this->assertNotContains('January', $date->__toString());
    }
}
?>