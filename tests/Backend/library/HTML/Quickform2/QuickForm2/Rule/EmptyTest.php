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
 * @version    SVN: $Id: EmptyTest.php 102 2011-10-25 21:18:56Z  $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Rule checking that the form field is empty
 */
require_once 'HTML/QuickForm2/Rule/Empty.php';

/**
 * Class for <input type="file" /> elements
 */
require_once 'HTML/QuickForm2/Element/InputFile.php';

/**
 * Unit test for HTML_QuickForm2_Rule_Empty class
 */
class HTML_QuickForm2_Rule_EmptyTest extends PHPUnit_Framework_TestCase
{
    public function testValidateGenericElement()
    {
        $mockValid = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                    'getRawValue', 'setValue', '__toString'));
        $mockValid->expects($this->once())->method('getRawValue')
                  ->will($this->returnValue(''));
        $rule = new HTML_QuickForm2_Rule_Empty($mockValid, 'an error');
        $this->assertTrue($rule->validate());
        $this->assertEquals('', $mockValid->getError());

        $mockInvalid = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                      'getRawValue', 'setValue', '__toString'));
        $mockInvalid->expects($this->once())->method('getRawValue')
                    ->will($this->returnValue('some value'));
        $rule2 = new HTML_QuickForm2_Rule_Empty($mockInvalid, 'an error');
        $this->assertFalse($rule2->validate());
        $this->assertEquals('an error', $mockInvalid->getError());
    }

    public function testValidateInputFileElement()
    {
        $mockValid = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockValid->expects($this->once())->method('getValue')
                  ->will($this->returnValue(array(
                      'name'     => '',
                      'type'     => '',
                      'tmp_name' => '',
                      'error'    => UPLOAD_ERR_NO_FILE,
                      'size'     => 0
                  )));
        $rule = new HTML_QuickForm2_Rule_Empty($mockValid, 'an error');
        $this->assertTrue($rule->validate());
        $this->assertEquals('', $mockValid->getError());

        $mockInvalid = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockInvalid->expects($this->once())->method('getValue')
                    ->will($this->returnValue(array(
                        'name'     => 'goodfile.php',
                        'type'     => 'application/octet-stream',
                        'tmp_name' => '/tmp/foobar',
                        'error'    => UPLOAD_ERR_OK,
                        'size'     => 1234
                    )));
        $rule2 = new HTML_QuickForm2_Rule_Empty($mockInvalid, 'an error');
        $this->assertFalse($rule2->validate());
        $this->assertEquals('an error', $mockInvalid->getError());
    }

    public function testFailedUploadIsNotEmpty()
    {
        $mockFailed = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockFailed->expects($this->once())->method('getValue')
                   ->will($this->returnValue(array(
                       'name'     => 'badfile.php',
                       'type'     => '',
                       'tmp_name' => '',
                       'error'    => UPLOAD_ERR_FORM_SIZE,
                       'size'     => 0
                   )));
        $rule = new HTML_QuickForm2_Rule_Empty($mockFailed, 'an error');
        $this->assertFalse($rule->validate());
        $this->assertEquals('an error', $mockFailed->getError());
    }

    public function testValidateArray()
    {
        $mockElEmpty = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                      'getRawValue', 'setValue', '__toString'));
        $mockElEmpty->expects($this->once())->method('getRawValue')
                    ->will($this->returnValue(array()));
        $rule = new HTML_QuickForm2_Rule_Empty($mockElEmpty, 'an error');
        $this->assertTrue($rule->validate());

        $mockElNonEmpty = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                         'getRawValue', 'setValue', '__toString'));
        $mockElNonEmpty->expects($this->once())->method('getRawValue')
                       ->will($this->returnValue(array('foo', 'bar')));
        $rule = new HTML_QuickForm2_Rule_Empty($mockElNonEmpty, 'an error');
        $this->assertFalse($rule->validate());
    }
}
?>
