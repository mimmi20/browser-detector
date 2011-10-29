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
 * @version    SVN: $Id: InputFileTest.php 102 2011-10-25 21:18:56Z  $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Class for <input type="file" /> elements
 */
require_once 'HTML/QuickForm2/Element/InputFile.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Class representing a HTML form
 */
require_once 'HTML/QuickForm2.php';

/** Interface for classes that supply (translated) messages for the elements */
require_once 'HTML/QuickForm2/MessageProvider.php';

/**
 * Unit test for HTML_QuickForm2_Element_InputFile class
 */
class HTML_QuickForm2_Element_InputFileTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_FILES = array(
            'foo' => array(
                'name'      => 'file.doc',
                'tmp_name'  => '/tmp/nothing',
                'type'      => 'text/plain',
                'size'      => 1234,
                'error'     => UPLOAD_ERR_OK
            ),
            'toobig' => array(
                'name'      => 'ahugefile.zip',
                'tmp_name'  => '',
                'type'      => '',
                'size'      => 0,
                'error'     => UPLOAD_ERR_FORM_SIZE
            ),
            'local' => array(
                'name'      => 'nasty-trojan.exe',
                'tmp_name'  => '',
                'type'      => '',
                'size'      => 0,
                'error'     => UPLOAD_ERR_CANT_WRITE
            )
        );
        $_POST = array(
            'MAX_FILE_SIZE' => '987654'
        );
    }

    public function testCannotBeFrozen()
    {
        $upload = new HTML_QuickForm2_Element_InputFile('foo');
        $this->assertFalse($upload->toggleFrozen(true));
        $this->assertFalse($upload->toggleFrozen());
    }

    public function testSetValueFromSubmitDataSource()
    {
        $form = new HTML_QuickForm2('upload', 'post', null, false);
        $foo = $form->appendChild(new HTML_QuickForm2_Element_InputFile('foo'));
        $bar = $form->appendChild(new HTML_QuickForm2_Element_InputFile('bar'));

        $this->assertNull($bar->getValue());
        $this->assertEquals(array(
            'name'      => 'file.doc',
            'tmp_name'  => '/tmp/nothing',
            'type'      => 'text/plain',
            'size'      => 1234,
            'error'     => UPLOAD_ERR_OK
        ), $foo->getValue());
    }

    public function testBuiltinValidation()
    {
        $form = new HTML_QuickForm2('upload', 'post', null, false);
        $foo  = $form->appendChild(new HTML_QuickForm2_Element_InputFile('foo'));
        $this->assertTrue($form->validate());

        $toobig = $form->appendChild(new HTML_QuickForm2_Element_InputFile('toobig'));
        $this->assertFalse($form->validate());
        $this->assertContains('987654', $toobig->getError());
    }

    public function testErrorMessageLocalization()
    {
        $form  = new HTML_QuickForm2('upload', 'post', null, false);
        $local = $form->appendChild(new HTML_QuickForm2_Element_InputFile(
            'local', array(), array('language'      => 'zz',
                                    'errorMessages' => array(
                                        'zz' => array(UPLOAD_ERR_CANT_WRITE => 'Blah-blah-blah')
                                    ))
        ));
        $this->assertFalse($form->validate());
        $this->assertEquals('Blah-blah-blah', $local->getError());
    }

   /**
    * @expectedException HTML_QuickForm2_InvalidArgumentException
    */
    public function testInvalidMessageProvider()
    {
        $invalid = new HTML_QuickForm2_Element_InputFile('invalid', null, array('messageProvider' => array()));
    }

    public function testCallbackMessageProvider()
    {
        $form   = new HTML_QuickForm2('upload', 'post', null, false);
        $upload = $form->addFile('local', array(), array(
            'messageProvider' => create_function('$messageId, $langId', 'return "A nasty error happened!";')
        ));
        $this->assertFalse($form->validate());
        $this->assertEquals('A nasty error happened!', $upload->getError());
    }

    public function testObjectMessageProvider()
    {
        $mockProvider = $this->getMock('HTML_QuickForm2_MessageProvider',
                                       array('get'));
        $mockProvider->expects($this->once())->method('get')
                     ->will($this->returnValue('A nasty error happened!'));

        $form   = new HTML_QuickForm2('upload', 'post', null, false);
        $upload = $form->addFile('local', array(), array(
            'messageProvider' => $mockProvider
        ));
        $this->assertFalse($form->validate());
        $this->assertEquals('A nasty error happened!', $upload->getError());
    }

   /**
    * File should check that the form has POST method, set enctype to multipart/form-data
    * @see http://pear.php.net/bugs/bug.php?id=16807
    */
    public function testRequest16807()
    {
        $form = new HTML_QuickForm2('broken', 'get');

        try {
            $form->addFile('upload', array('id' => 'upload'));
            $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {}

        $group = HTML_QuickForm2_Factory::createElement('group', 'fileGroup');
        $group->addFile('upload', array('id' => 'upload'));
        try {
            $form->appendChild($group);
            $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {}

        $post = new HTML_QuickForm2('okform', 'post');
        $this->assertNull($post->getAttribute('enctype'));
        $post->addFile('upload');
        $this->assertEquals('multipart/form-data', $post->getAttribute('enctype'));
    }
}
?>
