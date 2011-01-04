<?php
/**
 * Test suite for HTML_CSS
 *
 * PHP version 5
 *
 * @category HTML
 * @package  HTML_CSS
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @version  CVS: $Id: AllTests.php 11 2010-10-10 19:17:21Z tmu $
 * @link     http://pear.php.net/package/HTML_CSS
 * @since    File available since Release 1.4.0
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'HTML_CSS_AllTests::main');
}

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

chdir(dirname(__FILE__));

require_once 'HTML_CSS_TestSuite_Standard.php';
require_once 'HTML_CSS_TestSuite_Output.php';
require_once 'HTML_CSS_TestSuite_Bugs.php';

/**
 * Class for running all test suites for HTML_CSS package.
 *
 * @category HTML
 * @package  HTML_CSS
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @version  Release: 1.5.4
 * @link     http://pear.php.net/package/HTML_CSS
 * @since    File available since Release 1.4.0
 */

class HTML_CSS_AllTests
{
    /**
     * Runs the test suite.
     *
     * @return void
     * @static
     */
    public static function main()
    {
        include_once 'PEAR/Config.php';

        $testListener_installed = HTML_CSS_AllTests::packageInstalled(
            'PEAR_TestListener', '0.3.0b2', '__URI'
        );
        // detect at run-time if PEAR_TestListener is installed ...
        if ($testListener_installed) {
            // ... and uses it's benefits
            include_once 'PEAR/TestRunner.php';
            include_once 'TestListener.php';

            $logger   = PEAR_TestRunner::getLogger();
            $listener = new HTML_CSS_TestListener($logger);

            PEAR_TestRunner::run(self::suite(), $listener);
        } else {
            PHPUnit_TextUI_TestRunner::run(self::suite());
        }
    }

    /**
     * Adds the HTML_CSS test suite.
     *
     * @return object the PHPUnit_Framework_TestSuite object
     * @static
     */
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('HTML_CSS Test Suite');
        $suite->addTestSuite('HTML_CSS_TestSuite_Standard');
        $suite->addTestSuite('HTML_CSS_TestSuite_Output');
        $suite->addTestSuite('HTML_CSS_TestSuite_Bugs');
        return $suite;
    }

    /**
     * Check if a package is installed
     *
     * Simple function to check if a package is installed under user
     * or system PEAR installation. Minimal version and channel info are supported.
     *
     * @param string $name        Package name
     * @param string $version     (optional) The minimal version
     *                            that should be installed
     * @param string $channel     (optional) The package channel distribution
     * @param string $user_file   (optional) file to read PEAR user-defined
     *                            options from
     * @param string $system_file (optional) file to read PEAR system-wide
     *                            defaults from
     *
     * @static
     * @return bool
     * @since  version 1.5.4 (2009-07-04)
     * @see    PHP_CompatInfo::packageInstalled()
     */
    public static function packageInstalled($name, $version = null, $channel = null,
        $user_file = '', $system_file = ''
    ) {
        $config = PEAR_Config::singleton($user_file, $system_file);
        $reg    = $config->getRegistry();

        if (is_null($version)) {
            return $reg->packageExists($name, $channel);
        } else {
            $info = &$reg->getPackage($name, $channel);
            if (is_object($info)) {
                $installed['version'] = $info->getVersion();
            } else {
                $installed = $info;
            }
            return version_compare($version, $installed['version'], '<=');
        }
    }
}

if (PHPUnit_MAIN_METHOD == 'HTML_CSS_AllTests::main') {
    HTML_CSS_AllTests::main();
}
?>