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
 * @author     Bertrand Mansion <golgote@mamasam.com>
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Javascript aggregator and builder class
 */
require_once 'HTML/QuickForm2/JavascriptBuilder.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(__FILE__)) . '/TestHelper.php';

/**
 * Base class for HTML_QuickForm2 rules
 */
require_once 'HTML/QuickForm2/Rule.php';

/**
 * Class for <input type="text" /> elements
 *
 * We need a subclass of Node that can be instantiated
 */
require_once 'HTML/QuickForm2/Element/InputText.php';

/**
 * Unit test for HTML_QuickForm2_JavascriptBuilder class
 */
class HTML_QuickForm2_JavascriptBuilderTest extends PHPUnit_Framework_TestCase
{
    public function testEncode()
    {
        $this->assertEquals('null', HTML_QuickForm2_JavascriptBuilder::encode(null));
        $this->assertEquals('false', HTML_QuickForm2_JavascriptBuilder::encode(false));
        $this->assertEquals('"foo"', HTML_QuickForm2_JavascriptBuilder::encode('foo'));
        $this->assertEquals('"\r\n\t\\\'\"bar\\\\"', HTML_QuickForm2_JavascriptBuilder::encode("\r\n\t'\"bar\\"));
        $this->assertEquals(1, HTML_QuickForm2_JavascriptBuilder::encode(1));

        $this->assertEquals('[]', HTML_QuickForm2_JavascriptBuilder::encode(array()));
        $this->assertEquals('{}', HTML_QuickForm2_JavascriptBuilder::encode(new stdClass()));

        $this->assertEquals('["a","b"]', HTML_QuickForm2_JavascriptBuilder::encode(array('a', 'b')));
        $this->assertEquals('{"0":"a","b":"c"}', HTML_QuickForm2_JavascriptBuilder::encode(array('a', 'b' => 'c')));

        $obj = new stdClass();
        $obj->a = 'b';
        $obj->c = 'd';
        $obj->e = array('f', 'g');
        $this->assertEquals('{"a":"b","c":"d","e":["f","g"]}', HTML_QuickForm2_JavascriptBuilder::encode($obj));

        try {
            $fp = fopen(__FILE__, 'rb');
            HTML_QuickForm2_JavascriptBuilder::encode($fp);
            $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {}
        fclose($fp);
    }

    public function testBaseLibrary()
    {
        $builder = new HTML_QuickForm2_JavascriptBuilder();

        $libraries = $builder->getLibraries(false, false);
        $this->assertArrayHasKey('base', $libraries);
        $this->assertNotContains('<script', $libraries['base']);

        $libraries = $builder->getLibraries(false, true);
        $this->assertContains('<script', $libraries['base']);

        $libraries = $builder->getLibraries(true, false);
        $this->assertContains('qf.Validator', $libraries);
        $this->assertNotContains('<script', $libraries);

        $libraries = $builder->getLibraries(true, true);
        $this->assertContains('qf.Validator', $libraries);
        $this->assertContains('<script', $libraries);
    }

    public function testInlineMissingLibrary()
    {
        $builder = new HTML_QuickForm2_JavascriptBuilder();
        $builder->addLibrary('missing', 'missing.js');

        try {
            $libraries = $builder->getLibraries(true);
            $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
        } catch (HTML_QuickForm2_NotFoundException $e) { }
    }

    public function testFormJavascript()
    {
        $builder = new HTML_QuickForm2_JavascriptBuilder();
        $element = new HTML_QuickForm2_Element_InputText();

        $mockRuleOne = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner', 'getJavascriptCallback'),
            array($element)
        );
        $mockRuleOne->expects($this->once())->method('getJavascriptCallback')
            ->will($this->returnValue('jsRuleOne'));

        $mockRuleTwo = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner', 'getJavascriptCallback'),
            array($element)
        );
        $mockRuleTwo->expects($this->once())->method('getJavascriptCallback')
            ->will($this->returnValue('jsRuleTwo'));

        $this->assertEquals('', $builder->getFormJavascript());

        $builder->setFormId('formOne');
        $builder->addRule($mockRuleOne);
        $builder->addElementJavascript('setupCodeOne');

        $builder->setFormId('formTwo');
        $builder->addRule($mockRuleTwo);
        $builder->addElementJavascript('setupCodeTwo');

        $scriptOne = $builder->getFormJavascript('formOne', false);
        $this->assertContains('jsRuleOne', $scriptOne);
        $this->assertContains('setupCodeOne', $scriptOne);
        $this->assertNotContains('jsRuleTwo', $scriptOne);
        $this->assertNotContains('setupCodeTwo', $scriptOne);
        $this->assertNotContains('<script', $scriptOne);

        $scriptTwo = $builder->getFormJavascript('formTwo', true);
        $this->assertNotContains('jsRuleOne', $scriptTwo);
        $this->assertNotContains('setupCodeOne', $scriptTwo);
        $this->assertContains('jsRuleTwo', $scriptTwo);
        $this->assertContains('setupCodeTwo', $scriptTwo);
        $this->assertContains('<script', $scriptTwo);

        $scriptBoth = $builder->getFormJavascript();
        $this->assertContains('jsRuleOne', $scriptBoth);
        $this->assertContains('setupCodeTwo', $scriptBoth);
    }
}
?>