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
 * @version    SVN: $Id: JumpTest.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/** Helper for PHPUnit includes */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/TestHelper.php';

/** Class implementing the Page Controller pattern for multipage forms */
require_once 'HTML/QuickForm2/Controller.php';

/** Class representing a HTML form */
require_once 'HTML/QuickForm2.php';

/** This handler performs an HTTP redirect to a specific page */
require_once 'HTML/QuickForm2/Controller/Action/Jump.php';

/**
 * Unit test for HTML_QuickForm2_Controller_Action_Jump class
 */
class HTML_QuickForm2_Controller_Action_JumpTest
    extends PHPUnit_Framework_TestCase
{
    protected $mockJump;

    public function setUp()
    {
        $this->mockJump = $this->getMock(
            'HTML_QuickForm2_Controller_Action_Jump', array('doRedirect')
        );
        $this->mockJump->expects($this->atLeastOnce())->method('doRedirect')
             ->will($this->returnArgument(0));

        // see RFC 3986, section 5.4
        $_SERVER['SERVER_NAME'] = 'a';
        $_SERVER['SERVER_PORT'] = 80;
        $_SERVER['REQUEST_URI'] = '/b/c/d;p?q';
    }

   /**
    * Requirement of RFC 2616, section 14.30
    *
    * @link http://pear.php.net/bugs/bug.php?id=13087
    */
    public function testRedirectToAbsoluteUrl()
    {
        // Examples from RFC 3986 section 5.4, except those with fragments
        $rfc3986tests = array(
            ""              =>  "http://a/b/c/d;p?q",
            "g:h"           =>  "g:h",
            "g"             =>  "http://a/b/c/g",
            "./g"           =>  "http://a/b/c/g",
            "g/"            =>  "http://a/b/c/g/",
            "/g"            =>  "http://a/g",
            "//g"           =>  "http://g",
            "?y"            =>  "http://a/b/c/d;p?y",
            "g?y"           =>  "http://a/b/c/g?y",
            ";x"            =>  "http://a/b/c/;x",
            "g;x"           =>  "http://a/b/c/g;x",
            ""              =>  "http://a/b/c/d;p?q",
            "."             =>  "http://a/b/c/",
            "./"            =>  "http://a/b/c/",
            ".."            =>  "http://a/b/",
            "../"           =>  "http://a/b/",
            "../g"          =>  "http://a/b/g",
            "../.."         =>  "http://a/",
            "../../"        =>  "http://a/",
            "../../g"       =>  "http://a/g",
            "../../../g"    =>  "http://a/g",
            "../../../../g" =>  "http://a/g",
            "/./g"          =>  "http://a/g",
            "/../g"         =>  "http://a/g",
            "g."            =>  "http://a/b/c/g.",
            ".g"            =>  "http://a/b/c/.g",
            "g.."           =>  "http://a/b/c/g..",
            "..g"           =>  "http://a/b/c/..g",
            "./../g"        =>  "http://a/b/g",
            "./g/."         =>  "http://a/b/c/g/",
            "g/./h"         =>  "http://a/b/c/g/h",
            "g/../h"        =>  "http://a/b/c/h",
            "g;x=1/./y"     =>  "http://a/b/c/g;x=1/y",
            "g;x=1/../y"    =>  "http://a/b/c/y",
            "g?y/./x"       =>  "http://a/b/c/g?y/./x",
            "g?y/../x"      =>  "http://a/b/c/g?y/../x",
            "http:g"        =>  "http:g",
        );

        $controller = new HTML_QuickForm2_Controller('rfc3986', true);
        $mockPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('relative'))
        );
        $mockPage->addHandler('jump', $this->mockJump);
        $controller->addPage($mockPage);

        foreach ($rfc3986tests as $relative => $absolute) {
            $mockPage->getForm()->setAttribute('action', $relative);
            $this->assertEquals($absolute, preg_replace('/[&?]_qf(.*)$/', '', $mockPage->handle('jump')));
        }
    }

    public function testCannotRedirectPastInvalidPageInWizard()
    {
        $controller = new HTML_QuickForm2_Controller('twopagewizard', true);
        $controller->addPage($this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('first'))
        ));
        $controller->addPage($this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('second'))
        ));
        $controller->addHandler('jump', $this->mockJump);

        $this->assertContains(
            $controller->getPage('first')->getButtonName('display'),
            $controller->getPage('second')->handle('jump')
        );
    }

    public function testPropagateControllerId()
    {
        $noPropPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('noPropagateForm'))
        );
        $noPropController = new HTML_QuickForm2_Controller('foo', true, false);
        $noPropController->addPage($noPropPage);
        $noPropController->addHandler('jump', $this->mockJump);
        $this->assertNotContains(
            HTML_QuickForm2_Controller::KEY_ID . '=',
            $noPropPage->handle('jump')
        );

        $propPage = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('propagateForm'))
        );
        $propController = new HTML_QuickForm2_Controller('bar', true, true);
        $propController->addPage($propPage);
        $propController->addHandler('jump', $this->mockJump);
        $this->assertContains(
            HTML_QuickForm2_Controller::KEY_ID . '=bar',
            $propPage->handle('jump')
        );
    }

   /**
    * Do not add session ID to redirect URL when session.use_only_cookies is set
    *
    * @link http://pear.php.net/bugs/bug.php?id=3443
    */
    public function testBug3443()
    {
        if ('' != session_id()) {
            $this->markTestSkipped('This test cannot be run with session started');
        }

        $old = ini_set('session.use_only_cookies', false);
        define('SID', 'mysessionid=foobar');

        $controller = new HTML_QuickForm2_Controller('testBug3443');
        $controller->addPage($this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('dest'))
        ));
        $controller->addHandler('jump', $this->mockJump);
        $this->assertContains('mysessionid=', $controller->getPage('dest')->handle('jump'));

        ini_set('session.use_only_cookies', true);
        $this->assertNotContains('mysessionid=', $controller->getPage('dest')->handle('jump'));

        ini_set('session.use_only_cookies', $old);
    }

   /**
    * Uppercase 'OFF' in $_SERVER['HTTPS'] could cause a bogus redirect to https:// URL
    *
    * @link http://pear.php.net/bugs/bug.php?id=16328
    */
    public function testBug16328()
    {
        $_SERVER['HTTPS'] = 'OFF';

        $controller = new HTML_QuickForm2_Controller('bug16328');
        $mockPage   = $this->getMock(
            'HTML_QuickForm2_Controller_Page', array('populateForm'),
            array(new HTML_QuickForm2('unsecure'))
        );
        $controller->addPage($mockPage);
        $controller->addHandler('jump', $this->mockJump);
        $mockPage->getForm()->setAttribute('action', '/foo');

        $this->assertNotRegexp('/^https:/i', $mockPage->handle('jump'));
    }
}
?>