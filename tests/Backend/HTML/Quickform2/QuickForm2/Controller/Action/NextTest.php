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
 * @version    SVN: $Id: NextTest.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/TestHelper.php';

/** Class implementing the Page Controller pattern for multipage forms */
require_once 'HTML/QuickForm2/Controller.php';

/** Class representing a HTML form */
require_once 'HTML/QuickForm2.php';

/** Action handler for a 'next' button of wizard-type multipage form */
require_once 'HTML/QuickForm2/Controller/Action/Next.php';

/**
 * Unit test for HTML_QuickForm2_Controller_Action_Next class
 */
class HTML_QuickForm2_Controller_Action_NextTest
    extends PHPUnit_Framework_TestCase
{
    public function testWizardBehaviour()
    {
        $formOne = $this->getMock(
            'HTML_QuickForm2', array('validate'), array('one')
        );
        $formOne->expects($this->exactly(2))->method('validate')
                ->will($this->onConsecutiveCalls(false, true));
        $formTwo = $this->getMock(
            'HTML_QuickForm2', array('validate'), array('two')
        );
        $formTwo->expects($this->exactly(2))->method('validate')
                ->will($this->returnValue(true));

        $mockJumpOne = $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        );
        $mockJumpOne->expects($this->any())->method('perform')
                    ->will($this->returnValue('jump to page one'));
        $mockJumpTwo = $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        );
        $mockJumpTwo->expects($this->any())->method('perform')
                    ->will($this->returnValue('jump to page two'));
        $mockProcess = $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        );
        $mockProcess->expects($this->any())->method('perform')
                    ->will($this->returnValue('do processing'));
        $mockDisplay = $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        );
        $mockDisplay->expects($this->any())->method('perform')
                    ->will($this->returnValue('output form'));

        $pageOne = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($formOne)
        );
        $pageOne->addHandler('display', $mockDisplay);
        $pageOne->addHandler('jump', $mockJumpOne);
        $pageTwo = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($formTwo)
        );
        $pageTwo->addHandler('jump', $mockJumpTwo);
        $pageTwo->addHandler('process', $mockProcess);

        $controller = new HTML_QuickForm2_Controller('wizard_next', true);
        $controller->addPage($pageOne);
        $controller->addPage($pageTwo);

        $this->assertEquals('output form', $pageOne->handle('next'));
        $this->assertEquals('jump to page two', $pageOne->handle('next'));
        $this->assertEquals('do processing', $pageTwo->handle('next'));

        $controller->getSessionContainer()->storeValidationStatus('one', false);
        $this->assertEquals('jump to page one', $pageTwo->handle('next'));
    }

    public function testNonWizardBehaviour()
    {
        $formOne = $this->getMock(
            'HTML_QuickForm2', array('validate'), array('one')
        );
        $formOne->expects($this->exactly(2))->method('validate')
                ->will($this->onConsecutiveCalls(false, true));
        $formTwo = $this->getMock(
            'HTML_QuickForm2', array('validate'), array('two')
        );
        $formTwo->expects($this->exactly(2))->method('validate')
                ->will($this->onConsecutiveCalls(false, true));
        $mockJumpTwo = $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        );
        $mockJumpTwo->expects($this->any())->method('perform')
                    ->will($this->returnValue('jump to page two'));
        $mockDisplay = $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        );
        $mockDisplay->expects($this->any())->method('perform')
                    ->will($this->returnValue('output form'));

        $pageOne = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($formOne)
        );
        $pageTwo = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($formTwo)
        );
        $pageTwo->addHandler('jump', $mockJumpTwo);
        $pageTwo->addHandler('display', $mockDisplay);

        $controller = new HTML_QuickForm2_Controller('nonwizard_next', false);
        $controller->addPage($pageOne);
        $controller->addPage($pageTwo);

        // Don't bother whether the page is valid
        $this->assertEquals('jump to page two', $pageOne->handle('next'));
        $this->assertEquals('jump to page two', $pageOne->handle('next'));

        // Non-wizard form requires an explicit submit
        $this->assertEquals('output form', $pageTwo->handle('next'));
        $this->assertEquals('output form', $pageTwo->handle('next'));
    }
}
?>