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
 * @version    SVN: $Id: SelectTest.php 102 2011-10-25 21:18:56Z  $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Class for <select> elements
 */
require_once 'HTML/QuickForm2/Element/Select.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Let's just make parseAttributes() public rather than copy and paste regex
 */
abstract class HTML_QuickForm2_Element_SelectTest_AttributeParser extends HTML_Common2
{
    public static function parseAttributes($attrString)
    {
        return parent::parseAttributes($attrString);
    }
}

/**
 * Unit test for HTML_QuickForm2_Element_Select class
 */
class HTML_QuickForm2_Element_SelectTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_POST = array(
            'single1' => '1'
        );
        $_GET = array();
    }

    public function testSelectIsEmptyByDefault()
    {
        $sel = new HTML_QuickForm2_Element_Select();
        $this->assertNull($sel->getValue());
        $this->assertRegExp(
            '!^<select[^>]*>\\s*</select>$!',
            $sel->__toString()
        );
    }

    public function testSelectSingleValueIsScalar()
    {
        $sel = new HTML_QuickForm2_Element_Select();
        $sel->addOption('Text', 'Value');
        $this->assertSame($sel, $sel->setValue('Value'));
        $this->assertEquals('Value', $sel->getValue());

        $this->assertSame($sel, $sel->setValue('Nonextistent'));
        $this->assertNull($sel->getValue());

        $sel2 = new HTML_QuickForm2_Element_Select();
        $sel2->addOption('Text', 'Value');
        $sel2->addOption('Other Text', 'Other Value');
        $sel2->addOption('Different Text', 'Different Value');

        $sel2->setValue(array('Different value', 'Value'));
        $this->assertEquals('Value', $sel2->getValue());
    }

    public function testSelectMultipleValueIsArray()
    {
        $sel = new HTML_QuickForm2_Element_Select('mult', array('multiple'));
        $sel->addOption('Text', 'Value');
        $sel->addOption('Other Text', 'Other Value');
        $sel->addOption('Different Text', 'Different Value');

        $this->assertSame($sel, $sel->setValue('Other Value'));
        $this->assertEquals(array('Other Value'), $sel->getValue());

        $this->assertSame($sel, $sel->setValue('Nonexistent'));
        $this->assertNull($sel->getValue());

        $this->assertSame($sel, $sel->setValue(array('Value', 'Different Value', 'Nonexistent')));
        $this->assertEquals(array('Value', 'Different Value'), $sel->getValue());
    }

    public function testDisabledSelectHasNoValue()
    {
        $sel = new HTML_QuickForm2_Element_Select('disableMe', array('disabled'));
        $sel->addOption('Text', 'Value');
        $sel->setValue('Value');

        $this->assertNull($sel->getValue());
    }

    public function testDisabledOptionsDoNotProduceValues()
    {
        $sel = new HTML_QuickForm2_Element_Select();
        $sel->addOption('Disabled Text', 'Disabled Value', array('disabled'));
        $sel->setValue('Disabled Value');

        $this->assertNull($sel->getValue());
    }


    public function testAddOption()
    {
        $sel = new HTML_QuickForm2_Element_Select();
        $sel->addOption('Text', 'Value');
        $this->assertRegExp(
            '!^<select[^>]*>\\s*<option[^>]+value="Value"[^>]*>Text</option>\\s*</select>!',
            $sel->__toString()
        );

        $sel2 = new HTML_QuickForm2_Element_Select();
        $sel2->addOption('Text', 'Value', array('class' => 'bar'));
        $this->assertRegExp(
            '!<option[^>]+class="bar"[^>]*>Text</option>!',
            $sel2->__toString()
        );

        $sel3 = new HTML_QuickForm2_Element_Select();
        $sel3->addOption('Text', 'Value', array('selected'));
        $this->assertEquals('Value', $sel3->getValue());
        $this->assertRegExp(
            '!<option[^>]+selected="selected"[^>]*>Text</option>!',
            $sel3->__toString()
        );
    }

    public function testAddOptgroup()
    {
        $sel = new HTML_QuickForm2_Element_Select();
        $optgroup = $sel->addOptgroup('Label');
        $this->assertType('HTML_QuickForm2_Element_Select_Optgroup', $optgroup);
        $this->assertRegExp(
            '!^<select[^>]*>\\s*<optgroup[^>]+label="Label"[^>]*>\\s*</optgroup>\\s*</select>!',
            $sel->__toString()
        );

        $sel2 = new HTML_QuickForm2_Element_Select();
        $optgroup2 = $sel2->addOptgroup('Label', array('class' => 'bar'));
        $this->assertRegExp(
            '!<optgroup[^>]+class="bar"[^>]*>\\s*</optgroup>!',
            $sel2->__toString()
        );
    }

    public function testAddOptionToOptgroup()
    {
        $sel = new HTML_QuickForm2_Element_Select();
        $optgroup = $sel->addOptgroup('Label');
        $optgroup->addOption('Text', 'Value');
        $this->assertRegExp(
            '!^<select[^>]*>\\s*<optgroup[^>]+label="Label"[^>]*>\\s*' .
            '<option[^>]+value="Value"[^>]*>Text</option>\\s*</optgroup>\\s*</select>!',
            $sel->__toString()
        );

        $sel2 = new HTML_QuickForm2_Element_Select();
        $optgroup2 = $sel2->addOptgroup('Label');
        $optgroup2->addOption('Text', 'Value', array('class' => 'bar'));
        $this->assertRegExp(
            '!<optgroup[^>]+label="Label"[^>]*>\\s*<option[^>]+class="bar"[^>]*>Text</option>\\s*</optgroup>!',
            $sel2->__toString()
        );

        $sel3 = new HTML_QuickForm2_Element_Select();
        $optgroup3 = $sel3->addOptgroup('Label');
        $optgroup3->addOption('Text', 'Value', array('selected'));
        $this->assertEquals('Value', $sel3->getValue());
        $this->assertRegExp(
            '!<optgroup[^>]+label="Label"[^>]*>\\s*<option[^>]+selected="selected"[^>]*>Text</option>\\s*</optgroup>!',
            $sel3->__toString()
        );
    }

    public function testLoadOptions()
    {
        $sel = new HTML_QuickForm2_Element_Select('loadOptions', array('multiple'));
        $this->assertSame($sel, $sel->loadOptions(array('one' => 'First', 'two' => 'Second')));
        $sel->setValue(array('one', 'two'));
        $this->assertRegexp(
            '!<option[^>]+value="one"[^>]*>First</option>\\s*<option[^>]+value="two"[^>]*>Second</option>!',
            $sel->__toString()
        );
        $this->assertEquals(array('one', 'two'), $sel->getValue());

        $sel->loadOptions(array('Label' => array('two' => 'Second', 'three' => 'Third')));
        $this->assertRegexp(
            '!<optgroup[^>]+label="Label"[^>]*>\\s*<option[^>]+value="two"[^>]*>Second</option>\\s*' .
            '<option[^>]+value="three"[^>]*>Third</option>\\s*</optgroup>!',
            $sel->__toString()
        );
        $this->assertNotRegexp(
            '!<option[^>]+value="one"[^>]*>First</option>!',
            $sel->__toString()
        );
        $this->assertEquals(array('two'), $sel->getValue());
    }

    public function testSelectMultipleName()
    {
        $sel = new HTML_QuickForm2_Element_Select('foo', array('multiple'));
        $this->assertRegExp('/name="foo\\[\\]"/', $sel->__toString());
    }

    public function testFrozenHtmlGeneration()
    {
        $sel = new HTML_QuickForm2_Element_Select('foo');
        $sel->addOption('Text', 'Value');
        $sel->setValue('Value');
        $sel->toggleFrozen(true);

        $sel->persistentFreeze(false);
        $this->assertNotRegExp('/[<>]/', $sel->__toString());
        $this->assertRegExp('/Text/', $sel->__toString());

        $sel->persistentFreeze(true);
        $this->assertRegExp('/Text/', $sel->__toString());
        $this->assertRegExp('!<input[^>]+type="hidden"[^>]*/>!', $sel->__toString());

        preg_match('!<input([^>]+)/>!', $sel->__toString(), $matches);
        $this->assertEquals(
            array('id' => $sel->getId(), 'name' => 'foo', 'value' => 'Value', 'type' => 'hidden'),
            HTML_QuickForm2_Element_SelectTest_AttributeParser::parseAttributes($matches[1])
        );

        $sel->setValue('Nonexistent');
        $this->assertNotRegExp('/Text/', $sel->__toString());
        $this->assertNotRegExp('/[<>]/', $sel->__toString());
    }

    public function testSelectMultipleFrozenHtmlGeneration()
    {
        $sel = new HTML_QuickForm2_Element_Select('foo', array('multiple'));
        $sel->addOption('FirstText', 'FirstValue');
        $sel->addOption('SecondText', 'SecondValue');
        $sel->setValue(array('FirstValue', 'SecondValue'));
        $sel->toggleFrozen(true);

        $this->assertRegExp('/FirstText.*SecondText/s', $sel->__toString());
        $this->assertRegExp('!<input[^>]+type="hidden"[^>]*/>!', $sel->__toString());

        preg_match_all('!<input([^>]+)/>!', $sel->__toString(), $matches, PREG_SET_ORDER);
        $this->assertEquals(
            array('name' => 'foo[]', 'value' => 'FirstValue', 'type' => 'hidden'),
            HTML_QuickForm2_Element_SelectTest_AttributeParser::parseAttributes($matches[0][1])
        );
        $this->assertEquals(
            array('name' => 'foo[]', 'value' => 'SecondValue', 'type' => 'hidden'),
            HTML_QuickForm2_Element_SelectTest_AttributeParser::parseAttributes($matches[1][1])
        );
    }

    public function testSelectMultipleNoOptionsSelectedOnSubmit()
    {
        $options = array('1' => 'Option 1', '2' => 'Option 2');

        $formPost = new HTML_QuickForm2('multiple', 'post', null, false);
        $single1  = $formPost->appendChild(new HTML_QuickForm2_Element_Select('single1', null, array('options' => $options)));
        $single2  = $formPost->appendChild(new HTML_QuickForm2_Element_Select('single2', null, array('options' => $options)));
        $multiple = $formPost->appendChild(new HTML_QuickForm2_Element_Select('mult', array('multiple'), array('options' => $options)));
        $this->assertEquals('1', $single1->getValue());
        $this->assertNull($single2->getValue());
        $this->assertNull($multiple->getValue());

        $formPost->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'single1' => '2',
            'single2' => '2',
            'mult' => array('1', '2')
        )));
        $this->assertEquals('1', $single1->getValue());
        $this->assertEquals('2', $single2->getValue());
        $this->assertNull($multiple->getValue());

        $formGet   = new HTML_QuickForm2('multiple2', 'get', null, false);
        $multiple2 = $formGet->appendChild(new HTML_QuickForm2_Element_Select('mult2', array('multiple'), array('options' => $options)));
        $this->assertNull($multiple2->getValue());

        $formGet->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'mult2' => array('1', '2')
        )));
        $this->assertEquals(array('1', '2'), $multiple2->getValue());
    }

    public function testBug11138()
    {
        $options = array('2' => 'TwoWithoutZero', '02' => 'TwoWithZero');

        $sel = new HTML_QuickForm2_Element_Select('bug11138');
        $sel->loadOptions($options);
        $sel->setValue('02');

        $selHtml = $sel->__toString();
        $this->assertRegExp(
            '!selected="selected"[^>]*>TwoWithZero!', $selHtml
        );
        $this->assertNotRegExp(
            '!selected="selected"[^>]*>TwoWithoutZero!', $selHtml
        );

        $sel->toggleFrozen(true);
        $selFrozen = $sel->__toString();
        $this->assertContains('TwoWithZero', $selFrozen);
        $this->assertContains('value="02"', $selFrozen);
        $this->assertNotContains('TwoWithoutZero', $selFrozen);
        $this->assertNotContains('value="2"', $selFrozen);
    }

   /**
    * Disable possibleValues checks in getValue()
    *
    * For lazy people who add options to selects on client side and do not
    * want to add the same stuff server-side
    *
    * @link http://pear.php.net/bugs/bug.php?id=13088
    * @link http://pear.php.net/bugs/bug.php?id=16974
    */
    public function testDisableIntrinsicValidation()
    {
        $selectSingle = new HTML_QuickForm2_Element_Select(
            'foo', null, array('intrinsic_validation' => false)
        );
        $selectSingle->setValue('foo');
        $this->assertEquals('foo', $selectSingle->getValue());

        $selectSingle->loadOptions(array('one' => 'First', 'two' => 'Second'));
        $selectSingle->setValue('three');
        $this->assertEquals('three', $selectSingle->getValue());

        $selectMultiple = new HTML_QuickForm2_Element_Select(
            'bar', array('multiple'), array('intrinsic_validation' => false)
        );
        $selectMultiple->loadOptions(array('one' => 'First', 'two' => 'Second'));
        $selectMultiple->setValue(array('two', 'three'));
        $this->assertEquals(array('two', 'three'), $selectMultiple->getValue());
    }
}
?>
