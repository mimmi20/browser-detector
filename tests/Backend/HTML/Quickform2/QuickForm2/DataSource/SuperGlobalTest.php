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
 * @version    SVN: $Id: SuperGlobalTest.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Data source for HTML_QuickForm2 objects based on superglobal arrays
 */
require_once 'HTML/QuickForm2/DataSource/SuperGlobal.php';

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(__FILE__))) . '/TestHelper.php';

/**
 * Unit test for superglobal-based data source
 */
class HTML_QuickForm2_DataSource_SuperGlobalTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_GET = array(
            'foo' => 'some value',
            'bar' => 'o\\\'really',
            'baz' => array(
                'key' => 'some other value',
                'unescape' => 'me\\\\please'
            )
        );

        $_POST = array(
            'foo' => 'post value',
            'bar' => 'yes\\\'really',
            'baz' => array(
                'key' => 'yet another value',
                'unescape' => 'or\\\\else'
            )
        );

        $_FILES = array(
            'foo' => array(
                'name'      => 'file.doc',
                'tmp_name'  => '/tmp/nothing',
                'type'      => 'text/plain',
                'size'      => 1234,
                'error'     => UPLOAD_ERR_OK
            ),
            'bar' => array(
                'name'      => array('key' => 'a\\\'thing\\\'.foobar'),
                'tmp_name'  => array('key' => 'C:\\windows\\temp\\whatever'),
                'type'      => array('key' => 'application/foobar'),
                'size'      => array('key' => 4321),
                'error'     => array('key' => UPLOAD_ERR_OK)
            ),
            'baz' => array(
                'name'      => array(
                                'two' => array('three' => 'grimoire.txt'),
                                'escape' => array('o\'really' => '123.jpeg')
                               ),
                'tmp_name'  => array(
                                'two' => array('three' => '/mount/tmp/asdzxc'),
                                'escape' => array('o\'really' => 'C:\\upload\\somefile')
                               ),
                'type'      => array(
                                'two' => array('three' => 'text/unreadable'),
                                'escape' => array('o\'really' => 'image/pr0n')
                               ),
                'size'      => array(
                                'two' => array('three' => 65536),
                                'escape' => array('o\'really' => 5678)
                               ),
                'error'     => array(
                                'two' => array('three' => UPLOAD_ERR_OK),
                                'escape' => array('o\'really' => UPLOAD_ERR_OK)
                               )
            )
        );
    }

    public function testRequestMethodGet()
    {
        $ds1 = new HTML_QuickForm2_DataSource_SuperGlobal('GET', false);
        $this->assertEquals('some value', $ds1->getValue('foo'));
        $this->assertEquals('o\\\'really', $ds1->getValue('bar'));
        $this->assertEquals('me\\\\please', $ds1->getValue('baz[unescape]'));

        $ds2 = new HTML_QuickForm2_DataSource_SuperGlobal('GET', true);
        $this->assertEquals('some value', $ds2->getValue('foo'));
        $this->assertEquals('o\'really', $ds2->getValue('bar'));
        $this->assertEquals('me\\please', $ds2->getValue('baz[unescape]'));
    }

    public function testRequestMethodPost()
    {
        $ds1 = new HTML_QuickForm2_DataSource_SuperGlobal('POST', false);
        $this->assertEquals('post value', $ds1->getValue('foo'));
        $this->assertEquals('yes\\\'really', $ds1->getValue('bar'));
        $this->assertEquals('or\\\\else', $ds1->getValue('baz[unescape]'));

        $ds2 = new HTML_QuickForm2_DataSource_SuperGlobal('POST', true);
        $this->assertEquals('post value', $ds2->getValue('foo'));
        $this->assertEquals('yes\'really', $ds2->getValue('bar'));
        $this->assertEquals('or\\else', $ds2->getValue('baz[unescape]'));
    }

    public function testGetUploadReturnsNullForAbsentValue()
    {
        $ds = new HTML_QuickForm2_DataSource_SuperGlobal('POST');
        $this->assertNull($ds->getUpload('missing'));
        $this->assertNull($ds->getUpload('bar[missing]'));
        $this->assertNull($ds->getUpload('baz[escape][missing]'));
    }

    public function testGetUpload()
    {
        $ds1 = new HTML_QuickForm2_DataSource_SuperGlobal('POST', false);
        $this->assertEquals(array(
            'name'      => 'file.doc',
            'tmp_name'  => '/tmp/nothing',
            'type'      => 'text/plain',
            'size'      => 1234,
            'error'     => UPLOAD_ERR_OK
        ), $ds1->getUpload('foo'));
        $this->assertEquals(array(
            'name'      => 'a\\\'thing\\\'.foobar',
            'tmp_name'  => 'C:\\windows\\temp\\whatever',
            'type'      => 'application/foobar',
            'size'      => 4321,
            'error'     => UPLOAD_ERR_OK
        ), $ds1->getUpload('bar[key]'));
        $this->assertEquals(array(
            'name'      => 'grimoire.txt',
            'tmp_name'  => '/mount/tmp/asdzxc',
            'type'      => 'text/unreadable',
            'size'      => 65536,
            'error'     => UPLOAD_ERR_OK
        ), $ds1->getUpload('baz[two][three]'));

        $ds2 = new HTML_QuickForm2_DataSource_SuperGlobal('POST', true);
        $this->assertEquals(array(
            'name'      => 'a\'thing\'.foobar',
            'tmp_name'  => 'C:\\windows\\temp\\whatever',
            'type'      => 'application/foobar',
            'size'      => 4321,
            'error'     => UPLOAD_ERR_OK
        ), $ds2->getUpload('bar[key]'));
    }

   /**
    * See PEAR bugs #8414 and #8123
    */
    public function testQuotesAndBackslashesEscaped()
    {
        $ds = new HTML_QuickForm2_DataSource_SuperGlobal('POST');
        $this->assertEquals(array(
            'name'      => '123.jpeg',
            'tmp_name'  => 'C:\\upload\\somefile',
            'type'      => 'image/pr0n',
            'size'      => 5678,
            'error'     => UPLOAD_ERR_OK
        ), $ds->getUpload('baz[escape][o\'really]'));
    }
}
?>
