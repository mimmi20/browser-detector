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
 * @version    SVN: $Id: InputTest.php 102 2011-10-25 21:18:56Z  $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Class for <input> elements
 */
require_once 'HTML/QuickForm2/Element/Input.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * We need to set the element's type
 */
class HTML_QuickForm2_Element_InputImpl extends HTML_QuickForm2_Element_Input
{
    public function __construct($name = null, $attributes = null, array $data = array())
    {
        parent::__construct($name, $attributes, $data);
        $this->attributes['type'] = 'concrete';
    }
}


/**
 * Unit test for HTML_QuickForm2_Element_Input class
 */
class HTML_QuickForm2_Element_InputTest extends PHPUnit_Framework_TestCase
{
    public function testTypeAttributeIsReadonly()
    {
        $obj = new HTML_QuickForm2_Element_InputImpl();
        try {
            $obj->removeAttribute('type');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertEquals("Attribute 'type' is read-only", $e->getMessage());
            try {
                $obj->setAttribute('type', 'bogus');
            } catch (HTML_QuickForm2_InvalidArgumentException $e) {
                $this->assertEquals("Attribute 'type' is read-only", $e->getMessage());
                return;
            }
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }

    public function testCanSetAndGetValue()
    {
        $obj = new HTML_QuickForm2_Element_InputImpl();

        $this->assertSame($obj, $obj->setValue('foo'));
        $this->assertEquals($obj->getValue(), 'foo');

        $obj->setAttribute('value', 'bar');
        $this->assertEquals($obj->getValue(), 'bar');

        $obj->setAttribute('disabled');
        $this->assertNull($obj->getValue());
    }

    public function testHtmlGeneration()
    {
        $obj = new HTML_QuickForm2_Element_InputImpl();
        $this->assertRegExp('!<input[^>]*type="concrete"[^>]*/>!', $obj->__toString());
    }

    public function testFrozenHtmlGeneration()
    {
        $obj = new HTML_QuickForm2_Element_InputImpl('test');
        $obj->setValue('bar');
        $obj->toggleFrozen(true);

        $obj->persistentFreeze(false);
        $this->assertNotRegExp('/[<>]/', $obj->__toString());
        $this->assertRegExp('/bar/', $obj->__toString());

        $obj->persistentFreeze(true);
        $this->assertRegExp('!<input[^>]*type="hidden"[^>]*/>!', $obj->__toString());

        $obj->setAttribute('disabled');
        $this->assertRegExp('/bar/', $obj->__toString());
        $this->assertNotRegExp('!<input[^>]*type="hidden"[^>]*/>!', $obj->__toString());
    }
}
?>