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
 * @version    SVN: $Id: EachTest.php 102 2011-10-25 21:18:56Z  $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';
/** Validates all elements in a Container using a template Rule */
require_once 'HTML/QuickForm2/Rule/Each.php';
/** Element class */
require_once 'HTML/QuickForm2/Element.php';
/** Container class */
require_once 'HTML/QuickForm2/Container.php';

/**
 * Unit test for HTML_QuickForm2_Rule_Each class
 */
class HTML_QuickForm2_Rule_EachTest extends PHPUnit_Framework_TestCase
{
    public function testTemplateRuleNeeded()
    {
        $mockEl = $this->getMock(
            'HTML_QuickForm2_Container', array('getType', 'setValue', '__toString')
        );
        try {
            $each = new HTML_QuickForm2_Rule_Each($mockEl);
            $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertContains('Each Rule requires a template Rule to validate with', $e->getMessage());
        }
        try {
            $each2 = new HTML_QuickForm2_Rule_Each($mockEl, '', 'A rule?');
            $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertContains('Each Rule requires a template Rule to validate with', $e->getMessage());
        }
    }

    public function testCannotUseRequiredAsTemplate()
    {
        $mockEl = $this->getMock(
            'HTML_QuickForm2_Container', array('getType', 'setValue', '__toString')
        );
        try {
            $each = new HTML_QuickForm2_Rule_Each($mockEl, 'an error', $mockEl->createRule('required', 'an error'));
            $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertContains('Cannot use "required" Rule as a template', $e->getMessage());
        }
    }

    public function testCanOnlyValidateContainers()
    {
        $mockEl = $this->getMock('HTML_QuickForm2_Element', array('getType',
                                 'getRawValue', 'setValue', '__toString'));
        try {
            $each = new HTML_QuickForm2_Rule_Each(
                $mockEl, '', $mockEl->createRule('empty')
            );
            $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertContains('Each Rule can only validate Containers', $e->getMessage());
        }
    }

    public function testValidatesWithTemplateRule()
    {
        $mockContainer = $this->getMock(
            'HTML_QuickForm2_Container', array('getType', 'setValue', '__toString')
        );
        $foo = $mockContainer->addElement('text', 'foo')->setValue('');
        $bar = $mockContainer->addElement('text', 'bar')->setValue('I am not empty');
        $baz = $mockContainer->addElement('text', 'baz')->setValue('');

        $each = new HTML_QuickForm2_Rule_Each(
            $mockContainer, 'an error', $mockContainer->createRule('empty')
        );
        $this->assertFalse($each->validate());

        $mockContainer->removeChild($bar);
        $this->assertTrue($each->validate());
    }

    public function testSetsErrorOnContainer()
    {
        $mockContainer = $this->getMock(
            'HTML_QuickForm2_Container', array('getType', 'setValue', '__toString')
        );
        $foo = $mockContainer->addElement('text', 'foo')->setValue('');
        $bar = $mockContainer->addElement('text', 'bar')->setValue('I am not empty');

        $each = new HTML_QuickForm2_Rule_Each(
            $mockContainer, 'Real error', $mockContainer->createRule('empty', 'Template error')
        );
        $this->assertFalse($each->validate());
        $this->assertEquals('Real error', $mockContainer->getError());
        $this->assertEquals('', $bar->getError());
    }

    public function testChainedRulesAreIgnored()
    {
        $mockContainer = $this->getMock(
            'HTML_QuickForm2_Container', array('getType', 'setValue', '__toString')
        );

        $foo = $mockContainer->addElement('text', 'foo')->setValue('');
        $ruleIgnored = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner'),
            array($foo)
        );
        $ruleIgnored->expects($this->never())->method('validateOwner');

        $each = new HTML_QuickForm2_Rule_Each(
            $mockContainer, 'an error', $mockContainer->createRule('empty')
                                                      ->and_($ruleIgnored)
        );
        $this->assertTrue($each->validate());
    }

    public function testValidateNestedContainer()
    {
        $mockOuter = $this->getMock(
            'HTML_QuickForm2_Container', array('getType', 'setValue', '__toString')
        );
        $mockInner = $this->getMock(
            'HTML_QuickForm2_Container', array('getType', 'setValue', '__toString')
        );
        $foo = $mockOuter->addElement('text', 'foo')->setValue('');
        $bar = $mockInner->addElement('text', 'bar')->setValue('not empty');
        $mockOuter->appendChild($mockInner);

        $each = new HTML_QuickForm2_Rule_Each(
            $mockOuter, 'Real error', $mockOuter->createRule('empty')
        );
        $this->assertFalse($each->validate());

        $bar->setValue('');
        $this->assertTrue($each->validate());
    }

    public function testIgnoresStaticServerSide()
    {
        $mockContainer = $this->getMock(
            'HTML_QuickForm2_Container', array('getType', 'setValue', '__toString')
        );
        $mockContainer->addElement('static', 'noValidateServer');

        $rule = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner'),
            array($mockContainer, 'a message')
        );
        $rule->expects($this->any())->method('validateOwner')
             ->will($this->returnValue(false));

        $each = new HTML_QuickForm2_Rule_Each($mockContainer, 'an error', $rule);
        $this->assertTrue($each->validate());
    }

    public function testIgnoresStaticClientSide()
    {
        $mockContainer = $this->getMock(
            'HTML_QuickForm2_Container', array('getType', 'setValue', '__toString')
        );
        $mockContainer->addElement('static', 'noValidateClient');

        $rule = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner', 'getJavascriptCallback'),
            array($mockContainer, 'a message')
        );
        $rule->expects($this->any())->method('getJavascriptCallback')
             ->will($this->returnValue('staticCallback'));

        $each = new HTML_QuickForm2_Rule_Each($mockContainer, 'an error', $rule);
        $this->assertNotContains('staticCallback', $each->getJavascript());
    }

    public function testValidationTriggers()
    {
        $mockContainer = $this->getMock(
            'HTML_QuickForm2_Container', array('getType', 'setValue', '__toString')
        );
        $foo = $mockContainer->addElement('text', 'foo', array('id' => 'foo'));
        $bar = $mockContainer->addElement('text', 'bar', array('id' => 'bar'));

        $rule = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner', 'getJavascriptCallback'),
            array($mockContainer, 'a message')
        );
        $rule->expects($this->any())->method('getJavascriptCallback')
             ->will($this->returnValue('a callback'));
        $each = new HTML_QuickForm2_Rule_Each($mockContainer, 'an error', $rule);
        $this->assertContains('["foo","bar"]', $each->getJavascript());
    }
}
?>