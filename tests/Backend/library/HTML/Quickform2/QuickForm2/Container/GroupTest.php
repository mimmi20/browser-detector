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
 * Class for <group> elements
 */
require_once 'HTML/QuickForm2/Container/Group.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Class representing a HTML form
 */
require_once 'HTML/QuickForm2.php';

/**
 * Unit test for HTML_QuickForm2_Element_Group class
 */
class HTML_QuickForm2_Element_GroupTest extends PHPUnit_Framework_TestCase
{
    public function testNoRenameOnEmptyGroupName()
    {
        $g1 = new HTML_QuickForm2_Container_Group();

        $e = $g1->addText('e0');
        $this->assertEquals('e0', $e->getName());

        $e = $g1->addText('e1[e2]');
        $this->assertEquals('e1[e2]', $e->getName());
    }

    public function testGroupRename()
    {
        $g1 = new HTML_QuickForm2_Container_Group('g1[g4]');

        $e1 = $g1->addText('e1');
        $e2 = $g1->addText('e2[x]');
        $this->assertEquals('g1[g4][e1]', $e1->getName());
        $this->assertEquals('g1[g4][e2][x]', $e2->getName());

        $g1->setName('g2');
        $this->assertEquals('g2[e1]', $e1->getName());
        $this->assertEquals('g2[e2][x]', $e2->getName());

        $g1->setName('');
        $this->assertEquals('e1', $e1->getName());
        $this->assertEquals('e2[x]', $e2->getName());
    }

    public function testElementRename()
    {
        $g1 = new HTML_QuickForm2_Container_Group('g1');

        $e = $g1->addText('e0');
        $this->assertEquals('g1[e0]', $e->getName());

        $e = $g1->addText('e1[e2]');
        $this->assertEquals('g1[e1][e2]', $e->getName());

        $e = $g1->addText('e3[]');
        $this->assertEquals('g1[e3][]', $e->getName());

        $e = $g1->addText('[e4]');
        $this->assertEquals('g1[][e4]', $e->getName());

        $e = $g1->addText('');
        $this->assertEquals('g1[]', $e->getName());

        $e = $g1->addText();
        $this->assertEquals('g1[]', $e->getName());

        $e = $g1->addText('[]');
        $this->assertEquals('g1[][]', $e->getName());
    }

    public function testGroupedElementRename()
    {
        $g1 = new HTML_QuickForm2_Container_Group('g1');

        $e0 = $g1->addText('e0');
        $this->assertEquals('g1[e0]', $e0->getName());

        $g2 = new HTML_QuickForm2_Container_Group('g2');

        $e1 = $g2->addText('e1');
        $this->assertEquals('g2[e1]', $e1->getName());

        $g1->addElement($g2);
        $this->assertEquals('g1[g2]', $g2->getName());
        $this->assertEquals('g1[g2][e1]', $e1->getName());

        $g3 = new HTML_QuickForm2_Container_Group('g3');
        $g3->addElement($g1);
        $this->assertEquals('g3[g1]', $g1->getName());
        $this->assertEquals('g3[g1][e0]', $e0->getName());
        $this->assertEquals('g3[g1][g2]', $g2->getName());
        $this->assertEquals('g3[g1][g2][e1]', $e1->getName());

        $e2 = $g1->addText('e2');
        $this->assertEquals('g3[g1][e2]', $e2->getName());

        $e3 = $g1->addText('e3[x]');
        $this->assertEquals('g3[g1][e3][x]', $e3->getName());

        $e4 = $g1->addText('e4[]');
        $this->assertEquals('g3[g1][e4][]', $e4->getName());

        $e5 = $g1->addText('[e5]');
        $this->assertEquals('g3[g1][][e5]', $e5->getName());

        $e6 = $g1->addText('[e6]');
        $this->assertEquals('g3[g1][][e6]', $e6->getName());

        $e7 = $g1->addText('[]');
        $this->assertEquals('g3[g1][][]', $e7->getName());

        $e8 = $g1->addText('');
        $this->assertEquals('g3[g1][]', $e8->getName());

        $g4 = new HTML_QuickForm2_Container_Group('g4');
        $g4->addElement($g3);
        $this->assertEquals('g4[g3]', $g3->getName());
        $this->assertEquals('g4[g3][g1]', $g1->getName());
        $this->assertEquals('g4[g3][g1][e2]', $e2->getName());
        $this->assertEquals('g4[g3][g1][e3][x]', $e3->getName());
        $this->assertEquals('g4[g3][g1][e4][]', $e4->getName());
        $this->assertEquals('g4[g3][g1][][e5]', $e5->getName());
        $this->assertEquals('g4[g3][g1][][e6]', $e6->getName());
        $this->assertEquals('g4[g3][g1][][]', $e7->getName());
        $this->assertEquals('g4[g3][g1][]', $e8->getName());
    }

    public function testPrependGroupNameOnInsertBefore()
    {
        $foo = new HTML_QuickForm2_Container_Group('foo');
        $fooBar = $foo->insertBefore(
            HTML_QuickForm2_Factory::createElement('text', 'bar')
        );
        $this->assertEquals('foo[bar]', $fooBar->getName());

        $fooBaz = $foo->insertBefore(
            HTML_QuickForm2_Factory::createElement('text', 'baz'), $fooBar
        );
        $this->assertEquals('foo[baz]', $fooBaz->getName());
    }

    public function testRemoveGroupNameOnRemoveChild()
    {
        $foo  = new HTML_QuickForm2_Container_Group('foo');
        $bar  = $foo->addElement('group', 'bar');
        $baz  = $bar->addElement('text', 'baz');
        $quux = $bar->addElement('text', 'qu[ux]');
        $xy   = $bar->addElement('group');
        $zzy  = $xy->addElement('text', 'xyzzy');

        $this->assertEquals('foo[bar][baz]', $baz->getName());
        $this->assertEquals('foo[bar][qu][ux]', $quux->getName());
        $this->assertEquals('foo[bar][]', $xy->getName());
        $this->assertEquals('foo[bar][][xyzzy]', $zzy->getName());

        $foo->removeChild($bar);
        $this->assertEquals('bar[baz]', $baz->getName());
        $this->assertEquals('bar[qu][ux]', $quux->getName());
        $this->assertEquals('bar[][xyzzy]', $zzy->getName());

        $bar->removeChild($xy);
        $this->assertEquals('', $xy->getName());
        $this->assertEquals('xyzzy', $zzy->getName());

        $bar->removeChild($baz);
        $this->assertEquals('baz', $baz->getName());

        $bar->removeChild($quux);
        $this->assertEquals('qu[ux]', $quux->getName());
    }

    public function testRenameElementOnChangingGroups()
    {
        $g1 = new HTML_QuickForm2_Container_Group('g1');
        $g2 = new HTML_QuickForm2_Container_Group('g2');

        $e1 = $g1->addElement('text', 'e1');
        $this->assertEquals('g1[e1]', $e1->getName());

        $g2->addElement($e1);
        $this->assertEquals('g2[e1]', $e1->getName());
    }

    public function testSetValue()
    {
        $foo      = new HTML_QuickForm2_Container_Group('foo');
        $fooBar   = $foo->addText('bar');
        $fooBaz   = $foo->addText('ba[z]');
        $fooQuux  = $foo->addGroup('qu')->addText('ux');
        $fooNop   = $foo->addGroup();
        $fooXyzzy = $fooNop->addText('xyzzy');
        $fooYzzyx = $fooNop->addText('yzzyx');

        $foo->setValue(array(
            'bar'   => 'first value',
            'ba'    => array('z' => 'second value'),
            'qu'    => array('ux' => 'third value'),
                       array('xyzzy' => 'fourth value'),
                       array('yzzyx' => 'fifth value')
        ));
        $this->assertEquals('first value', $fooBar->getValue());
        $this->assertEquals('second value', $fooBaz->getValue());
        $this->assertEquals('third value', $fooQuux->getValue());
        $this->assertEquals('fourth value', $fooXyzzy->getValue());
        $this->assertEquals('fifth value', $fooYzzyx->getValue());

        $anon = new HTML_QuickForm2_Container_Group();
        $e1   = $anon->addText('e1');
        $e2   = $anon->addText('e2[i1]');
        $e3   = $anon->addGroup('g1')->addText('e3');
        $g2   = $anon->addGroup();
        $e4   = $g2->addText('e4');
        $e5   = $g2->addText('e5');
        $anon->setValue(array(
            'e1' => 'first value',
            'e2' => array('i1' => 'second value'),
            'g1' => array('e3' => 'third value'),
                    array('e4' => 'fourth value'),
                    array('e5' => 'fifth value')
        ));
        $this->assertEquals('first value', $e1->getValue());
        $this->assertEquals('second value', $e2->getValue());
        $this->assertEquals('third value', $e3->getValue());
        $this->assertEquals('fourth value', $e4->getValue());
        $this->assertEquals('fifth value', $e5->getValue());
    }

    public function testGetValue()
    {
        $value1    = array('foo' => 'foo value');
        $value2    = array('bar' => 'bar value', 'baz' => array('quux' => 'baz value'));
        $valueAnon = array('e1' => 'e1 value');
        $formValue = array('g1' => $value1, 'g2' => array('i2' => $value2)) + $valueAnon;

        $form = new HTML_QuickForm2('testGroupGetValue');
        $form->addDataSource(new HTML_QuickForm2_DataSource_Array($formValue));
        $g1 = $form->addElement('group', 'g1');
        $g1->addElement('text', 'foo');
        $g2 = $form->addElement('group', 'g2[i2]');
        $g2->addElement('text', 'bar');
        $g2->addElement('text', 'baz[quux]');
        $anon = $form->addElement('group');
        $anon->addElement('text', 'e1');

        $this->assertEquals($formValue, $form->getValue());
        $this->assertEquals($value1, $g1->getValue());
        $this->assertEquals($value2, $g2->getValue());
        $this->assertEquals($valueAnon, $anon->getValue());
    }

    public function testGetRawValue()
    {
        $unfiltered = array(
            'foo' => ' foo value ',
            'bar' => ' BAR VALUE '
        );

        $g = new HTML_QuickForm2_Container_Group('filtered');
        $foo = $g->addElement('text', 'foo');
        $bar = $g->addElement('text', 'bar');

        $g->setValue($unfiltered);
        $this->assertEquals($unfiltered, $g->getRawValue());

        $g->addRecursiveFilter('trim');
        $bar->addFilter('strtolower');
        $this->assertEquals($unfiltered, $g->getRawValue());

        $g->addFilter('count');
        $this->assertEquals($unfiltered, $g->getRawValue());
    }

   /**
    * Checks that JS for group rules comes after js for rules on contained elements
    */
    public function testRequest17576Client()
    {
        $group   = new HTML_QuickForm2_Container_Group('aGroup');
        $element = $group->addElement('text', 'anElement');

        $ruleGroup = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner', 'getJavascriptCallback'),
            array($group)
        );
        $ruleGroup->expects($this->once())->method('getJavascriptCallback')
                  ->will($this->returnValue('groupCallback'));
        $ruleElement = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner', 'getJavascriptCallback'),
            array($element)
        );
        $ruleElement->expects($this->once())->method('getJavascriptCallback')
                    ->will($this->returnValue('elementCallback'));

        $group->addRule($ruleGroup, HTML_QuickForm2_Rule::CLIENT);
        $element->addRule($ruleElement, HTML_QuickForm2_Rule::CLIENT);
        $this->assertRegexp(
            '/elementCallback.*groupCallback/s',
            $group->render(HTML_QuickForm2_Renderer::factory('default'))
                  ->getJavascriptBuilder()->getFormJavascript()
        );
    }

    public function testFrozenGroupsHaveNoClientValidation()
    {
        $group = new HTML_QuickForm2_Container_Group('aGroup');
        $ruleGroup = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner', 'getJavascriptCallback'),
            array($group)
        );
        $ruleGroup->expects($this->never())->method('getJavascriptCallback');

        $group->addRule($ruleGroup, HTML_QuickForm2_Rule::CLIENT);
        $group->toggleFrozen(true);
        $this->assertEquals(
            '',
            $group->render(HTML_QuickForm2_Renderer::factory('default'))
                  ->getJavascriptBuilder()->getFormJavascript()
        );
    }

   /**
    * removeElement() could break with a warning if element name contained special regexp characters
    *
    * @link http://pear.php.net/bugs/18182
    */
    public function testBug18182()
    {
        $group = new HTML_QuickForm2_Container_Group('foo[a-b]');
        $el1 = $group->addElement('text', 'bar');
        $this->assertEquals('foo[a-b][bar]', $el1->getName());

        $group->removeChild($el1);
        $this->assertEquals('bar', $el1->getName());

        $group->setName('foo[c/d]');
        $el2 = $group->addElement('text', 'baz');
        $this->assertEquals('foo[c/d][baz]', $el2->getName());

        $group->removeChild($el2);
        $this->assertEquals('baz', $el2->getName());
    }
}
?>
