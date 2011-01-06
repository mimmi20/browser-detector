<?php
declare(ENCODING = 'iso-8859-1');
namespace Test;

/**
 * Test suite for HTML_CSS
 *
 * PHP version 5
 *
 * @category HTML
 * @package  HTML_CSS
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @version  CVS: $Id$
 * @link     http://pear.php.net/package/HTML_CSS
 * @since    File available since Release 1.4.0
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'HTML_CSS3_AllTests::main');
}

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

chdir(dirname(__FILE__));

require_once 'HTML_CSS3_TestSuite_Standard.php';
require_once 'HTML_CSS3_TestSuite_Output.php';
require_once 'HTML_CSS3_TestSuite_Bugs.php';

/**
 * Class for running all test suites for HTML_CSS package.
 *
 * @category HTML
 * @package  HTML_CSS3
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @version  Release: 1.5.3
 * @link     http://pear.php.net/package/HTML_CSS
 * @since    File available since Release 1.4.0
 */

class HTML_CSS3_AllTests
{
    /**
     * Runs the test suite.
     *
     * @return void
     * @static
     */
    public static function main()
    {
        \PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    /**
     * Adds the HTML_CSS test suite.
     *
     * @return object the PHPUnit_Framework_TestSuite object
     * @static
     */
    public static function suite()
    {
        $suite = new \PHPUnit_Framework_TestSuite('HTML_CSS3 Test Suite');
        $suite->addTestSuite('HTML_CSS3_TestSuite_Standard');
        $suite->addTestSuite('HTML_CSS3_TestSuite_Output');
        $suite->addTestSuite('HTML_CSS3_TestSuite_Bugs');
        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'HTML_CSS3_AllTests::main') {
    HTML_CSS3_AllTests::main();
}
?>