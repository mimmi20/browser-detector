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
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/TestHelper.php';

/** Class implementing the Page Controller pattern for multipage forms */
require_once 'HTML/QuickForm2/Controller.php';

/** Class representing a HTML form */
require_once 'HTML/QuickForm2.php';

/** Action handler for going to a specific page of a multipage form */
require_once 'HTML/QuickForm2/Controller/Action/Direct.php';

/**
 * Unit test for HTML_QuickForm2_Controller_Action_Direct class
 */
class HTML_QuickForm2_Controller_Action_DirectTest
    extends PHPUnit_Framework_TestCase
{
    public function testPerform()
    {
        $source = $this->getMock(
            'HTML_QuickForm2', array('validate', 'getValue'),
            array('source')
        );
        $source->expects($this->once())->method('validate')
               ->will($this->returnValue(true));
        $source->expects($this->once())->method('getValue')
               ->will($this->returnValue(array('foo' => 'bar')));
        $sourcePage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array($source)
        );
        $sourcePage->addHandler('destination', new HTML_QuickForm2_Controller_Action_Direct());
        $destPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('destination'))
        );
        $mockJump = $this->getMock(
            'HTML_QuickForm2_Controller_Action', array('perform')
        );
        $mockJump->expects($this->once())->method('perform')
                 ->will($this->returnValue('jump to destination'));
        $destPage->addHandler('jump', $mockJump);

        $controller = new HTML_QuickForm2_Controller('testDirectAction');
        $controller->addPage($sourcePage);
        $controller->addPage($destPage);

        $this->assertEquals('jump to destination', $sourcePage->handle('destination'));
        $this->assertTrue($controller->getSessionContainer()->getValidationStatus('source'));
        $this->assertEquals(array('foo' => 'bar'), $controller->getSessionContainer()->getValues('source'));
    }
}
?>