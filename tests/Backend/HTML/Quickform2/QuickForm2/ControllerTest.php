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
 * @version    SVN: $Id: ControllerTest.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Class implementing the Page Controller pattern for multipage forms */
require_once 'HTML/QuickForm2/Controller.php';

/** Interface for Controller action handlers */
require_once 'HTML/QuickForm2/Controller/Action.php';

/** Class representing a HTML form */
require_once 'HTML/QuickForm2.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(__FILE__)) . '/TestHelper.php';

/**
 * Unit test for HTML_QuickForm2_Controller class
 */
class HTML_QuickForm2_ControllerTest extends PHPUnit_Framework_TestCase
{
    public function testSetExplicitID()
    {
        $controller = new HTML_QuickForm2_Controller('foo', false, false);
        $this->assertEquals('foo', $controller->getId());
        $this->assertFalse($controller->isWizard());
        $this->assertFalse($controller->propagateId());
    }

    public function testFindID()
    {
        try {
            $controller = new HTML_QuickForm2_Controller();
            $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
        } catch (HTML_QuickForm2_NotFoundException $e) {}

        $_REQUEST[HTML_QuickForm2_Controller::KEY_ID] = 'foo';
        try {
            $controller = new HTML_QuickForm2_Controller();
            $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
        } catch (HTML_QuickForm2_NotFoundException $e) {}

        $_SESSION[sprintf(HTML_QuickForm2_Controller::KEY_CONTAINER, 'foo')] = array(
            'datasources' => array(),
            'values'      => array(),
            'valid'       => array()
        );
        $controller = new HTML_QuickForm2_Controller(null, true, false);
        $this->assertEquals('foo', $controller->getId());
        $this->assertTrue($controller->isWizard());
        $this->assertTrue($controller->propagateId());
    }

    public function testContainer()
    {
        $_SESSION = array();

        $controller = new HTML_QuickForm2_Controller('foo');
        $container  = $controller->getSessionContainer();
        $this->assertNotEquals(array(), $_SESSION);

        $controller->destroySessionContainer();
        $this->assertEquals(array(), $_SESSION);
    }

    public function testAddPage()
    {
        $firstPage  = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('firstPage'))
        );
        $controller = new HTML_QuickForm2_Controller('foo');

        try {
            $page = $controller->getPage('firstPage');
            $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
        } catch (HTML_QuickForm2_NotFoundException $e) {}

        $controller->addPage($firstPage);
        $this->assertSame($firstPage, $controller->getPage('firstPage'));
        $this->assertSame($controller, $firstPage->getController());

        try {
            $controller->addPage($this->getMock(
                'HTML_QuickForm2_Controller_Page', array('populateForm'),
                array(new HTML_QuickForm2('firstPage'))
            ));
            $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {}
    }

    public function testDefaultActionName()
    {
        $controller = new HTML_QuickForm2_Controller('foo');

        try {
            $actionName = $controller->getActionName();
            $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
        } catch(HTML_QuickForm2_NotFoundException $e) {}

        $controller->addPage($this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('aPage'))
        ));
        $this->assertEquals(array('aPage', 'display'), $controller->getActionName());
    }

    public function testGetActionName()
    {
        $_REQUEST = array(
            sprintf(HTML_QuickForm2_Controller_Page::KEY_NAME, 'foo', 'bar')         => 'Button value',
            sprintf(HTML_QuickForm2_Controller_Page::KEY_NAME, 'baz', 'quux') . '_x' => 15
        );

        $controller1 = new HTML_QuickForm2_Controller('first');
        $controller1->addPage($this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('foo'))
        ));
        $this->assertEquals(array('foo', 'bar'), $controller1->getActionName());

        $controller2 = new HTML_QuickForm2_Controller('second');
        $controller2->addPage($this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('baz'))
        ));
        $this->assertEquals(array('baz', 'quux'), $controller2->getActionName());

        $_REQUEST = array();
        $this->assertEquals(array('foo', 'bar'), $controller1->getActionName());
    }

    public function testIsValidSimple()
    {
        $controller = new HTML_QuickForm2_Controller('simpleIsValid');
        $controller->addPage($this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('first'))
        ));
        $second = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('second'))
        );
        $controller->addPage($second);
        $controller->getSessionContainer()->storeValidationStatus('first', true);
        $controller->getSessionContainer()->storeValidationStatus('second', false);

        $this->assertFalse($controller->isValid());
        $this->assertTrue($controller->isValid($second));
    }

    public function testIsValidNotVisited()
    {
        $controller = new HTML_QuickForm2_Controller('isValidUnseen', false);
        $controller->addPage($this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('seen'))
        ));
        $mockUnseen = $this->getMock(
            'HTML_QuickForm2', array('validate', 'getValue'),
            array('unseen')
        );
        $mockUnseen->expects($this->once())->method('validate')
                   ->will($this->returnValue(true));
        $mockUnseen->expects($this->once())->method('getValue')
                   ->will($this->returnValue(array('foo' => 'bar')));
        $controller->addPage($this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($mockUnseen)
        ));
        $controller->getSessionContainer()->storeValidationStatus('seen', true);

        $this->assertTrue($controller->isValid());
    }

   /**
    * Default values for checkboxes and multiselects were ignored when validating an unseen page
    *
    * Unlikely that this bug will resurface, but just in case.
    *
    * @see http://pear.php.net/bugs/bug.php?id=8687
    */
    public function testBug8687()
    {
        $mockForm = $this->getMock(
            'HTML_QuickForm2', array('validate'), array('invalid')
        );
        $mockForm->expects($this->once())->method('validate')
                 ->will($this->returnValue(false));
        $select = $mockForm->addElement('select', 'foo', array('multiple'))
                           ->loadOptions(array('one' => 'First label', 'two' => 'Second label'));
        $box    = $mockForm->addElement('checkbox', 'bar');
        $mockPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($mockForm)
        );
        $controller = new HTML_QuickForm2_Controller('bug8687', false);
        $controller->addPage($mockPage);
        $controller->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'foo' => array('two'),
            'bar' => '1'
        )));

        $this->assertFalse($controller->isValid());
        $this->assertEquals(array('two'), $select->getValue());
        $this->assertEquals('1', $box->getValue());
    }
}
?>