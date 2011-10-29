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
 * @version    SVN: $Id: PageTest.php 102 2011-10-25 21:18:56Z  $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/** Class implementing the Page Controller pattern for multipage forms */
require_once 'HTML/QuickForm2/Controller.php';

/** Class representing a HTML form */
require_once 'HTML/QuickForm2.php';

/**
 * Unit test for HTML_QuickForm2_Controller_Page class
 */
class HTML_QuickForm2_Controller_PageTest extends PHPUnit_Framework_TestCase
{
    public function testPopulateFormOnce()
    {
        $mockPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('firstPage'))
        );
        $mockPage->expects($this->once())->method('populateForm');

        $mockPage->populateFormOnce();
        $mockPage->populateFormOnce();
    }

    public function testActionHandlerPrecedence()
    {
        $controller = new HTML_QuickForm2_Controller('precedence');
        $mockPage   = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('precedencePage'))
        );
        $controller->addPage($mockPage);

        try {
            $mockPage->handle('foo');
            $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
        } catch (HTML_QuickForm2_NotFoundException $e) {}

        $mockFoo1 = $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        );
        $mockFoo1->expects($this->once())->method('perform')
                 ->will($this->returnValue('foo common'));
        $controller->addHandler('foo', $mockFoo1);
        $this->assertEquals('foo common', $mockPage->handle('foo'));

        $mockFoo2 = $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        );
        $mockFoo2->expects($this->once())->method('perform')
                 ->will($this->returnValue('foo specific'));
        $mockPage->addHandler('foo', $mockFoo2);
        $this->assertEquals('foo specific', $mockPage->handle('foo'));
    }

    public function testDefaultActionHandler()
    {
        $controller = new HTML_QuickForm2_Controller('defaultDisplay');
        $mockPage   = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('defaultDisplayPage'))
        );
        $controller->addPage($mockPage);

        ob_start();
        $mockPage->handle('display');
        $this->assertContains($mockPage->getForm()->__toString(), ob_get_contents());
        ob_end_clean();
    }

    public function testSetDefaultAction()
    {
        $mockPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('defaultActionPage'))
        );
        $mockPage->setDefaultAction('foo', 'empty.gif');

        $default = $mockPage->getForm()->getElementById('_qf_default');
        $this->assertNotNull($default);
        $this->assertEquals($mockPage->getButtonName('foo'), $default->getName());
        $this->assertEquals('empty.gif', $default->getAttribute('src'));

        $mockPage->setDefaultAction('bar');
        $this->assertEquals($mockPage->getButtonName('bar'), $default->getName());
        $this->assertEquals('', $default->getAttribute('src'));
    }

    public function testDefaultActionIsFirstElement()
    {
        $mockPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('defaultActionPage'))
        );
        $mockPage->getForm()->addElement('text', 'first');
        $mockPage->getForm()->addElement('text', 'second');
        $mockPage->setDefaultAction('foo', 'empty.gif');

        foreach ($mockPage->getForm() as $el) {
            $this->assertEquals('_qf_default', $el->getId());
            break;
        }
    }

    public function testPropagateControllerId()
    {
        $noPropPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('noPropagateForm'))
        );
        $noPropController = new HTML_QuickForm2_Controller('foo', true, false);
        $noPropController->addPage($noPropPage);
        $noPropPage->populateFormOnce();
        $hidden = $noPropPage->getForm()->getElementsByName(HTML_QuickForm2_Controller::KEY_ID);
        $this->assertEquals(0, count($hidden));

        $propPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('propagateForm'))
        );
        $propController = new HTML_QuickForm2_Controller('bar', true, true);
        $propController->addPage($propPage);
        $propPage->populateFormOnce();
        $hidden = $propPage->getForm()->getElementsByName(HTML_QuickForm2_Controller::KEY_ID);
        $this->assertNotEquals(0, count($hidden));
        $this->assertEquals('bar', $hidden[0]->getValue());
    }
}
?>