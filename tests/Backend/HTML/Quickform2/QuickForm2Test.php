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
 * Class representing a HTML form
 */
require_once 'HTML/QuickForm2.php';

/** Helper for PHPUnit includes */
require_once dirname(__FILE__) . '/TestHelper.php';

/**
 * Unit test for HTML_QuickForm2 class
 */
class HTML_QuickForm2Test extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_REQUEST = array(
            '_qf__track' => ''
        );
        $_GET = array(
            'key' => 'value'
        );
        $_POST = array();
    }

    public function testTrackSubmit()
    {
        $form1 = new HTML_QuickForm2('track', 'post');
        $this->assertEquals(1, count($form1->getDataSources()));

        $form2 = new HTML_QuickForm2('track', 'post', null, false);
        $this->assertEquals(0, count($form2->getDataSources()));

        $form3 = new HTML_QuickForm2('track', 'get');
        $this->assertEquals(1, count($form3->getDataSources()));

        $form4 = new HTML_QuickForm2('notrack', 'get');
        $this->assertEquals(0, count($form4->getDataSources()));

        $form2 = new HTML_QuickForm2('notrack', 'get', null, false);
        $this->assertEquals(1, count($form2->getDataSources()));
    }

    public function testConstructorSetsIdAndMethod()
    {
        $form1 = new HTML_QuickForm2(null);
        $this->assertEquals('post', $form1->getAttribute('method'));
        $this->assertNotEquals(0, strlen($form1->getAttribute('id')));

        $form2 = new HTML_QuickForm2('foo', 'get');
        $this->assertEquals('get', $form2->getAttribute('method'));
        $this->assertEquals('foo', $form2->getAttribute('id'));

        $form3 = new HTML_QuickForm2('bar', 'post', array('method' => 'get', 'id' => 'whatever'));
        $this->assertEquals('post', $form3->getAttribute('method'));
        $this->assertEquals('bar', $form3->getAttribute('id'));
    }

    public function testConstructorSetsDefaultAction()
    {
        $form1 = new HTML_QuickForm2('test');
        $this->assertEquals($_SERVER['PHP_SELF'], $form1->getAttribute('action'));

        $form2 = new HTML_QuickForm2('test2', 'post', array('action' => '/foobar.php'));
        $this->assertEquals('/foobar.php', $form2->getAttribute('action'));
    }

    public function testIdAndMethodAreReadonly()
    {
        $form = new HTML_QuickForm2('foo', 'get');

        try {
            $form->removeAttribute('id');
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            try {
                $form->setAttribute('method', 'post');
            } catch (HTML_QuickForm2_InvalidArgumentException $e) {
                try {
                    $form->setId('newId');
                } catch (HTML_QuickForm2_InvalidArgumentException $e) {
                    return;
                }
            }
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }

    public function testCannotAddToContainer()
    {
        $form1 = new HTML_QuickForm2('form1');
        $form2 = new HTML_QuickForm2('form2');

        try {
            $form1->appendChild($form2);
        } catch (HTML_QuickForm2_Exception $e) {
            return;
        }
        $this->fail('Expected HTML_QuickForm2_Exception was not thrown');
    }

    public function testSetDataSources()
    {
        $ds1 = new HTML_QuickForm2_DataSource_Array(array('key' => 'value'));
        $ds2 = new HTML_QuickForm2_DataSource_Array(array('another key' => 'foo'));

        $form = new HTML_QuickForm2('dstest');
        $this->assertEquals(0, count($form->getDataSources()));
        $form->addDataSource($ds2);
        $this->assertEquals(1, count($form->getDataSources()));

        $form->setDataSources(array($ds1, $ds2));
        $this->assertEquals(2, count($form->getDataSources()));

        try {
            $form->setDataSources(array($ds1, 'bogus', $ds2));
        } catch (HTML_QuickForm2_InvalidArgumentException $e) {
            return;
        }
        $this->fail('Expected HTML_QuickForm2_InvalidArgumentException was not thrown');
    }

    public function testValidateChecksWhetherFormIsSubmitted()
    {
        $form1 = new HTML_QuickForm2('notrack', 'post');
        $this->assertFalse($form1->validate());

        $form2 = new HTML_QuickForm2('track', 'post');
        $this->assertTrue($form2->validate());
    }
}
?>
