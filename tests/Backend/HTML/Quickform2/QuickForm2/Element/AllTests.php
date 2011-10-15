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
 * @version    SVN: $Id: AllTests.php 311712 2011-06-01 15:11:36Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'QuickForm2_Element_AllTests::main');
}

require_once dirname(__FILE__) . '/InputTest.php';
require_once dirname(__FILE__) . '/SelectTest.php';
require_once dirname(__FILE__) . '/TextareaTest.php';
require_once dirname(__FILE__) . '/InputCheckableTest.php';
require_once dirname(__FILE__) . '/InputCheckboxTest.php';
require_once dirname(__FILE__) . '/InputPasswordTest.php';
require_once dirname(__FILE__) . '/InputImageTest.php';
require_once dirname(__FILE__) . '/InputHiddenTest.php';
require_once dirname(__FILE__) . '/InputSubmitTest.php';
require_once dirname(__FILE__) . '/InputButtonTest.php';
require_once dirname(__FILE__) . '/InputResetTest.php';
require_once dirname(__FILE__) . '/ButtonTest.php';
require_once dirname(__FILE__) . '/InputFileTest.php';
require_once dirname(__FILE__) . '/StaticTest.php';
require_once dirname(__FILE__) . '/DateTest.php';

class QuickForm2_Element_AllTests
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
        $suite = new PHPUnit_Framework_TestSuite('HTML_QuickForm2 package - QuickForm2 - Element');

        $suite->addTestSuite('HTML_QuickForm2_Element_InputTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_SelectTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_TextareaTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_InputCheckableTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_InputCheckboxTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_InputPasswordTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_InputImageTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_InputHiddenTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_InputSubmitTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_InputButtonTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_InputResetTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_ButtonTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_InputFileTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_StaticTest');
        $suite->addTestSuite('HTML_QuickForm2_Element_DateTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'QuickForm2_Element_AllTests::main') {
    QuickForm2_Element_AllTests::main();
}

?>