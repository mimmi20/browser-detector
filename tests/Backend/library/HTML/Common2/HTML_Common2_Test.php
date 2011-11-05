<?php
/**
 * Unit test suite for HTML_Common2 class
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * Copyright (c) 2004-2010, Alexey Borzov <avb@php.net>
 *
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
 * @package    HTML_Common2
 * @author     Alexey Borzov <avb@php.net>
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/HTML_Common2
 */

/**
 * PHPUnit Test Case
 */
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * HTML_Common2 class
 */
require_once 'HTML/Common2.php';

/**
 * A non-abstract subclass of HTML_Common2
 *
 * HTML_Common2 cannot be instantiated due to abstract __toString() method,
 * we need to (sort of) implement that.
 */
class HTML_Common2_Concrete extends HTML_Common2
{
    public function __toString()
    {
        return '';
    }
}

/**
 * A subclass to test the 'watched attributes' functionality of HTML_Common2
 *
 * Two attributes are watched here: 'readonly' and 'uppercase'. The former
 * should not be changed by any of the methods and the value of the latter
 * should always be uppercase. This is achieved by implementing the
 * onAttributeChange() method defined in HTML_Common2
 */
class HTML_Common2_WatchedAttributes extends HTML_Common2_Concrete
{
    protected $watchedAttributes = array('readonly', 'uppercase');

    protected $attributes = array(
        'readonly'  => 'this attribute is readonly',
        'uppercase' => 'VALUE OF THIS IS ALWAYS UPPERCASE'
    );

    protected function onAttributeChange($name, $value = null)
    {
        if ('readonly' == $name) {
            return;
        }
        if ('uppercase' == $name) {
            if (null === $value) {
                unset($this->attributes[$name]);
            } else {
                $this->attributes[$name] = strtoupper($value);
            }
        }
    }
}

/**
 * Unit test for HTML_Common2 class
 */
class HTML_Common2_Test extends PHPUnit_Framework_TestCase
{
    public function testUnknownOptionIsNull()
    {
        $this->assertNull(HTML_Common2::getOption('foobar'));
    }

    public function testAnyOptionAllowed()
    {
        HTML_Common2::setOption('foobar', 'baz');
        $this->assertEquals('baz', HTML_Common2::getOption('foobar'));
    }

    public function testArrayOfOptionsAllowed()
    {
        HTML_Common2::setOption(array(
            'quux' => 'xyzzy'
        ));
        $this->assertEquals('xyzzy', HTML_Common2::getOption('quux'));

        $this->assertArrayHasKey('charset', HTML_Common2::getOption());
    }

    public function testConstructorSetsDefaultAttributes()
    {
        $obj = new HTML_Common2_Concrete();
        $this->assertEquals(array(), $obj->getAttributes());
        $obj = new HTML_Common2_Concrete(array('foo' => 'bar'));
        $this->assertEquals(array('foo' => 'bar'), $obj->getAttributes());
    }

    public function testUnknownAttributeIsNull()
    {
        $obj = new HTML_Common2_Concrete();
        $this->assertNull($obj->getAttribute('foobar'));
    }

    public function testAttributeNamesAreLowercased()
    {
        $obj = new HTML_Common2_Concrete();
        $obj->setAttributes(array('BAZ' => 'quux'));
        $obj->setAttribute('Foo', 'bar');
        $obj->mergeAttributes(array('XyZZy' => 'xyzzy value'));

        $this->assertEquals('bar', $obj->getAttribute('FOO'));

        $obj->removeAttribute('fOO');
        $this->assertEquals(
            array('baz' => 'quux', 'xyzzy' => 'xyzzy value'),
            $obj->getAttributes()
        );
    }

    public function testAttributeValuesAreStrings()
    {
        $obj = new HTML_Common2_Concrete();
        $obj->setAttributes(array('foo' => null, 'bar' => 10));
        $obj->setAttribute('baz', 2.5);
        $obj->mergeAttributes(array('foobar' => 42));
        foreach ($obj->getAttributes() as $attribute) {
            $this->assertInternalType('string', $attribute);
        }
    }

    public function testDefaultIndentLevelIsZero()
    {
        $obj = new HTML_Common2_Concrete();
        $this->assertEquals(0, $obj->getIndentLevel());
    }

    public function testIndentLevelIsNonnegative()
    {
        $obj = new HTML_Common2_Concrete();
        $obj->setIndentLevel(-1);
        $this->assertEquals(0, $obj->getIndentLevel());
        $obj->setIndentLevel(1);
        $this->assertEquals(1, $obj->getIndentLevel());
    }

    public function testDefaultCommentIsNull()
    {
        $obj = new HTML_Common2_Concrete();
        $this->assertNull($obj->getComment());
    }

    public function testAttributesAsStringAccepted()
    {
        $obj = new HTML_Common2_Concrete('multiple  style= "height: 2em;" class=\'foo\' width=100% ');
        $this->assertEquals(
            array('multiple' => 'multiple', 'style' => 'height: 2em;',
                  'class' => 'foo', 'width' => '100%'),
            $obj->getAttributes()
        );
    }

    public function testNonXhtmlAttributesTransformed()
    {
        $obj = new HTML_Common2_Concrete(array('multiple'));
        $obj->setAttribute('selected');
        $obj->mergeAttributes('checked nowrap');
        $this->assertEquals(
            array('multiple' => 'multiple', 'selected' => 'selected',
                  'checked' => 'checked', 'nowrap' => 'nowrap'),
            $obj->getAttributes()
        );
    }

    public function testWellFormedXhtmlGenerated()
    {
        $obj = new HTML_Common2_Concrete(array('foo' => 'bar&"baz"', 'quux' => 'xyz\'zy'));
        $this->assertEquals(
            ' foo="bar&amp;&quot;baz&quot;" quux="xyz&#039;zy"',
            $obj->getAttributes(true)
        );
    }

    public function testCanWatchAttributes()
    {
        $obj = new HTML_Common2_WatchedAttributes();

        $obj->setAttributes(array('readonly' => 'something', 'uppercase' => 'new value', 'foo' => 'bar'));
        $this->assertEquals(
            array('readonly' => 'this attribute is readonly', 'uppercase' => 'NEW VALUE', 'foo' => 'bar'),
            $obj->getAttributes()
        );

        $obj->mergeAttributes(array('readonly' => 'something', 'uppercase' => 'other value', 'foo' => 'baz'));
        $this->assertEquals(
            array('readonly' => 'this attribute is readonly', 'uppercase' => 'OTHER VALUE', 'foo' => 'baz'),
            $obj->getAttributes()
        );

        $obj->setAttribute('readonly', 'something else');
        $obj->setAttribute('uppercase', 'yet another value');
        $obj->setAttribute('foo', 'quux');
        $this->assertEquals(
            array('readonly' => 'this attribute is readonly', 'uppercase' => 'YET ANOTHER VALUE', 'foo' => 'quux'),
            $obj->getAttributes()
        );

        $obj->removeAttribute('readonly');
        $obj->removeAttribute('uppercase');
        $obj->removeAttribute('foo');
        $this->assertEquals(
            array('readonly' => 'this attribute is readonly'),
            $obj->getAttributes()
        );
    }

    public function testFluentInterfaces()
    {
        $obj = new HTML_Common2_Concrete();

        $this->assertSame($obj, $obj->setAttributes(array('foo' => 'foo value')));
        $this->assertSame($obj, $obj->mergeAttributes(array('bar' => 'bar value')));
        $this->assertSame($obj, $obj->setAttribute('baz', 'baz value'));
        $this->assertSame($obj, $obj->removeAttribute('bar'));
        $this->assertSame($obj, $obj->setComment('A comment'));
        $this->assertSame($obj, $obj->setIndentLevel(3));
    }

    public function testCanAddCssClasses()
    {
        $obj = new HTML_Common2_Concrete();

        $obj->addClass('foobar');
        $obj->addClass('foobar');
        $this->assertEquals('foobar', $obj->getAttribute('class'));

        $obj->addClass('quux xyzzy');
        $this->assertFalse($obj->hasClass('bar'));
        $this->assertTrue($obj->hasClass('foobar'));
        $this->assertTrue($obj->hasClass('quux'));
        $this->assertTrue($obj->hasClass('xyzzy'));

        $obj->addClass(array('newclass'));
        $this->assertTrue($obj->hasClass('newclass'));
    }

    public function testCanRemoveCssClasses()
    {
        $obj = new HTML_Common2_Concrete(array('class' => 'foobar quux xyzzy'));

        $obj->removeClass('foobar xyzzy');
        $this->assertFalse($obj->hasClass('xyzzy'));
        $this->assertFalse($obj->hasClass('foobar'));
        $this->assertTrue($obj->hasClass('quux'));

        $obj->removeClass(array('quux'));
        $this->assertEquals(null, $obj->getAttribute('class'));
    }
}
?>
