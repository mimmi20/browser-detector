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
 * @version    SVN: $Id: InputImageTest.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Class for <input type="image" /> elements
 */
require_once 'HTML/QuickForm2/Element/InputImage.php';

/**
 * Class representing a HTML form
 */
require_once 'HTML/QuickForm2.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Unit test for HTML_QuickForm2_Element_InputImage class
 */
class HTML_QuickForm2_Element_InputImageTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_POST = array(
            'foo_x' => '12',
            'foo_y' => '34',
            'bar' => array(
                'idx' => array('56', '78')
            )
        );
    }

    public function testCannotBeFrozen()
    {
        $image = new HTML_QuickForm2_Element_InputImage('foo');
        $this->assertFalse($image->toggleFrozen(true));
        $this->assertFalse($image->toggleFrozen());
    }

    public function testPhpBug745Workaround()
    {
        $image1 = new HTML_QuickForm2_Element_InputImage('foo');
        $this->assertRegExp('/name="foo"/', $image1->__toString());

        $image2 = new HTML_QuickForm2_Element_InputImage('foo[bar]');
        $this->assertRegExp('/name="foo\\[bar\\]\\[\\]"/', $image2->__toString());
        $this->assertEquals('foo[bar]', $image2->getName());

        $image3 = new HTML_QuickForm2_Element_InputImage('foo[bar][]');
        $this->assertRegExp('/name="foo\\[bar\\]\\[\\]"/', $image3->__toString());
        $this->assertEquals('foo[bar][]', $image3->getName());
    }

    public function testSetValueFromSubmitDataSource()
    {
        $form = new HTML_QuickForm2('image', 'post', null, false);
        $foo = $form->appendChild(new HTML_QuickForm2_Element_InputImage('foo'));
        $bar = $form->appendChild(new HTML_QuickForm2_Element_InputImage('bar[idx]'));

        $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'foo_x' => '1234',
            'foo_y' => '5678',
            'bar' => array(
                'idx' => array('98', '76')
            )
        )));
        $this->assertEquals(array('x' => '12', 'y' => '34'), $foo->getValue());
        $this->assertEquals(array('x' => '56', 'y' => '78'), $bar->getValue());

        $foo->setAttribute('disabled');
        $this->assertNull($foo->getValue());
    }
}
?>
