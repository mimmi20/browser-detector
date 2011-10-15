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
 * @version    SVN: $Id: BackTest.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/TestHelper.php';

/** Class implementing the Page Controller pattern for multipage forms */
require_once 'HTML/QuickForm2/Controller.php';

/** Class representing a HTML form */
require_once 'HTML/QuickForm2.php';

/** Action handler for a 'back' button of wizard-type multipage form */
require_once 'HTML/QuickForm2/Controller/Action/Back.php';

/**
 * Unit test for HTML_QuickForm2_Controller_Action_Back class
 */
class HTML_QuickForm2_Controller_Action_BackTest
    extends PHPUnit_Framework_TestCase
{
    public function testPerform()
    {
        $formOne = new HTML_QuickForm2('formOne');
        $formOne->addElement('text', 'foo')->setValue('foo value');
        $pageOne = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($formOne)
        );
        $formTwo = new HTML_QuickForm2('formTwo');
        $formTwo->addElement('text', 'bar')->setValue('bar value');
        $pageTwo = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($formTwo)
        );
        $mockJump = $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        );
        $mockJump->expects($this->exactly(2))->method('perform')
                 ->will($this->returnValue('jump to foo'));
        $pageOne->addHandler('jump', $mockJump);
        $controller = new HTML_QuickForm2_Controller('testBackAction');
        $controller->addPage($pageOne);
        $controller->addPage($pageTwo);

        $this->assertEquals('jump to foo', $pageTwo->handle('back'));
        $this->assertEquals(array(), $controller->getSessionContainer()->getValues('formOne'));
        $this->assertContains('bar value', $controller->getSessionContainer()->getValues('formTwo'));

        $this->assertEquals('jump to foo', $pageOne->handle('back'));
        $this->assertContains('foo value', $controller->getSessionContainer()->getValues('formOne'));
    }

    public function testNoValidationForWizards()
    {
        $mockForm = $this->getMock(
            'HTML_QuickForm2', array('validate'),
            array('eternallyValid')
        );
        $mockForm->expects($this->once())->method('validate')
                 ->will($this->returnValue(true));
        $mockPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($mockForm)
        );
        $mockPage->addHandler('jump', $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        ));

        $wizard = new HTML_QuickForm2_Controller('wizard', true);
        $wizard->addPage($mockPage);
        $mockPage->handle('back');
        $this->assertNull($wizard->getSessionContainer()->getValidationStatus('eternallyValid'));

        $nonWizard = new HTML_QuickForm2_Controller('nonWizard', false);
        $nonWizard->addPage($mockPage);
        $mockPage->handle('back');
        $this->assertTrue($nonWizard->getSessionContainer()->getValidationStatus('eternallyValid'));
    }
}