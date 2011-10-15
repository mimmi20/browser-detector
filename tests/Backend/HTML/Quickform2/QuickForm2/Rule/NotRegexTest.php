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
 * @version    SVN: $Id: NotRegexTest.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Checks that the element's value does not match a regular expression
 */
require_once 'HTML/QuickForm2/Rule/NotRegex.php';

/**
 * Element class
 */
require_once 'HTML/QuickForm2/Element.php';

/**
 * Unit test for HTML_QuickForm2_Rule_NotRegex class
 */
class HTML_QuickForm2_Rule_NotRegexTest extends PHPUnit_Framework_TestCase
{
    public function testEmptyFieldsAreSkipped()
    {
        $mockEmpty = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                    'getRawValue', 'setValue', '__toString'));
        $mockEmpty->expects($this->once())->method('getRawValue')
                  ->will($this->returnValue(''));
        $ruleSimple = new HTML_QuickForm2_Rule_NotRegex($mockEmpty, 'an error', '/^[a-zA-Z]+$/');
        $this->assertTrue($ruleSimple->validate());

        $mockNoUpload = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockNoUpload->expects($this->once())->method('getValue')
                     ->will($this->returnValue(array(
                        'name'     => '',
                        'type'     => '',
                        'tmp_name' => '',
                        'error'    => UPLOAD_ERR_NO_FILE,
                        'size'     => 0
                     )));
        $ruleFile = new HTML_QuickForm2_Rule_NotRegex($mockNoUpload, 'an error', '/\\.(jpe?g|gif|png)$/i');
        $this->assertTrue($ruleFile->validate());
    }

    public function testNegatesResult()
    {
        $mockComment = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                      'getRawValue', 'setValue', '__toString'));
        $mockComment->expects($this->once())->method('getRawValue')
                    ->will($this->returnValue('Buy some cheap VIAGRA from our online pharmacy!!!'));
        $ruleNoSpam = new HTML_QuickForm2_Rule_NotRegex($mockComment, 'an error', '/viagra/i');
        $this->assertFalse($ruleNoSpam->validate());

        $mockUpload = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockUpload->expects($this->once())->method('getValue')
                   ->will($this->returnValue(array(
                     'name'     => 'pr0n.jpg',
                     'type'     => 'image/jpeg',
                     'tmp_name' => '/tmp/foobar',
                     'error'    => UPLOAD_ERR_OK,
                     'size'     => 123456
                   )));
        $ruleNoExe = new HTML_QuickForm2_Rule_NotRegex($mockUpload, 'an error', '/\\.(exe|scr|cmd)$/i');
        $this->assertTrue($ruleNoExe->validate());
    }
}
?>