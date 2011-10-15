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
 * @version    SVN: $Id: DisplayTest.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/TestHelper.php';

/** Class implementing the Page Controller pattern for multipage forms */
require_once 'HTML/QuickForm2/Controller.php';

/** Class representing a HTML form */
require_once 'HTML/QuickForm2.php';

/** Action handler for outputting the form */
require_once 'HTML/QuickForm2/Controller/Action/Display.php';

/**
 * Unit test for HTML_QuickForm2_Controller_Action_Display class
 */
class HTML_QuickForm2_Controller_Action_DisplayTest
    extends PHPUnit_Framework_TestCase
{
   /**
    * Do not allow displaying a wizard page if preceding page(s) are not valid
    *
    * @link http://pear.php.net/bugs/bug.php?id=2323
    */
    public function testBug2323()
    {
        $pageFirst = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('first'))
        );
        $mockJump = $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        );
        $mockJump->expects($this->once())->method('perform')
                 ->will($this->returnValue('jump to first'));
        $pageFirst->addHandler('jump', $mockJump);

        $pageSecond = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('second'))
        );
        $mockDisplay = $this->getMock(
            'HTML_QuickForm2_Controller_Action_Display', array('renderForm')
        );
        $mockDisplay->expects($this->never())->method('renderForm');
        $pageSecond->addHandler('display', $mockDisplay);

        $controller = new HTML_QuickForm2_Controller('bug2323', true);
        $controller->addPage($pageFirst);
        $controller->addPage($pageSecond);

        $this->assertEquals('jump to first', $pageSecond->handle('display'));
    }

    public function testLoadFromSessionContainerOnDisplay()
    {
        $mockForm = $this->getMock(
            'HTML_QuickForm2', array('validate'), array('load')
        );
        $foo = $mockForm->addElement('text', 'foo');
        $mockForm->expects($this->once())->method('validate')
                 ->will($this->returnValue(false));
        $mockPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($mockForm)
        );
        $mockPage->expects($this->once())->method('populateForm');
        $mockDisplay = $this->getMock(
            'HTML_QuickForm2_Controller_Action_Display', array('renderForm')
        );
        $mockDisplay->expects($this->once())->method('renderForm')
                    ->will($this->returnValue('a form'));
        $mockPage->addHandler('display', $mockDisplay);

        $controller = new HTML_QuickForm2_Controller('loadValues');
        $controller->addPage($mockPage);
        $controller->getSessionContainer()->storeValues('load', array(
            'foo' => 'bar'
        ));
        $controller->getSessionContainer()->storeValidationStatus('load', false);

        $this->assertEquals('a form', $mockPage->handle('display'));
        $this->assertEquals('bar', $foo->getValue());
    }

    public function testNoLoadFromSessionContainerOnOtherActions()
    {
        $mockForm = $this->getMock(
            'HTML_QuickForm2', array('validate'), array('noload')
        );
        $foo = $mockForm->addElement('text', 'foo');
        $mockForm->expects($this->never())->method('validate');
        $mockPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($mockForm)
        );
        $mockDisplay = $this->getMock(
            'HTML_QuickForm2_Controller_Action_Display', array('renderForm')
        );
        $mockDisplay->expects($this->once())->method('renderForm')
                    ->will($this->returnValue('a form'));
        $mockPage->addHandler('display', $mockDisplay);

        $_REQUEST = array(
            $mockPage->getButtonName('submit') => 'Yes, submit!'
        );
        $controller = new HTML_QuickForm2_Controller('noLoadValues');
        $controller->addPage($mockPage);
        $controller->getSessionContainer()->storeValues('noload', array(
            'foo' => 'bar'
        ));
        $controller->getSessionContainer()->storeValidationStatus('noload', false);
        $controller->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'foo' => 'quux'
        )));

        $this->assertEquals('a form', $mockPage->handle('display'));
        $this->assertEquals('quux', $foo->getValue());
    }
}
?>