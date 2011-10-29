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
 * @version    SVN: $Id: MimeTypeTest.php 102 2011-10-25 21:18:56Z  $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Rule checking that uploaded file is of the correct MIME type
 */
require_once 'HTML/QuickForm2/Rule/MimeType.php';

/**
 * Class for <input type="file" /> elements
 */
require_once 'HTML/QuickForm2/Element/InputFile.php';

/**
 * Unit test for HTML_QuickForm2_Rule_MimeType class
 */
class HTML_QuickForm2_Rule_MimeTypeTest extends PHPUnit_Framework_TestCase
{
    public function testMimeTypeIsRequired()
    {
        $file = new HTML_QuickForm2_Element_InputFile('foo');
        try {
            $mimeType = new HTML_QuickForm2_Rule_MimeType($file, 'an error');
            $this->fail('The expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/MimeType Rule requires MIME type[(]s[)]/', $e->getMessage());
        }
    }

    public function testCanOnlyValidateFileUploads()
    {
        $mockEl  = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                  'getRawValue', 'setValue', '__toString'));
        try {
            $mimeType = new HTML_QuickForm2_Rule_MimeType($mockEl, 'an error', 'text/plain');
            $this->fail('The expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/MimeType Rule can only validate file upload fields/', $e->getMessage());
        }
    }

    public function testMissingUploadsAreSkipped()
    {
        $mockNoUpload = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockNoUpload->expects($this->once())->method('getValue')
                     ->will($this->returnValue(array(
                        'name'     => '',
                        'type'     => '',
                        'tmp_name' => '',
                        'error'    => UPLOAD_ERR_NO_FILE,
                        'size'     => 0
                     )));
        $mimeType = new HTML_QuickForm2_Rule_MimeType($mockNoUpload, 'an error', 'text/plain');
        $this->assertTrue($mimeType->validate());
    }

    public function testOptionsHandling()
    {
        $mockFile = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockFile->expects($this->exactly(2))->method('getValue')
                 ->will($this->returnValue(array(
                    'name'     => 'pr0n.jpg',
                    'type'     => 'image/jpeg',
                    'tmp_name' => '/tmp/foobar',
                    'error'    => UPLOAD_ERR_OK,
                    'size'     => 123456
                 )));
        $typeText = new HTML_QuickForm2_Rule_MimeType($mockFile, 'need text', 'text/plain');
        $this->assertFalse($typeText->validate());

        $typeImage = new HTML_QuickForm2_Rule_MimeType($mockFile, 'need image',
                                                       array('image/gif', 'image/jpeg'));
        $this->assertTrue($typeImage->validate());
    }

    public function testConfigHandling()
    {
        $mockFile = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockFile->expects($this->exactly(2))->method('getValue')
                 ->will($this->returnValue(array(
                    'name'     => 'pr0n.jpg',
                    'type'     => 'image/jpeg',
                    'tmp_name' => '/tmp/foobar',
                    'error'    => UPLOAD_ERR_OK,
                    'size'     => 123456
                 )));

        HTML_QuickForm2_Factory::registerRule('type-text', 'HTML_QuickForm2_Rule_MimeType',
                                              null, 'text/plain');
        $typeText = $mockFile->addRule('type-text', 'need text');
        $this->assertFalse($typeText->validate());

        HTML_QuickForm2_Factory::registerRule('type-image', 'HTML_QuickForm2_Rule_MimeType',
                                              null, array('image/gif', 'image/jpeg'));
        $typeImage = $mockFile->addRule('type-image', 'need image');
        $this->assertTrue($typeImage->validate());
    }

    public function testConfigOverridesOptions()
    {
        $mockFile = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockFile->expects($this->once())->method('getValue')
                 ->will($this->returnValue(array(
                    'name'     => 'pr0n.jpg',
                    'type'     => 'image/jpeg',
                    'tmp_name' => '/tmp/foobar',
                    'error'    => UPLOAD_ERR_OK,
                    'size'     => 123456
                 )));
        HTML_QuickForm2_Factory::registerRule('type-override-text', 'HTML_QuickForm2_Rule_MimeType',
                                              null, 'text/plain');
        $mimeType = $mockFile->addRule('type-override-text', 'need image',
                                       array('image/gif', 'image/jpeg'));
        $this->assertFalse($mimeType->validate());
    }
}
?>