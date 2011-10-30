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
require_once dirname(dirname(__FILE__)) . '/TestHelper.php';

/**
 * Renderer base class
 */
require_once 'HTML/QuickForm2/Renderer.php';

/**
 * Renderer plugin interface
 */
require_once 'HTML/QuickForm2/Renderer/Plugin.php';

/**
 * An "implementation" of renderer, to be able to create an instance
 */
class HTML_QuickForm2_FakeRenderer extends HTML_QuickForm2_Renderer
{
    public $name = 'fake';

    public function renderElement(HTML_QuickForm2_Node $element) {}
    public function renderHidden(HTML_QuickForm2_Node $element) {}
    public function startForm(HTML_QuickForm2_Node $form) {}
    public function finishForm(HTML_QuickForm2_Node $form) {}
    public function startContainer(HTML_QuickForm2_Node $container) {}
    public function finishContainer(HTML_QuickForm2_Node $container) {}
    public function startGroup(HTML_QuickForm2_Node $group) {}
    public function finishGroup(HTML_QuickForm2_Node $group) {}
}

/**
 * Plugin for FakeRenderer
 */
class HTML_QuickForm2_FakeRenderer_HelloPlugin
    extends HTML_QuickForm2_Renderer_Plugin
{
    public function sayHello()
    {
        return sprintf('Hello, %s!', $this->renderer->name);
    }
}

/**
 * Another plugin for FakeRenderer
 */
class HTML_QuickForm2_FakeRenderer_GoodbyePlugin
    extends HTML_QuickForm2_Renderer_Plugin
{
    public function sayGoodbye()
    {
        return sprintf('Goodbye, %s!', $this->renderer->name);
    }
}

/**
 * Yet another plugin for FakeRenderer with duplicate method name
 */
class HTML_QuickForm2_FakeRenderer_AnotherHelloPlugin
    extends HTML_QuickForm2_Renderer_Plugin
{
    public function sayHello()
    {
        return 'Hello, world!';
    }
}

/**
 * Unit test for HTML_QuickForm2_Renderer class
 */
class HTML_QuickForm2_RendererTest extends PHPUnit_Framework_TestCase
{
    public function testRegisterRenderer()
    {
        $type = 'fake' . mt_rand();
        HTML_Quickform2_Renderer::register($type, 'HTML_QuickForm2_FakeRenderer');

        $renderer = HTML_Quickform2_Renderer::factory($type);
        $this->assertType('HTML_QuickForm2_Renderer', $renderer);
    }

    public function testRegisterOnlyOnce()
    {
        try {
            HTML_Quickform2_Renderer::register('default', 'HTML_QuickForm2_FakeRenderer');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/already registered/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }

    public function testRegisterPlugin()
    {
        $type = 'fake' . mt_rand();
        HTML_QuickForm2_Renderer::register($type, 'HTML_QuickForm2_FakeRenderer');
        HTML_QuickForm2_Renderer::registerPlugin($type, 'HTML_QuickForm2_FakeRenderer_HelloPlugin');

        $renderer = HTML_Quickform2_Renderer::factory($type);
        $this->assertTrue($renderer->methodExists('renderElement'));
        $this->assertTrue($renderer->methodExists('sayHello'));
        $this->assertFalse($renderer->methodExists('sayGoodbye'));
        HTML_QuickForm2_Renderer::registerPlugin($type, 'HTML_QuickForm2_FakeRenderer_GoodbyePlugin');
        $this->assertTrue($renderer->methodExists('sayGoodbye'));

        $this->assertEquals('Hello, fake!', $renderer->sayHello());
        $this->assertEquals('Goodbye, fake!', $renderer->sayGoodbye());
    }

    public function testRegisterPluginOnlyOnce()
    {
        $type = 'fake' . mt_rand();
        HTML_QuickForm2_Renderer::register($type, 'HTML_QuickForm2_FakeRenderer');
        HTML_QuickForm2_Renderer::registerPlugin($type, 'HTML_QuickForm2_FakeRenderer_HelloPlugin');

        try {
            HTML_QuickForm2_Renderer::registerPlugin($type, 'HTML_QuickForm2_FakeRenderer_HelloPlugin');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/already registered/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }

    public function testDuplicateMethodNamesDisallowed()
    {
        $type = 'fake' . mt_rand();
        HTML_QuickForm2_Renderer::register($type, 'HTML_QuickForm2_FakeRenderer');
        HTML_QuickForm2_Renderer::registerPlugin($type, 'HTML_QuickForm2_FakeRenderer_HelloPlugin');
        HTML_QuickForm2_Renderer::registerPlugin($type, 'HTML_QuickForm2_FakeRenderer_AnotherHelloPlugin');

        try {
            $renderer = HTML_Quickform2_Renderer::factory($type);
            $renderer->sayHello();
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegexp('/^Duplicate method name/', $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }
}
?>
