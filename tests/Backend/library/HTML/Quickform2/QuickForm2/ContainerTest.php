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
 * @version    SVN: $Id: ContainerTest.php 102 2011-10-25 21:18:56Z  $
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
 * Base class for HTML_QuickForm2 rules
 */
require_once 'HTML/QuickForm2/Rule.php';

/**
 * Base class for HTML_QuickForm2 renderers
 */
require_once 'HTML/QuickForm2/Renderer.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(__FILE__)) . '/TestHelper.php';

/**
 * A non-abstract subclass of Element
 *
 * Element class is still abstract, we should "implement" the remaining methods.
 * We need working setValue() / getValue() to test getValue() of Container
 */
class HTML_QuickForm2_ElementImpl2 extends HTML_QuickForm2_Element
{
    protected $value;

    public function getType() { return 'concrete'; }
    public function __toString() { return ''; }

    public function getRawValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}

/**
 * A non-abstract subclass of Container
 *
 * Container class is still abstract, we should "implement" the remaining methods
 * and also make validate() public to be able to test it.
 */
class HTML_QuickForm2_ContainerImpl extends HTML_QuickForm2_Container
{
    public function getType() { return 'concrete'; }
    public function setValue($value) { return ''; }
    public function __toString() { return ''; }

    public function validate() { return parent::validate(); }
}

/**
 * A Rule to check that Container Rules are called after those of contained elements
 *
 * @see https://pear.php.net/bugs/17576
 */
class RuleRequest17576 extends HTML_QuickForm2_Rule
{
    protected function validateOwner()
    {
        foreach ($this->owner as $child) {
            if ($child->getError()) {
                return false;
            }
        }
        return true;
    }
}

/**
 * Unit test for HTML_QuickForm2_Container class
 */
class HTML_QuickForm2_ContainerTest extends PHPUnit_Framework_TestCase
{
    public function testCanSetName()
    {
        $obj = new HTML_QuickForm2_ContainerImpl();
        $this->assertNotNull($obj->getName(), 'Containers should always have \'name\' attribute');

        $obj = new HTML_QuickForm2_ContainerImpl('foo');
        $this->assertEquals('foo', $obj->getName());

        $this->assertSame($obj, $obj->setName('bar'));
        $this->assertEquals('bar', $obj->getName());

        $obj->setAttribute('name', 'baz');
        $this->assertEquals('baz', $obj->getName());

    }


    public function testCanSetId()
    {
        $obj = new HTML_QuickForm2_ContainerImpl(null, array('id' => 'manual'));
        $this->assertEquals('manual', $obj->getId());

        $this->assertSame($obj, $obj->setId('another'));
        $this->assertEquals('another', $obj->getId());

        $obj->setAttribute('id', 'yet-another');
        $this->assertEquals('yet-another', $obj->getId());
    }


    public function testAutogenerateId()
    {
        $obj = new HTML_QuickForm2_ContainerImpl('somename');
        $this->assertNotEquals('', $obj->getId(), 'Should have an auto-generated \'id\' attribute');

        $obj2 = new HTML_QuickForm2_ContainerImpl('somename');
        $this->assertNotEquals($obj2->getId(), $obj->getId(), 'Auto-generated \'id\' attributes should be unique');
    }


    public function testCanNotRemoveNameOrId()
    {
        $obj = new HTML_QuickForm2_ContainerImpl('somename', array(), array('id' => 'someid'));
        try {
            $obj->removeAttribute('name');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertRegExp('/Required attribute(.*)can not be removed/', $e->getMessage());
            try {
                $obj->removeAttribute('id');
            } catch (HTML_QuickForm2_InvalidArgumentException $e) {
                $this->assertRegExp('/Required attribute(.*)can not be removed/', $e->getMessage());
                return;
            }
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }


    public function testAddAndGetElements()
    {
        $e1 = new HTML_QuickForm2_ElementImpl2('e1');
        $e2 = new HTML_QuickForm2_ElementImpl2('e2');
        $c1 = new HTML_QuickForm2_ContainerImpl('c1');
        $c1->appendChild($e1);
        $c1->appendChild($e2);
        $this->assertEquals(2, count($c1), 'Element count is incorrect');
        $this->assertSame($e1, $c1->getElementById($e1->getId()));
        $this->assertSame($e2, $c1->getElementById($e2->getId()));
    }


    public function testNestedAddAndGetElements()
    {
        $e1 = new HTML_QuickForm2_ElementImpl2('a1');
        $e2 = new HTML_QuickForm2_ElementImpl2('a2');
        $c1 = new HTML_QuickForm2_ContainerImpl('b1');
        $c1->appendChild($e1);
        $c1->appendChild($e2);

        $e3 = new HTML_QuickForm2_ElementImpl2('a3');
        $e4 = new HTML_QuickForm2_ElementImpl2('a4');
        $c2 = new HTML_QuickForm2_ContainerImpl('b2');
        $c2->appendChild($e3);
        $c2->appendChild($e4);
        $c2->appendChild($c1);

        $this->assertEquals(3, count($c2), 'Element count is incorrect');
        $this->assertSame($e1, $c2->getElementById($e1->getId()));
        $this->assertSame($e2, $c2->getElementById($e2->getId()));
    }


    public function testCannotSetContainerOnSelf()
    {
        $e1 = new HTML_QuickForm2_ElementImpl2('d1');
        $e2 = new HTML_QuickForm2_ElementImpl2('d2');
        $c1 = new HTML_QuickForm2_ContainerImpl('f1');
        $c1->appendChild($e1);
        $c1->appendChild($e2);
        try {
            $c1->appendChild($c1);
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            $this->assertEquals('Cannot set an element or its child as its own container', $e->getMessage());
            $c2 = new HTML_QuickForm2_ContainerImpl('f2');
            $c2->appendChild($c1);
            try {
                $c1->appendChild($c2);
            } catch (HTML_QuickForm2_InvalidArgumentException $e) {
                $this->assertEquals('Cannot set an element or its child as its own container', $e->getMessage());
                return;
            }
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }


    public function testAddSameElementMoreThanOnce()
    {
        $e1 = new HTML_QuickForm2_ElementImpl2('g1');
        $e2 = new HTML_QuickForm2_ElementImpl2('g2');
        $c1 = new HTML_QuickForm2_ContainerImpl('h1');
        $c1->appendChild($e1);
        $c1->appendChild($e2);
        $c1->appendChild($e1);

        $this->assertEquals(2, count($c1), 'Element count is incorrect');
        $this->assertSame($e1, $c1->getElementById($e1->getId()));
        $this->assertSame($e2, $c1->getElementById($e2->getId()));
    }

    public function testMoveElement()
    {
        $e1 = new HTML_QuickForm2_ElementImpl2('move1');

        $c1 = new HTML_QuickForm2_ContainerImpl('cmove1');
        $c2 = new HTML_QuickForm2_ContainerImpl('cmove2');

        $c1->appendChild($e1);
        $this->assertSame($e1, $c1->getElementById($e1->getId()));
        $this->assertNull($c2->getElementById($e1->getId()), 'Element should not be found in container');

        $c2->appendChild($e1);
        $this->assertNull($c1->getElementById($e1->getId()), 'Element should be removed from container');
        $this->assertSame($e1, $c2->getElementById($e1->getId()));
    }

    public function testRemoveElement()
    {
        $e1 = new HTML_QuickForm2_ElementImpl2('i1');
        $e2 = new HTML_QuickForm2_ElementImpl2('i2');

        $c1 = new HTML_QuickForm2_ContainerImpl('j1');

        $c1->appendChild($e1);
        $c1->appendChild($e2);

        $removed = $c1->removeChild($e1);
        $this->assertEquals(1, count($c1), 'Element count is incorrect');
        $this->assertNull($c1->getElementById($e1->getId()), 'Element should be removed from container');
        $this->assertSame($e1, $removed, 'removeChild() should return the old child');
    }

    public function testCannotRemoveNonExisting()
    {
        $e1 = new HTML_QuickForm2_ElementImpl2('remove1');
        $e2 = new HTML_QuickForm2_ElementImpl2('remove2');

        $c1 = new HTML_QuickForm2_ContainerImpl('cremove1');
        $c2 = new HTML_QuickForm2_ContainerImpl('cremove2');

        $c1->appendChild($c2);
        $c2->appendChild($e1);

        try {
            $c1->removeChild($e1);
        } catch (HTML_QuickForm2_NotFoundException $e) {
            $this->assertRegExp('/Element(.*)was not found/', $e->getMessage());
            try {
                $c1->removeChild($e2);
            } catch (HTML_QuickForm2_NotFoundException $e) {
                $this->assertRegExp('/Element(.*)was not found/', $e->getMessage());
                return;
            }
        }
        $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
    }

    public function testInsertBefore()
    {
        $e1 = new HTML_QuickForm2_ElementImpl2('k1');
        $e2 = new HTML_QuickForm2_ElementImpl2('k2');
        $e3 = new HTML_QuickForm2_ElementImpl2('k3');
        $e4 = new HTML_QuickForm2_ElementImpl2('k4');

        $c1 = new HTML_QuickForm2_ContainerImpl('l1');
        $c2 = new HTML_QuickForm2_ContainerImpl('l2');

        $c1->appendChild($e1);
        $c1->appendChild($e2);
        $c2->appendChild($e4);

        $e3Insert = $c1->insertBefore($e3, $e1);
        $c1->insertBefore($e4, $e1);
        $c1->insertBefore($e2, $e3);

        $this->assertSame($e3, $e3Insert, 'insertBefore() should return the inserted element');
        $this->assertNull($c2->getElementById($e4->getId()), 'Element should be removed from container');

        $test = array($e2, $e3, $e4, $e1);
        $i = 0;
        foreach ($c1 as $element) {
            $this->assertSame($test[$i++], $element, 'Elements are in the wrong order');
        }
    }

    public function testInsertBeforeNonExistingElement()
    {
        $e1 = new HTML_QuickForm2_ElementImpl2('m1');
        $e2 = new HTML_QuickForm2_ElementImpl2('m2');
        $e3 = new HTML_QuickForm2_ElementImpl2('m3');

        $c1 = new HTML_QuickForm2_ContainerImpl('n1');
        $c1->appendChild($e1);
        $c2 = new HTML_QuickForm2_ContainerImpl('n2');
        $c2->appendChild($c1);
        try {
            $c1->insertBefore($e2, $e3);
        } catch (HTML_QuickForm2_NotFoundException $e) {
            $this->assertEquals("Reference element with name '".$e3->getName()."' was not found", $e->getMessage());
            try {
                $c2->insertBefore($e2, $e1);
            } catch (HTML_QuickForm2_NotFoundException $e) {
                $this->assertEquals("Reference element with name '".$e1->getName()."' was not found", $e->getMessage());
                return;
            }
        }
        $this->fail('Expected HTML_QuickForm2_NotFoundException was not thrown');
    }

    public function testGetElementsByName()
    {
        $e1 = new HTML_QuickForm2_ElementImpl2('foo');
        $e2 = new HTML_QuickForm2_ElementImpl2('bar');
        $e3 = new HTML_QuickForm2_ElementImpl2('foo');
        $e4 = new HTML_QuickForm2_ElementImpl2('baz');
        $e5 = new HTML_QuickForm2_ElementImpl2('foo');

        $c1 = new HTML_QuickForm2_ContainerImpl('fooContainer1');
        $c2 = new HTML_QuickForm2_ContainerImpl('fooContainer2');

        $c1->appendChild($e1);
        $c1->appendChild($e2);
        $c1->appendChild($e3);

        $c2->appendChild($e4);
        $c2->appendChild($e5);
        $c2->appendChild($c1);

        $this->assertEquals(array($e1, $e3), $c1->getElementsByName('foo'));
        $this->assertEquals(array($e5, $e1, $e3), $c2->getElementsByName('foo'));
    }

    public function testDuplicateIdHandling()
    {
        $e1 = new HTML_QuickForm2_ElementImpl2('dup1', array('id' => 'dup'));
        $e2 = new HTML_QuickForm2_ElementImpl2('dup2', array('id' => 'dup'));

        $c1 = new HTML_QuickForm2_ContainerImpl('dupContainer1');
        $c2 = new HTML_QuickForm2_ContainerImpl('dupContainer2');

        $c1->appendChild($e1);
        $c1->appendChild($e2);
        $this->assertEquals(2, count($c1), 'Element count is incorrect');
        $c1->removeChild($e1);
        $this->assertEquals(1, count($c1), 'Element count is incorrect');
        $this->assertSame($e2, $c1->getElementById('dup'));

        $c2->appendChild($e1);
        $c2->appendChild($e2);
        $c2->removeChild($e2);
        $this->assertEquals(1, count($c2), 'Element count is incorrect');
        $this->assertSame($e1, $c2->getElementById('dup'));
    }

    public function testFrozenStatusPropagates()
    {
        $cFreeze = new HTML_QuickForm2_ContainerImpl('cFreeze');
        $elFreeze = $cFreeze->appendChild(new HTML_QuickForm2_ElementImpl2('elFreeze'));

        $cFreeze->toggleFrozen(true);
        $this->assertTrue($cFreeze->toggleFrozen(), 'Container should be frozen');
        $this->assertTrue($elFreeze->toggleFrozen(), 'Contained element should be frozen');

        $cFreeze->toggleFrozen(false);
        $this->assertFalse($cFreeze->toggleFrozen(), 'Container should not be frozen');
        $this->assertFalse($elFreeze->toggleFrozen(), 'Contained element should not be frozen');
    }

    public function testPersistentFreezePropagates()
    {
        $cPers = new HTML_QuickForm2_ContainerImpl('cPersistent');
        $elPers = $cPers->appendChild(new HTML_QuickForm2_ElementImpl2('elPersistent'));

        $cPers->persistentFreeze(true);
        $this->assertTrue($cPers->persistentFreeze(), 'Container should have persistent freeze behaviour');
        $this->assertTrue($elPers->persistentFreeze(), 'Contained element should have persistent freeze behaviour');

        $cPers->persistentFreeze(false);
        $this->assertFalse($cPers->persistentFreeze(), 'Container should not have persistent freeze behaviour');
        $this->assertFalse($elPers->persistentFreeze(), 'Contained element should not have persistent freeze behaviour');
    }

    public function testGetValue()
    {
        $c1 = new HTML_QuickForm2_ContainerImpl('hasValues');
        $this->assertNull($c1->getValue());

        $c2 = $c1->appendChild(new HTML_QuickForm2_ContainerImpl('sub'));
        $this->assertNull($c1->getValue());

        $el1 = $c1->appendChild(new HTML_QuickForm2_ElementImpl2('foo[idx]'));
        $el2 = $c1->appendChild(new HTML_QuickForm2_ElementImpl2('bar'));
        $el3 = $c2->appendChild(new HTML_QuickForm2_ElementImpl2('baz'));
        $this->assertNull($c1->getValue());

        $el1->setValue('a value');
        $el2->setValue('other value');
        $el3->setValue('yet another value');
        $this->assertEquals(array(
            'foo' => array('idx' => 'a value'),
            'bar' => 'other value',
            'baz' => 'yet another value'
        ), $c1->getValue());
    }

    public function testGetRawValue()
    {
        $c = new HTML_QuickForm2_ContainerImpl('filtered');

        $foo = $c->appendChild(new HTML_QuickForm2_ElementImpl2('foo'));
        $bar = $c->appendChild(new HTML_QuickForm2_ElementImpl2('bar'));

        $foo->setValue(' foo value ');
        $bar->setValue(' BAR VALUE ');
        $this->assertEquals(array(
            'foo' => ' foo value ',
            'bar' => ' BAR VALUE '
        ), $c->getRawValue());

        $c->addRecursiveFilter('trim');
        $bar->addFilter('strtolower');
        $this->assertEquals(array(
            'foo' => ' foo value ',
            'bar' => ' BAR VALUE '
        ), $c->getRawValue());

        $c->addFilter('count');
        $this->assertEquals(array(
            'foo' => ' foo value ',
            'bar' => ' BAR VALUE '
        ), $c->getRawValue());
    }

    public function testValidate()
    {
        $cValidate = new HTML_QuickForm2_ContainerImpl('validate');
        $el1 = $cValidate->appendChild(new HTML_QuickForm2_ElementImpl2('foo'));
        $el2 = $cValidate->appendChild(new HTML_QuickForm2_ElementImpl2('bar'));

        $ruleTrue1 = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner'),
            array($cValidate, 'irrelevant message')
        );
        $ruleTrue1->expects($this->once())->method('validateOwner')
                  ->will($this->returnValue(true));
        $ruleFalse = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner'),
            array($el1, 'some error')
        );
        $ruleFalse->expects($this->once())->method('validateOwner')
                  ->will($this->returnValue(false));
        $ruleTrue2 = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner'),
            array($el2, 'irrelevant message')
        );
        $ruleTrue2->expects($this->once())->method('validateOwner')
                  ->will($this->returnValue(true));

        $cValidate->addRule($ruleTrue1);
        $el1->addRule($ruleFalse);
        $el2->addRule($ruleTrue2);
        $this->assertFalse($cValidate->validate());
        $this->assertEquals('', $cValidate->getError());
    }

   /**
    * Container rules should be called after element rules
    *
    * @link http://pear.php.net/bugs/17576
    */
    public function testRequest17576()
    {
        $container = new HTML_QuickForm2_ContainerImpl('last');
        $element   = $container->appendChild(new HTML_QuickForm2_ElementImpl2('foo'));

        $ruleChange = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner'),
            array($element, 'a message')
        );
        $ruleChange->expects($this->exactly(2))->method('validateOwner')
                   ->will($this->onConsecutiveCalls(true, false));
        $element->addRule($ruleChange);

        $container->addRule(new RuleRequest17576(
            $container, 'a contained element is invalid'
        ));

        // first call
        $this->assertTrue($container->validate());
        // second call
        $this->assertFalse($container->validate());
        $this->assertEquals('a contained element is invalid', $container->getError());
    }

   /**
    * Checks that JS for container rules comes after js for rules on contained elements
    */
    public function testRequest17576Client()
    {
        $container = new HTML_QuickForm2_ContainerImpl('aContainer');
        $element   = $container->appendChild(new HTML_QuickForm2_ElementImpl2('anElement'));

        $ruleContainer = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner', 'getJavascriptCallback'),
            array($container)
        );
        $ruleContainer->expects($this->once())->method('getJavascriptCallback')
                      ->will($this->returnValue('containerCallback'));
        $ruleElement = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner', 'getJavascriptCallback'),
            array($element)
        );
        $ruleElement->expects($this->once())->method('getJavascriptCallback')
                    ->will($this->returnValue('elementCallback'));

        $container->addRule($ruleContainer, HTML_QuickForm2_Rule::CLIENT);
        $element->addRule($ruleElement, HTML_QuickForm2_Rule::CLIENT);
        $this->assertRegexp(
            '/elementCallback.*containerCallback/s',
            $container->render(HTML_QuickForm2_Renderer::factory('default'))
                      ->getJavascriptBuilder()->getFormJavascript()
        );
    }

    public function testFrozenContainersHaveNoClientValidation()
    {
        $container = new HTML_QuickForm2_ContainerImpl('aContainer');
        $ruleContainer = $this->getMock(
            'HTML_QuickForm2_Rule', array('validateOwner', 'getJavascriptCallback'),
            array($container)
        );
        $ruleContainer->expects($this->never())->method('getJavascriptCallback');

        $container->addRule($ruleContainer, HTML_QuickForm2_Rule::CLIENT);
        $container->toggleFrozen(true);
        $this->assertEquals(
            '',
            $container->render(HTML_QuickForm2_Renderer::factory('default'))
                      ->getJavascriptBuilder()->getFormJavascript()
        );
    }

    public function testGetValueBrackets()
    {
        $c = new HTML_QuickForm2_ContainerImpl('withBrackets');
        $el1 = $c->appendChild(new HTML_QuickForm2_ElementImpl2('foo[]'));
        $el2 = $c->appendChild(new HTML_QuickForm2_ElementImpl2('foo[]'));

        $el1->setValue('first');
        $el2->setValue('second');
        $this->assertEquals(array('foo' => array('first', 'second')), $c->getValue());
    }
}
?>
