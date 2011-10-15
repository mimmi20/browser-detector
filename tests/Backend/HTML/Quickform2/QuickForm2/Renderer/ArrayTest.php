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
 * @version    SVN: $Id: ArrayTest.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Renderer base class
 */
require_once 'HTML/QuickForm2/Renderer.php';

/**
 * Class representing a HTML form
 */
require_once 'HTML/QuickForm2.php';

/**
 * Unit test for HTML_QuickForm2_Renderer_Array class
 */
class HTML_QuickForm2_Renderer_ArrayTest extends PHPUnit_Framework_TestCase
{
    private function _assertHasKeys($array, $keys)
    {
        sort($keys);
        $realKeys = array_keys($array);
        sort($realKeys);
        $this->assertEquals($keys, $realKeys);
    }

    public function testRenderElementSeparately()
    {
        $element  = HTML_QuickForm2_Factory::createElement(
            'text', 'foo', array('id' => 'arrayRenderElement')
        );
        $renderer = HTML_QuickForm2_Renderer::factory('array');

        $array = $element->render($renderer)->toArray();

        $this->_assertHasKeys(
            $array,
            array('id', 'html', 'value', 'type', 'required', 'frozen')
        );

        $element->setLabel('Foo label:');
        $element->setError('an error!');
        $array = $element->render($renderer->reset())->toArray();
        $this->assertArrayHasKey('label', $array);
        $this->assertArrayHasKey('error', $array);
    }

    public function testRenderHidden()
    {
        $hidden = HTML_QuickForm2_Factory::createElement(
            'hidden', 'bar', array('id' => 'arrayRenderHidden')
        );
        $renderer = HTML_QuickForm2_Renderer::factory('array')
            ->setOption('group_hiddens', false);

        $array = $hidden->render($renderer)->toArray();
        $this->_assertHasKeys(
            $array,
            array('id', 'html', 'value', 'type', 'required', 'frozen')
        );

        $array = $hidden->render(
                    $renderer->setOption('group_hiddens', true)->reset()
                 )->toArray();
        $this->assertEquals(array('hidden'), array_keys($array));
        $this->assertEquals($hidden->__toString(), $array['hidden'][0]);
    }

    public function testRenderContainerSeparately()
    {
        $fieldset = HTML_QuickForm2_Factory::createElement(
            'fieldset', 'baz', array('id' => 'arrayRenderContainer')
        );
        $renderer = HTML_QuickForm2_Renderer::factory('array');

        $array = $fieldset->render($renderer)->toArray();
        $this->_assertHasKeys(
            $array,
            array('id', 'type', 'required', 'frozen', 'elements', 'attributes')
        );
        $this->assertEquals(array(), $array['elements']);

        $fieldset->setLabel('a label');
        $fieldset->setError('an error!');
        $text = $fieldset->addText('insideFieldset');
        $array = $fieldset->render($renderer->reset())->toArray();
        $this->assertArrayHasKey('label', $array);
        $this->assertArrayHasKey('error', $array);
        $this->assertEquals($array['elements'][0]['html'], $text->__toString());
    }

    public function testRenderNestedContainers()
    {
        $fieldset = HTML_QuickForm2_Factory::createElement(
            'fieldset', 'quux', array('id' => 'arrayNestedContainers')
        );
        $group = $fieldset->addElement('group', 'xyzzy', array('id' => 'arrayInnerContainer'))
                    ->setSeparator('<br />');
        $text  = $group->addElement('text', 'foobar', array('id' => 'arrayInnermost'));
        $renderer = HTML_QuickForm2_Renderer::factory('array');

        $array   = $fieldset->render($renderer)->toArray();
        $elArray = $text->render($renderer->reset())->toArray();
        $this->assertArrayHasKey('elements', $array['elements'][0]);
        $this->assertArrayHasKey('separator', $array['elements'][0]);
        $this->assertEquals($elArray, $array['elements'][0]['elements'][0]);
    }

    public function testRenderGroupedErrors()
    {
        $form     = new HTML_QuickForm2('arrayGroupedErrors');
        $element  = $form->addText('testArrayGroupedErrors')->setError('Some error');
        $renderer = HTML_QuickForm2_Renderer::factory('array')
                        ->setOption('group_errors', false);

        $this->assertArrayNotHasKey('errors', $form->render($renderer)->toArray());

        $array = $form->render($renderer->setOption('group_errors', true))->toArray();
        $this->assertArrayNotHasKey('error', $array['elements'][0]);
        $this->assertContains('Some error', $array['errors']);
    }

    public function testRenderRequiredNote()
    {
        $form = new HTML_QuickForm2('arrayReqnote');
        $element = $form->addText('testArrayReqnote');

        $renderer = HTML_Quickform2_Renderer::factory('array')
            ->setOption('required_note', 'This is requi-i-i-ired!');

        $this->assertArrayNotHasKey('required_note', $form->render($renderer)->toArray());

        $element->addRule('required', 'error message');
        $array = $form->render($renderer)->toArray();
        $this->assertEquals('This is requi-i-i-ired!', $array['required_note']);
    }

    public function testRenderWithStyle()
    {
        $form = new HTML_QuickForm2('arrayStyle');
        $text1 = $form->addText('foo', array('id' => 'testArrayWithStyle'));
        $text2 = $form->addText('bar', array('id' => 'testArrayWithoutStyle'));
        $renderer = HTML_Quickform2_Renderer::factory('array')
            ->setStyleForId('testArrayWithStyle', 'weird');

        $array = $form->render($renderer)->toArray();
        $this->assertEquals('weird', $array['elements'][0]['style']);
        $this->assertArrayNotHasKey('style', $array['elements'][1]);
    }

    public function testRenderStaticLabels()
    {
        $element  = HTML_QuickForm2_Factory::createElement('text', 'static')
                        ->setLabel(array('a label', 'another label', 'foo' => 'named label'));
        $renderer = HTML_QuickForm2_Renderer::factory('array')
                        ->setOption('static_labels', false);

        $array = $element->render($renderer)->toArray();
        $this->assertType('array', $array['label']);

        $array = $element->render(
                    $renderer->setOption('static_labels', true)->reset()
                 )->toArray();
        $this->assertEquals('a label', $array['label']);
        $this->assertEquals('another label', $array['label_2']);
        $this->assertEquals('named label', $array['label_foo']);
    }
}
?>
