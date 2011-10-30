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

/**
 * Base class for radios and checkboxes
 */
require_once 'HTML/QuickForm2/Element/InputCheckable.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Array-based data source for HTML_QuickForm2 objects
 */
require_once 'HTML/QuickForm2/DataSource/Array.php';

/**
 * Class representing a HTML form
 */
require_once 'HTML/QuickForm2.php';

/**
 * Unit test for HTML_QuickForm2_Element_InputCheckable class
 */
class HTML_QuickForm2_Element_InputCheckableTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorSetsContent()
    {
        $checkable = new HTML_QuickForm2_Element_InputCheckable('foo', null, array('content' => 'I am foo'));
        $this->assertEquals('I am foo', $checkable->getContent());
    }

    public function testContentRendering()
    {
        $checkable = new HTML_QuickForm2_Element_InputCheckable(
            'foo', array('id' => 'checkableFoo'), array('content' => 'I am foo')
        );
        $this->assertRegExp(
            '!<label\\s+for="checkableFoo">I am foo</label>!',
            $checkable->__toString()
        );

        $checkable->toggleFrozen(true);
        $this->assertNotRegExp('!<label!', $checkable->__toString());

        $checkable->toggleFrozen(false);
        $this->assertSame($checkable, $checkable->setContent(''));
        $this->assertNotRegExp('!<label!', $checkable->__toString());
    }

    public function testEmptyContentRendering()
    {
        $checkable = new HTML_QuickForm2_Element_InputCheckable(
            'foo1', array('id' => 'checkableFoo1')
        );
        $this->assertNotRegExp('!<label!', $checkable->__toString());
    }

    public function testSetAndGetValue()
    {
        $checkable = new HTML_QuickForm2_Element_InputCheckable();
        $checkable->setAttribute('value', 'my value');

        $this->assertNull($checkable->getValue());

        $this->assertSame($checkable, $checkable->setValue('my value'));
        $this->assertEquals('checked', $checkable->getAttribute('checked'));
        $this->assertEquals('my value', $checkable->getValue());

        $this->assertSame($checkable, $checkable->setValue('not my value!'));
        $this->assertNull($checkable->getAttribute('checked'));
        $this->assertNull($checkable->getValue());

        $checkable->setAttribute('checked');
        $this->assertEquals('my value', $checkable->getValue());
    }

    public function testGetValueDisabled()
    {
        $checkable = new HTML_QuickForm2_Element_InputCheckable();
        $checkable->setAttribute('value', 'my value');

        $checkable->setValue('my value');
        $checkable->setAttribute('disabled');
        $this->assertEquals('checked', $checkable->getAttribute('checked'));
        $this->assertNull($checkable->getValue());
    }

    public function testFrozenHtmlGeneration()
    {
        $checkable = new HTML_QuickForm2_Element_InputCheckable(
            'checkableFreeze', array('value' => 'my value'), array('content' => 'freeze me')
        );
        $checkable->setAttribute('checked');

        $checkable->toggleFrozen(true);
        $this->assertRegExp('!<input[^>]*type="hidden"[^>]*/>!', $checkable->__toString());

        $checkable->removeAttribute('checked');
        $this->assertNotRegExp('!<input!', $checkable->__toString());
    }

    public function testBug15708()
    {
        $form = new HTML_QuickForm2('bug15708');
        $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'aRadio' => 1
        )));
        $aRadio = $form->appendChild(
                            new HTML_QuickForm2_Element_InputCheckable('aRadio')
                      )->setAttribute('value', 1);
        $this->assertContains('checked', $aRadio->__toString());
    }

}
?>
