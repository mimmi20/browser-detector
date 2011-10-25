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
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Rule checking that uploaded file size does not exceed the given limit
 */
require_once 'HTML/QuickForm2/Rule/MaxFileSize.php';

/**
 * Class for <input type="file" /> elements
 */
require_once 'HTML/QuickForm2/Element/InputFile.php';

/**
 * Unit test for HTML_QuickForm2_Rule_MaxFileSize class
 */
class HTML_QuickForm2_Rule_MaxFileSizeTest extends PHPUnit_Framework_TestCase
{
    public function testPositiveSizeLimitIsRequired()
    {
        $file    = new HTML_QuickForm2_Element_InputFile('foo');
        try {
            $maxSize = new HTML_QuickForm2_Rule_MaxFileSize($file, 'an error');
            $this->fail('The expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/MaxFileSize Rule requires a positive size limit/', $e->getMessage());
        }
        try {
            $maxSizeNegative = new HTML_QuickForm2_Rule_MaxFileSize($file, 'an error', -10);
            $this->fail('The expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/MaxFileSize Rule requires a positive size limit/', $e->getMessage());
        }
    }

    public function testCanOnlyValidateFileUploads()
    {
        $mockEl  = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                  'getRawValue', 'setValue', '__toString'));
        try {
            $maxSize = new HTML_QuickForm2_Rule_MaxFileSize($mockEl, 'an error', 1024);
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/MaxFileSize Rule can only validate file upload fields/', $e->getMessage());
            return;
        }
        $this->fail('The expected HTML_QuickForm2_InvalidArgumentException was not thrown');
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
        $maxSize = new HTML_QuickForm2_Rule_MaxFileSize($mockNoUpload, 'an error', 1024);
        $this->assertTrue($maxSize->validate());
    }

    public function testOptionsHandling()
    {
        $mockFile = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockFile->expects($this->exactly(2))->method('getValue')
                 ->will($this->returnValue(array(
                    'name'     => 'pr0n.jpg',
                    'type'     => 'image/jpeg',
                    'tmp_name' => dirname(dirname(__FILE__)) . '/_files/1024-bytes.upload',
                    'error'    => UPLOAD_ERR_OK,
                    'size'     => 1024
                 )));
        $size512 = new HTML_QuickForm2_Rule_MaxFileSize($mockFile, 'too big', 512);
        $this->assertFalse($size512->validate());

        $size2048 = new HTML_QuickForm2_Rule_MaxFileSize($mockFile, 'too big', 2048);
        $this->assertTrue($size2048->validate());
    }

    public function testConfigHandling()
    {
        $mockFile = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockFile->expects($this->exactly(2))->method('getValue')
                 ->will($this->returnValue(array(
                    'name'     => 'pr0n.jpg',
                    'type'     => 'image/jpeg',
                    'tmp_name' => dirname(dirname(__FILE__)) . '/_files/1024-bytes.upload',
                    'error'    => UPLOAD_ERR_OK,
                    'size'     => 1024
                 )));

        HTML_QuickForm2_Factory::registerRule('filesize-512', 'HTML_QuickForm2_Rule_MaxFileSize',
                                              null, 512);
        $size512  = $mockFile->addRule('filesize-512', 'too big');
        $this->assertFalse($size512->validate());

        HTML_QuickForm2_Factory::registerRule('filesize-2048', 'HTML_QuickForm2_Rule_MaxFileSize',
                                              null, 2048);
        $size2048 = $mockFile->addRule('filesize-2048', 'too big');
        $this->assertTrue($size2048->validate());
    }

    public function testConfigOverridesOptions()
    {
        $mockFile = $this->getMock('HTML_QuickForm2_Element_InputFile', array('getValue'));
        $mockFile->expects($this->once())->method('getValue')
                 ->will($this->returnValue(array(
                    'name'     => 'pr0n.jpg',
                    'type'     => 'image/jpeg',
                    'tmp_name' => dirname(dirname(__FILE__)) . '/_files/1024-bytes.upload',
                    'error'    => UPLOAD_ERR_OK,
                    'size'     => 1024
                 )));
        HTML_QuickForm2_Factory::registerRule('filesize-override-512', 'HTML_QuickForm2_Rule_MaxFileSize',
                                              null, 512);
        $maxSize = $mockFile->addRule('filesize-override-512', 'too big', 10240);
        $this->assertFalse($maxSize->validate());
    }
}
?>
