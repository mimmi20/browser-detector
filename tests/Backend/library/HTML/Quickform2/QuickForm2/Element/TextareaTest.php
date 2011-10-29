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
 * @version    SVN: $Id: TextareaTest.php 102 2011-10-25 21:18:56Z  $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Class for <textarea> elements
 */
require_once 'HTML/QuickForm2/Element/Textarea.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Unit test for HTML_QuickForm2_Element_Textarea class
 */
class HTML_QuickForm2_Element_TextareaTest extends PHPUnit_Framework_TestCase
{
    public function testTextareaIsEmptyByDefault()
    {
        $area = new HTML_QuickForm2_Element_Textarea();
        $this->assertNull($area->getValue());
        $this->assertRegExp('!\\s*<textarea[^>]*></textarea>\\s*!', $area->__toString());
    }

    public function testSetAndGetValue()
    {
        $area = new HTML_QuickForm2_Element_Textarea();
        $this->assertSame($area, $area->setValue('Some string'));
        $this->assertEquals('Some string', $area->getValue());
        $this->assertRegExp('!\\s*<textarea[^>]*>Some string</textarea>\\s*!', $area->__toString());

        $area->setAttribute('disabled');
        $this->assertNull($area->getValue());
        $this->assertRegExp('!\\s*<textarea[^>]*>Some string</textarea>\\s*!', $area->__toString());
    }

    public function testValueOutputIsEscaped()
    {
        $area = new HTML_QuickForm2_Element_Textarea();
        $area->setValue('<foo>');
        $this->assertNotRegExp('/<foo>/', $area->__toString());

        $area->toggleFrozen(true);
        $this->assertNotRegExp('/<foo>/', $area->__toString());
    }

    public function testFrozenHtmlGeneration()
    {
        $area = new HTML_QuickForm2_Element_Textarea('freezeMe');
        $area->setValue('Some string');

        $area->toggleFrozen(true);
        $this->assertRegExp('/Some string/', $area->__toString());
        $this->assertRegExp('!<input[^>]*type="hidden"[^>]*/>!', $area->__toString());

        $area->persistentFreeze(false);
        $this->assertRegExp('/Some string/', $area->__toString());
        $this->assertNotRegExp('!<input[^>]*type="hidden"[^>]*/>!', $area->__toString());

        $area->persistentFreeze(true);
        $area->setAttribute('disabled');
        $this->assertRegExp('/Some string/', $area->__toString());
        $this->assertNotRegExp('!<input[^>]*type="hidden"[^>]*/>!', $area->__toString());
    }
}
?>
