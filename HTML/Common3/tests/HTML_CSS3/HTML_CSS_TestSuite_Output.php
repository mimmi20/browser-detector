<?php
declare(ENCODING = 'utf-8');
namespace Test;

/**
 * Test suite for the HTML_CSS class
 *
 * PHP version 5
 *
 * @category HTML
 * @package  HTML_CSS3
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @version  CVS: $Id$
 * @link     http://pear.php.net/package/HTML_CSS
 * @since    File available since Release 1.5.2
 */
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "HTML_CSS3_TestSuite_Output::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";
require_once "PHPUnit/Extensions/OutputTestCase.php";

require_once 'HTML/CSS3.php';
//require_once 'PEAR.php';

/**
 * Test suite class to test standard HTML_CSS API.
 *
 * @category HTML
 * @package  HTML_CSS3
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @version  Release: 1.5.3
 * @link     http://pear.php.net/package/HTML_CSS
 * @since    File available since Release 1.5.2
 */
class HTML_CSS3_TestSuite_Output extends \PHPUnit_Extensions_OutputTestCase
{
    /**
     * A CSS object
     * @var  object
     */
    protected $css;

    /**
     * Runs the test methods of this class.
     *
     * @static
     * @return void
     */
    public static function main()
    {
        include_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new \PHPUnit_Framework_TestSuite('HTML_CSS3 Output Tests');
        $result = \PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $attrs = array();
        $prefs = array('push_callback'  => array($this, 'handleError'),
                       'error_callback' => array($this, 'handleErrorOutput'));

        $this->css = new \HTML\CSS3($attrs, $prefs);

        $this->setOutputCallback(array(&$this, 'normalizeOutput'));
    }

    /**
     * Tears down the fixture.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown()
    {
        unset($this->css);
    }

    /**
     * Don't die if the error is an exception (as default callback)
     *
     * @param int    $code  a numeric error code.
     *                      Valid are HTML_CSS_ERROR_* constants
     * @param string $level error level ('exception', 'error', 'warning', ...)
     *
     * @return int PEAR_ERROR_CALLBACK
     */
    public function handleError($code, $level)
    {
        return PEAR_ERROR_CALLBACK;
    }

    /**
     * Do nothing (no display, no log) when an error is raised
     *
     * @param object $css_error instance of HTML_CSS_Error
     *
     * @return void
     */
    public function handleErrorOutput($css_error)
    {
    }

    /**
     * Tests output result directly to browser
     *
     * @return void
     * @group  output
     */
    public function testSendResultDirectlyToBrowser()
    {
        $this->css->setStyle('body', 'background-color', '#0c0c0c');
        $this->css->setStyle('body', 'color', '#ffffff');

        $this->css->setStyle('h1', 'text-align', 'center');
        $this->css->setStyle('h1', 'font', '16pt helvetica, arial, sans-serif');

        $this->css->setStyle('p', 'font', '12pt helvetica, arial, sans-serif');

        $this->css->setSameStyle('body', 'p');

        $styles = '
p, body {
  font: 12pt helvetica, arial, sans-serif;
}

body {
  background-color: #0c0c0c;
  color: #ffffff;
}

h1 {
  text-align: center;
  font: 16pt helvetica, arial, sans-serif;
}
';
        $styles = $this->normalizeOutput($styles);
        $this->expectOutputString($styles);
        $this->css->display();

    }
}

// Call HTML_CSS_TestSuite_Output::main() if file is executed directly.
if (PHPUnit_MAIN_METHOD == "HTML_CSS3_TestSuite_Output::main") {
    HTML_CSS3_TestSuite_Output::main();
}
?>