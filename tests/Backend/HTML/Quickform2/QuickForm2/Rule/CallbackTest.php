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
 * @version    SVN: $Id: CallbackTest.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Rule checking the value via a callback function (method)
 */
require_once 'HTML/QuickForm2/Rule/Callback.php';

/**
 * Element class
 */
require_once 'HTML/QuickForm2/Element.php';

/**
 * Unit test for HTML_QuickForm2_Rule_Callback class
 */
class HTML_QuickForm2_Rule_CallbackTest extends PHPUnit_Framework_TestCase
{
    public function checkNotFoo($value)
    {
        return $value != 'foo';
    }

    public function testValidCallbackRequired()
    {
        $mockEl  = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                  'getRawValue', 'setValue', '__toString'));
        try {
            $callbackMissing = new HTML_QuickForm2_Rule_Callback($mockEl, 'an error');
            $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/Callback Rule requires a valid callback/', $e->getMessage());
        }
        try {
            $callbackBogus = new HTML_QuickForm2_Rule_Callback($mockEl, 'an error',
                                    array('callback' => 'bogusfunctionname'));
            $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/Callback Rule requires a valid callback/', $e->getMessage());
        }
    }

    public function testOptionsHandling()
    {
        $mockEl  = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                  'getRawValue', 'setValue', '__toString'));
        $mockEl->expects($this->atLeastOnce())
               ->method('getRawValue')->will($this->returnValue('foo'));

        $strlen = new HTML_QuickForm2_Rule_Callback($mockEl, 'an error', 'strlen');
        $this->assertTrue($strlen->validate());

        $notFoo = new HTML_QuickForm2_Rule_Callback($mockEl, 'an error', array($this, 'checkNotFoo'));
        $this->assertFalse($notFoo->validate());

        $inArray = new HTML_QuickForm2_Rule_Callback($mockEl, 'an error',
                        array('callback' => 'in_array',
                              'arguments' => array(array('foo', 'bar', 'baz'))));
        $this->assertTrue($inArray->validate());
    }

    public function testConfigHandling()
    {
        $mockEl  = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                  'getRawValue', 'setValue', '__toString'));
        $mockEl->expects($this->atLeastOnce())
               ->method('getRawValue')->will($this->returnValue('foo'));

        HTML_QuickForm2_Factory::registerRule('strlen', 'HTML_QuickForm2_Rule_Callback', null, 'strlen');
        $strlen = HTML_QuickForm2_Factory::createRule('strlen', $mockEl, 'an error');
        $this->assertTrue($strlen->validate());

        HTML_QuickForm2_Factory::registerRule('inarray', 'HTML_QuickForm2_Rule_Callback', null,
                                    array('callback' => 'in_array',
                                          'arguments' => array(array('foo', 'bar', 'baz'))));
        $inArray = HTML_QuickForm2_Factory::createRule('inarray', $mockEl, 'an error');
        $this->assertTrue($inArray->validate());

        HTML_QuickForm2_Factory::registerRule('inarray2', 'HTML_QuickForm2_Rule_Callback', null, 'in_array');
        $inArray2 = HTML_QuickForm2_Factory::createRule('inarray2', $mockEl, 'an error',
                                array(array('one', 'two', 'three')));
        $this->assertFalse($inArray2->validate());
    }

    public function testConfigOverridesOptions()
    {
        $mockEl  = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                  'getRawValue', 'setValue', '__toString'));
        $mockEl->expects($this->atLeastOnce())
               ->method('getRawValue')->will($this->returnValue('foo'));

        HTML_QuickForm2_Factory::registerRule('inarray-override', 'HTML_QuickForm2_Rule_Callback', null,
                                    array('callback' => 'in_array',
                                          'arguments' => array(array('foo', 'bar', 'baz'))));
        $rule1 = HTML_QuickForm2_Factory::createRule('inarray-override', $mockEl, 'an error',
                                    array('callback' => array($this, 'checkNotFoo')));
        $rule2 = HTML_QuickForm2_Factory::createRule('inarray-override', $mockEl, 'an error',
                                    array('arguments' => array(array('one', 'two', 'three'))));
        $this->assertTrue($rule1->validate());
        $this->assertTrue($rule2->validate());
    }
}
?>
