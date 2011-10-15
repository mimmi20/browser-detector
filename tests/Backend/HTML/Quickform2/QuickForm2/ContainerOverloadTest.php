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
 * @version    SVN: $Id: ContainerOverloadTest.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Container class
 */
require_once 'HTML/QuickForm2/Container.php';

/**
 * Base class for "scalar" elements
 */
require_once 'HTML/QuickForm2/Element.php';

/**
 * Base class for "checkbox" elements, used in tests
 */
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(__FILE__)) . '/TestHelper.php';


/**
 * Unit test for HTML_QuickForm2_Container overloaded methods
 */
class HTML_QuickForm2_ContainerOverloadTest extends PHPUnit_Framework_TestCase
{
    public function testAddElements()
    {
        $c = new HTML_QuickForm2_ContainerImpl('cCOT1');
        $el1 = $c->addText('eCOT1', array('size' => 30), array('label' => 'Label'));
        $this->assertSame($el1, $c->getElementById('eCOT1-0'));

        $f = $c->addFieldset('fCOT1', null, array('label' => 'Fieldset'));
        $el2 = $f->addTextarea('eCOT2');
        $this->assertSame($el2, $c->getElementById('eCOT2-0'));
    }


    public function testAddElementsWithBracketsInName()
    {
        $c = new HTML_QuickForm2_ContainerImpl('cCOT0');
        $el1 = $c->addCheckbox('chCOT[]');
        $el2 = $c->addCheckbox('chCOT[]');
        $this->assertSame($el1, $c->getElementById('chCOT-0-0'));
        $this->assertSame($el2, $c->getElementById('chCOT-1-0'));
    }

    public function testAddUnknownType()
    {
        $c = new HTML_QuickForm2_ContainerImpl('cCOT2');
        try {
            $c->addUnknown('uCOT1');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertEquals("Element type 'unknown' is not known", $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }


    public function testAddElementWithUnderscoreInType()
    {
        HTML_QuickForm2_Factory::registerElement('super_box', 'HTML_QuickForm2_Element_InputCheckbox');
        $this->assertTrue(HTML_QuickForm2_Factory::isElementRegistered('super_box'));

        $c = new HTML_QuickForm2_ContainerImpl('cCOT3');
        $el1 = $c->addSuper_Box('sBox_1');
        $el2 = $c->addsuper_box('sBox_2');
        $el3 = $c->addSuper_box('sBox_3');
        $this->assertSame($el1, $c->getElementById('sBox_1-0'));
        $this->assertSame($el2, $c->getElementById('sBox_2-0'));
        $this->assertSame($el3, $c->getElementById('sBox_3-0'));

        try {
            $c->addSuper_Select('sSel_1');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertEquals("Element type 'super_select' is not known", $e->getMessage());
            return;
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }

}
?>