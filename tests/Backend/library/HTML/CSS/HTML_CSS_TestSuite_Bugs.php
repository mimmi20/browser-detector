<?php
/**
 * Test suite for bugs declared in the HTML_CSS class
 *
 * PHP version 5
 *
 * @category HTML
 * @package  HTML_CSS
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @version  CVS: $Id: HTML_CSS_TestSuite_Bugs.php 102 2011-10-25 21:18:56Z  $
 * @link     http://pear.php.net/package/HTML_CSS
 * @since    File available since Release 1.4.0
 */
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "HTML_CSS_TestSuite_Bugs::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once 'HTML/CSS.php';
require_once 'PEAR.php';
require_once 'Event/Dispatcher.php';

/**
 * Test suite class to test old bugs of HTML_CSS
 *
 * @category HTML
 * @package  HTML_CSS
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @version  Release: 1.5.4
 * @link     http://pear.php.net/package/HTML_CSS
 * @since    File available since Release 1.4.0
 */
class HTML_CSS_TestSuite_Bugs extends PHPUnit_Framework_TestCase
{
    /**
     * A CSS object
     * @var  object
     */
    protected $css;

    /**
     * All default options to configure HTML_CSS behavior
     * @var  array
     */
    protected $default_options;

    /**
     * Instance of Event_Dispatcher for test listener
     * @var object
     */
    protected $dispatcher;

    /**
     * Runs the test methods of this class.
     *
     * @static
     * @return void
     */
    public static function main()
    {
        include_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite('HTML_CSS Bugs Tests');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->dispatcher = Event_Dispatcher::getInstance();

        $tab = '  ';
        $eol = strtolower(substr(PHP_OS, 0, 3)) == 'win' ? "\r\n" : "\n";

        // default options, rewrites only for regression test of bug #10103
        $this->default_options = array('xhtml' => true, 'tab' => $tab,
            'cache' => true, 'oneline' => false, 'charset' => 'iso-8859-1',
            'contentDisposition' => false, 'lineEnd' => $eol,
            'groupsfirst' => true, 'allowduplicates' => false);

        $prefs = array('push_callback'  => array($this, 'handleError'),
                       'error_callback' => array($this, 'handleErrorOutput'));

        $this->css = new HTML_CSS($this->default_options, $prefs);
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
     * Regression test for bug #725
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=725
     *         differs hierarchy elements with difference in spaces between
     * @group  bugs
     */
    public function testBug725()
    {
        $strcss = "  body   td  { /* 3 spaces between body and td */
    margin: 20px;
    padding: 20px;
    border: 0;
    color: #444;
}";
        $e      = $this->css->parseString($strcss);
        $msg    = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertFalse(PEAR::isError($e), $msg);

        $style = 'body td  ';
        $e     = $this->css->setStyle($style, 'margin', '0');
        $msg   = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertFalse(PEAR::isError($e), $msg);

        $gs  = array('body td' =>
                       array('margin' => '0',
                             'padding' => '20px',
                             'border' => '0',
                             'color' => '#444'));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'setStyle should change the "' . $style
            . '" not add an other one');
    }

    /**
     * Regression test for bug #998
     *
     * When parsing in some CSS like:
     *
     * .sec { display: none; }
     * .month:before { content: "-"; }
     * .year:before { content: "-"; }
     * .min:before { content: ":"; }
     * .sec:before { content: ":"; }
     *
     * the resulting array should be:
     *
     * [.sec] => Array ( [display] =>  none )
     * [.month:before] => Array ( [content] =>  "-" )
     * [.year:before] => Array ( [content] =>  "-" )
     * [.min:before] => Array ( [content] =>  ":" )
     * [.sec:before] => Array ( [content] =>  ":" )
     *
     * and not :
     *
     * [.sec] => Array ( [display] =>  none )
     * [.month:before] => Array ( [content] =>  "-" )
     * [.year:before] => Array ( [content] =>  "-" )
     * [.min:before] => Array ( [content] =>  " )
     * [.sec:before] => Array ( [content] =>  " )
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=998
     *         parseString incorrectly reads attribute values with colons in
     * @group  bugs
     */
    public function testBug998()
    {
        $strcss = '
.sec { display: none; }
.month:before { content: "-"; }
.year:before { content: "-"; }
.min:before { content: ":"; }
.sec:before { content: ":"; }
';
        $e      = $this->css->parseString($strcss);
        $msg    = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertFalse(PEAR::isError($e), $msg);

        $gs  = array('.sec' => array('display' => 'none'),
                   '.month:before' => array('content' => '"-"'),
                   '.year:before' => array('content' => '"-"'),
                   '.min:before' => array('content' => '":"'),
                   '.sec:before' => array('content' => '":"'));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def,
            'parseString incorrectly reads attribute values with colons in');
    }

    /**
     * Regression test for bug #1066
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=1066
     *         Values are not trimmed
     * @group  bugs
     */
    public function testBug1066()
    {
        $strcss = '
html {
   display:        block; /* 8 spaces after colon */
}
';
        $e      = $this->css->parseString($strcss);
        $msg    = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertFalse(PEAR::isError($e), $msg);

        $gs  = array('html' => array('display' => 'block'));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'parseString incorrectly reads ' .
            'attribute values with spaces after colon');
    }

    /**
     * Regression test for bug #1072
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=1072
     *         HTML_CSS Not cascading properties
     * @group  bugs
     */
    public function testBug1072()
    {
        $strcss = '
p { font-family: Arial; }
p { font-family: Courier; }
p, td { font-family: Times; }
td p { font-family: Comic; }
';
        $e      = $this->css->parseString($strcss);
        $msg    = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertFalse(PEAR::isError($e), $msg);

        $e   = $this->css->getStyle('p', 'font-family');
        $msg = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertFalse(PEAR::isError($e), $msg);
        $this->assertSame('Times', $e, 'HTML_CSS is not cascading style ' .
            'when a "selector" is part of a group');

        $gs  = array('p' => array('font-family' => 'Courier'),
                   'p, td' => array('font-family' => 'Times'),
                   'td p' => array('font-family' => 'Comic'));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'HTML_CSS is not cascading style ' .
            'when a "selector" is part of a group');
    }

    /**
     * Regression test for bug #1084
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=1084
     *         parseSelectors incorrectly assumes selector structure
     * @group  bugs
     */
    public function testBug1084()
    {
        $sa  = '#heading .shortname';
        $e   = $this->css->parseSelectors($sa);
        $msg = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertFalse(PEAR::isError($e), $msg);
        $this->assertSame($sa, $e,
            'parseSelectors incorrectly assumes selector structure "' . $sa . '"');

        $sb  = '#heading .icon';
        $e   = $this->css->parseSelectors($sb);
        $msg = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertFalse(PEAR::isError($e), $msg);
        $this->assertSame($sb, $e,
            'parseSelectors incorrectly assumes selector structure "' . $sb . '"');

        $sc  = '#heading .icon img';
        $e   = $this->css->parseSelectors($sc);
        $msg = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertFalse(PEAR::isError($e), $msg);
        $this->assertSame($sc, $e,
            'parseSelectors incorrectly assumes selector structure "' . $sc . '"');

        $sd  = 'a#heading.icon:active';
        $e   = $this->css->parseSelectors($sd);
        $msg = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertFalse(PEAR::isError($e), $msg);
        $this->assertSame($sd, $e,
            'parseSelectors incorrectly assumes selector structure "' . $sd . '"');
    }

    /**
     * Regression test for bug #12039
     *
     * Even if it was considered as bogus, this test case prevent from invalid
     * data source.
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=12039
     * @group  bugs
     */
    public function testBug12039()
    {
        $strcss = '
.back2top {
    clear: both;
    height: 11px;
    text-align: right;
}

a.top {
    background: none no-repeat top left;
    text-decoration: none;
    width: {IMG_ICON_BACK_TOP_WIDTH}px;
    height: {IMG_ICON_BACK_TOP_HEIGHT}px;
    display: block;
    float: right;
    overflow: hidden;
    letter-spacing: 1000px;
    text-indent: 11px;
}
';
        $e      = $this->css->parseString($strcss);
        $msg    = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertTrue(PEAR::isError($e), $msg);
        $this->assertContains('valid CSS structure', $msg);
    }

    /**
     * Regression test for bug #3920
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=3920
     *         Inappropriate style rule reordering
     * @group  bugs
     */
    public function testBug3920()
    {
        $this->css->setStyle('#right', 'position', ' absolute');
        $this->css->setStyle('#right', 'right', '0px');
        $this->css->setStyle('#right', 'top', '100px');
        $this->css->setStyle('#right', 'background', '#fff');
        $this->css->setStyle('#right', 'border', '1px solid #000');
        $this->css->setStyle('#right', 'padding', '0px 5px');
        $this->css->setStyle('#right', 'width', '200px');
        $bodyRightGroup = $this->css->createGroup("* body #right");
        $this->css->setGroupStyle($bodyRightGroup, 'width', '189px');
        $this->css->setGroupStyle($bodyRightGroup, 'background-color', 'lightgrey');


        // set global 'allowduplicates' option for IE hack
        $this->css->allowduplicates
            = true;   // PHP5 signature, see __set() for PHP4

        /* IE 5.5 */
        $this->css->setStyle('#header', 'height', '81px');
        $this->css->setStyle('#header', 'border-top', 'solid #000');
        $this->css->setStyle('#header', 'border-right', 'solid #000');
        $this->css->setStyle('#header', 'border-left', 'solid #000');
        $this->css->setStyle('#header', 'voice-family', '"\"}\""');
        $this->css->setStyle('#header', 'voice-family', 'inherit');
        /* IE 6 */
        $this->css->setStyle('#header', 'height', '99px');

        $gs  = array('#right' =>
                   array('position' => ' absolute',
                       'right' => '0px',
                       'top' => '100px',
                       'background' => '#fff',
                       'border' => '1px solid #000',
                       'padding' => '0px 5px',
                       'width' => '200px'),
                   '* body #right' =>
                   array('width' => '189px',
                       'background-color' => 'lightgrey'),
                   '#header' =>
                   array(1 => array('height' => '81px'),
                     2 => array('border-top' => 'solid #000'),
                     3 => array('border-right' => 'solid #000'),
                     4 => array('border-left' => 'solid #000'),
                     5 => array('voice-family' => '"\\"}\\""'),
                     6 => array('voice-family' => 'inherit'),
                     7 => array('height' => '99px')));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'inappropriate style rule reordering');
    }

    /**
     * Regression test for bug #10103
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=10103
     * @group  bugs
     */
    public function testBug10103()
    {
        foreach ($this->default_options as $opt => $val) {
            $this->assertSame($this->css->__get($opt), $val,
                "option '$opt' sets is invalid");
        }
    }

    /**
     * Regression test for bug #15690
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=15690
     * @group  bugs
     */
    public function testBug15690()
    {
        $this->css->setStyle('p','font-size','12px');
        $e   = $this->css->setSameStyle('body, td, th, li, dt, dd', 'p');
        $msg = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertTrue(PEAR::isError($e), $msg);
    }

    /**
     * Regression test for bug #16354
     *
     * Does not parse multiple simple At-rules properly
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=16354
     * @group  bugs
     */
    public function testBug16354()
    {
        $str = "
@import \"foo.css\";
@import \"bar.css\";
";
        $this->dispatcher->post($this, 'startTest', $str);
        $this->css->parseString($str, true);
        $this->dispatcher->post($this, 'endTest', $this->css->toArray());

        $exp = array(
            '@import' => array(
                '1' => array(
                    '"foo.css"' => '',
                ),
                '2' => array(
                    '"bar.css"' => '',
                ),
            ),
        );
        $this->assertSame($exp, $this->css->toArray());
    }

    /**
     * Regression test for bug #16355
     *
     * Simple at rules nested within other at rules are reported as top level at rules
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=16355
     * @group  bugs
     */
    public function testBug16355()
    {
        $str = "
@media screen {
  @import \"screen-main.css\";
  body { font-size: 10pt }
}
";
        $this->dispatcher->post($this, 'startTest', $str);
        $e = $this->css->parseString($str);
        $this->dispatcher->post($this, 'endTest', $this->css->toArray());

        $msg = PEAR::isError($e) ? $e->getMessage() : null;
        $this->assertTrue(PEAR::isError($e), $msg);
        $this->assertContains('valid CSS structure', $msg);
    }

    /**
     * Regression test for bug #16357
     *
     * Multiple equal complex at rules not parsed correctly
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=16357
     * @group  bugs
     */
    public function testBug16357()
    {
        $str = "

@media print {
  body { font-size: 10pt }
}

@media screen {
  body { font-size: 10pt;
         font-weight: bold }
}
@media screen {
  body { font-size: 12pt }
}
    ";
        $this->dispatcher->post($this, 'startTest', $str);
        $this->css->parseString($str, true);
        $this->dispatcher->post($this, 'endTest', $this->css->toArray());

        $exp = array (
          '@media' =>
          array (
            'print' =>
            array (
              'body' =>
              array (
                'font-size' => '10pt',
              ),
            ),
            'screen' =>
            array (
              'body' =>
              array (
                'font-size' => '12pt',
                'font-weight' => 'bold',
              ),
            ),
          ),
        );
        $this->assertSame($exp, $this->css->toArray());
    }

    /**
     * Regression test for bug #16358
     *
     * Multiple media types on media at rule not parsed correctly
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=16358
     * @group  bugs
     */
    public function testBug16358()
    {
        $str = "

@media screen, tv, presentation {
  body { font-size: 12pt }
}
    ";
        $this->dispatcher->post($this, 'startTest', $str);
        $this->css->parseString($str, true);
        $this->dispatcher->post($this, 'endTest', $this->css->toArray());

        $exp = array(
            '@media' => array(
                'screen, tv, presentation' => array(
                    'body' => array(
                        'font-size' => '12pt',
                    ),
                ),
            ),
        );
        $this->assertSame($exp, $this->css->toArray());
    }

    /**
     * Regression test for bug #16359
     *
     * Multiple selectors on a single rule inside a complex at rule not properly parsed
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=16359
     * @group  bugs
     */
    public function testBug16359()
    {
        $str = "

@media screen {
  body, p { font-size: 12pt }
}
    ";
        $this->dispatcher->post($this, 'startTest', $str);
        $this->css->parseString($str, true);
        $this->dispatcher->post($this, 'endTest', $this->css->toArray());

        $exp = array(
            '@media' => array(
                'screen' =>  array(
                    'body, p' => array(
                        'font-size' => '12pt',
                    ),
                ),
            ),
        );
        $this->assertSame($exp, $this->css->toArray());
    }

    /**
     * Regression test for bug #16360
     *
     * Multiple selectors inside a complex at rule not properly parsed
     *
     * @return void
     * @link   http://pear.php.net/bugs/bug.php?id=16360
     * @group  bugs
     */
    public function testBug16360()
    {
        $str = "

@media screen {
  body{ font-size: 12pt }
  p { font-size: 12pt }
}
    ";
        $this->dispatcher->post($this, 'startTest', $str);
        $this->css->parseString($str, true);
        $this->dispatcher->post($this, 'endTest', $this->css->toArray());

        $exp = array(
            '@media' => array(
                'screen' =>  array(
                    'body' => array(
                        'font-size' => '12pt',
                    ),
                    'p' => array(
                        'font-size' => '12pt',
                    ),
                ),
            ),
        );
        $this->assertSame($exp, $this->css->toArray());
    }
}

// Call HTML_CSS_TestSuite_Bugs::main() if file is executed directly.
if (PHPUnit_MAIN_METHOD == "HTML_CSS_TestSuite_Bugs::main") {
    HTML_CSS_TestSuite_Standard::main();
}
?>