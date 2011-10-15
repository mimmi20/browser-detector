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

/**
 * Array-based data source for HTML_QuickForm2 objects
 */
require_once 'HTML/QuickForm2/DataSource/Array.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Unit test for array-based data source
 */
class HTML_QuickForm2_DataSource_ArrayTest extends PHPUnit_Framework_TestCase
{
   /**
    * data source being tested
    * @var  HTML_QuickForm2_DataSource_Array
    */
    protected $ds;

    public function setUp()
    {
        $this->ds = new HTML_QuickForm2_DataSource_Array(array(
            'foo' => 'some value',
            'bar' => array(
                'key' => 'some other value'
            ),
            'baz' => array(
                'key1' => array(
                    'key2' => 'yet another value'
                )
            ),
            'escape' => array(
                'o\'really' => 'yes',
                'oh\\no' => 'no'
            )
        ));
    }

    public function testReturnsNullForAbsentValue()
    {
        $this->assertNull($this->ds->getValue('something'));
        $this->assertNull($this->ds->getValue('bar[missing]'));
        // http://news.php.net/php.pear.general/30752
        $this->assertNull($this->ds->getValue('foo[key]'));
    }

    public function testGetValue()
    {
        $this->assertEquals('some value', $this->ds->getValue('foo'));
        $this->assertEquals(
            array('key' => 'some other value'),
            $this->ds->getValue('bar')
        );
        $this->assertEquals('some other value', $this->ds->getValue('bar[key]'));
        $this->assertEquals('yet another value', $this->ds->getValue('baz[key1][key2]'));
    }

   /**
    * See PEAR bugs #8414 and #8123
    */
    public function testQuotesAndBackslashesEscaped()
    {
        $this->assertEquals('yes', $this->ds->getValue('escape[o\'really]'));
        $this->assertEquals('no', $this->ds->getValue('escape[oh\\no]'));
    }
}
?>
