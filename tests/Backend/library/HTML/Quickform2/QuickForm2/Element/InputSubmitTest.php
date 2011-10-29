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
 * @version    SVN: $Id: InputSubmitTest.php 102 2011-10-25 21:18:56Z  $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Class for <input type="submit" /> elements
 */
require_once 'HTML/QuickForm2/Element/InputSubmit.php';

/**
 * Class representing a HTML form
 */
require_once 'HTML/QuickForm2.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Unit test for HTML_QuickForm2_Element_InputSubmit class
 */
class HTML_QuickForm2_Element_InputSubmitTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_POST = array(
            'foo' => 'A button clicked'
        );
    }

    public function testCannotBeFrozen()
    {
        $submit = new HTML_QuickForm2_Element_InputSubmit('foo');
        $this->assertFalse($submit->toggleFrozen(true));
        $this->assertFalse($submit->toggleFrozen());
    }

    public function testSetValueFromSubmitDataSource()
    {
        $form = new HTML_QuickForm2('submit', 'post', null, false);
        $foo = $form->appendChild(new HTML_QuickForm2_Element_InputSubmit('foo'));
        $bar = $form->appendChild(new HTML_QuickForm2_Element_InputSubmit('bar'));

        $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'foo' => 'Default for foo',
            'bar' => 'Default for bar'
        )));
        $this->assertEquals('A button clicked', $foo->getValue());
        $this->assertNull($bar->getValue());

        $foo->setAttribute('disabled');
        $this->assertNull($foo->getValue());
    }
}
?>
