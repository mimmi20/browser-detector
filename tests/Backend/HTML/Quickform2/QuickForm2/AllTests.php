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
 * @author     Bertrand Mansion <golgote@mamasam.com>
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @version    SVN: $Id: AllTests.php 309664 2011-03-24 19:46:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'QuickForm2_AllTests::main');
}

require_once dirname(__FILE__) . '/FactoryTest.php';
require_once dirname(__FILE__) . '/NodeTest.php';
require_once dirname(__FILE__) . '/ElementTest.php';
require_once dirname(__FILE__) . '/Element/AllTests.php';
require_once dirname(__FILE__) . '/ContainerTest.php';
require_once dirname(__FILE__) . '/ContainerOverloadTest.php';
require_once dirname(__FILE__) . '/Container/AllTests.php';
require_once dirname(__FILE__) . '/DataSource/AllTests.php';
require_once dirname(__FILE__) . '/RuleTest.php';
require_once dirname(__FILE__) . '/Rule/AllTests.php';
require_once dirname(__FILE__) . '/FilterTest.php';
require_once dirname(__FILE__) . '/RendererTest.php';
require_once dirname(__FILE__) . '/Renderer/AllTests.php';
require_once dirname(__FILE__) . '/ControllerTest.php';
require_once dirname(__FILE__) . '/Controller/AllTests.php';
require_once dirname(__FILE__) . '/JavascriptBuilderTest.php';

class QuickForm2_AllTests
{
    public static function main()
    {
        if (!function_exists('phpunit_autoload')) {
            require_once 'PHPUnit/TextUI/TestRunner.php';
        }
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('HTML_QuickForm2 package - QuickForm2');

        $suite->addTestSuite('HTML_QuickForm2_FactoryTest');
        $suite->addTestSuite('HTML_QuickForm2_NodeTest');
        $suite->addTestSuite('HTML_QuickForm2_ElementTest');
        $suite->addTestSuite('HTML_QuickForm2_ContainerTest');
        $suite->addTestSuite('HTML_QuickForm2_ContainerOverloadTest');
        $suite->addTestSuite('HTML_QuickForm2_RuleTest');
        $suite->addTestSuite('HTML_QuickForm2_FilterTest');
        $suite->addTestSuite('HTML_QuickForm2_RendererTest');
        $suite->addTestSuite('HTML_QuickForm2_ControllerTest');
        $suite->addTestSuite('HTML_QuickForm2_JavascriptBuilderTest');
        $suite->addTest(QuickForm2_Element_AllTests::suite());
        $suite->addTest(QuickForm2_Container_AllTests::suite());
        $suite->addTest(QuickForm2_DataSource_AllTests::suite());
        $suite->addTest(QuickForm2_Rule_AllTests::suite());
        $suite->addTest(QuickForm2_Renderer_AllTests::suite());
        $suite->addTest(QuickForm2_Controller_AllTests::suite());

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'QuickForm2_AllTests::main') {
    QuickForm2_AllTests::main();
}
?>