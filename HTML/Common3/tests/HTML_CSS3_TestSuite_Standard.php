<?php
declare(ENCODING = 'iso-8859-1');
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
 * @version  CVS: $Id: HTML_CSS3_TestSuite_Standard.php 11 2010-10-10 19:17:21Z tmu $
 * @link     http://pear.php.net/package/HTML_CSS
 * @since    File available since Release 1.4.0
 */
if (!defined("PHPUnit2_MAIN_METHOD")) {
    define("PHPUnit2_MAIN_METHOD", "HTML_CSS3_TestSuite_Standard::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

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
 * @since    File available since Release 1.4.0
 */
class HTML_CSS3_TestSuite_Standard extends \PHPUnit_Framework_TestCase
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

        $suite  = new \PHPUnit_Framework_TestSuite('HTML_CSS3 Standard Tests');
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
        $this->css = new \HTML\CSS3($attrs, null);
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
     * tests API throws error
     *
     * @param object $error PEAR_Error instance
     * @param int    $code  error code
     * @param string $level error level (exception or error)
     *
     * @return void
     */
    public function catchError($error, $code, $level)
    {
        $this->assertType(\PHPUnit_Framework_Constraint_IsType::TYPE_OBJECT, $error);
        if ($error instanceof PEAR_Error) {
            $this->assertEquals($error->getCode(), $code);
            $user_info = $error->getUserInfo();
            $this->assertEquals($user_info['level'], $level);
        }
    }

    /**
     * Tests setting options all at once.
     *
     * @return void
     * @group  standard
     */
    public function testSetOptions()
    {
        $tab = '    ';
        $eol = strtolower(substr(PHP_OS, 0, 3)) == 'win' ? "\r\n" : "\n";

        $options = array('xhtml' => true, 'tab' => $tab, 'cache' => true,
            'oneline' => false, 'charset' => 'iso-8859-1',
            'contentDisposition' => false, 'lineEnd' => $eol,
            'groupsfirst' => true, 'allowduplicates' => false);

        foreach ($options as $opt => $val) {
            $this->css->setOption($opt, $val);
            $this->assertSame($this->css->getOption($opt), $val,
                "option '$opt' was not set");
        }
    }

    /**
     * Tests setting the 'xhtml' option.
     *
     * @return void
     * @group  standard
     */
    public function testSetXhtmlCompliance()
    {
        $arg = true;
        try {
            $e   = $this->css->setXhtmlCompliance($arg);
            $msg = null;
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);
        $this->assertSame($this->css->getOption('xhtml'), $arg, $msg);
    }

    /**
     * Tests setting the 'tab' option.
     *
     * @return void
     * @group  standard
     */
    public function testSetTab()
    {
        $arg = "\t";
        $e   = $this->css->setTab($arg);
        $this->assertSame($this->css->getOption('tab'), $arg,
            "'tab' option does not match");
    }

    /**
     * Tests setting the 'cache' option.
     *
     * @return void
     * @group  standard
     */
    public function testSetCache()
    {
        $arg = false;
        try {
            $e   = $this->css->setCache($arg);
            $msg = null;
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);
        $this->assertSame($this->css->getOption('cache'), $arg, $msg);
    }

    /**
     * Tests setting the 'oneline' option.
     *
     * @return void
     * @group  standard
     */
    public function testSetSingleLineOutput()
    {
        $arg = true;
        try {
            $e   = $this->css->setSingleLineOutput($arg);
            $msg = null;
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);
        $this->assertSame($this->css->getOption('oneline'), $arg, $msg);
    }

    /**
     * Tests setting the 'charset' option.
     *
     * @return void
     * @group  standard
     */
    public function testSetCharset()
    {
        $arg = 'UTF-8';
        try {
            $e   = $this->css->setCharset($arg);
            $msg = null;
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);
        $this->assertSame($this->css->getOption('charset'), $arg, $msg);
    }

    /**
     * Tests setting the 'contentDisposition' option.
     *
     * @return void
     * @group  standard
     */
    public function testSetContentDisposition()
    {
        $enable   = true;
        $filename = 'myFile.css';
        try {
            $e   = $this->css->setContentDisposition($enable, $filename);
            $msg = null;
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);
        $this->assertSame($this->css->getOption('contentDisposition'), $filename,
            $msg);
    }

    /**
     * Tests setting the 'lineEnd' option.
     *
     * @return void
     * @group  standard
     */
    public function testSetLineEnd()
    {
        $arg = "\n";
        $e   = $this->css->setLineEnd($arg);
        $this->assertSame($this->css->getOption('lineEnd'), $arg,
            "'lineEnd' option does not match");
    }

    /**
     * Tests setting the 'groupsfirst' option.
     *
     * @return void
     * @group  standard
     */
    public function testSetOutputGroupsFirst()
    {
        $arg = false;
        try {
            $e   = $this->css->setOutputGroupsFirst($arg);
            $msg = null;
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);
        $this->assertSame($this->css->getOption('groupsfirst'), $arg, $msg);
    }

    /**
     * Tests setting the 'allowduplicates' option.
     *
     * @return void
     * @group  standard
     */
    public function testSetAllowDuplicates()
    {
        $arg = true;
        $e   = $this->css->setOption('allowduplicates', $arg);
        $this->assertSame($this->css->getOption('allowduplicates'), $arg,
            "'groupsfirst' option does not match");
    }

    /**
     * Tests handling selector and property values
     *
     * @return void
     * @group  standard
     */
    public function testStyle()
    {
        $element  = 'h2';
        $property = 'color';
        $value    = '#FFFFFF';
        $e        = $this->css->setStyle($element, $property, $value);

        $e   = $this->css->getStyle($element, $property);
        $this->assertSame($value, $e, 'property value does not match');

        $e = $this->css->setSameStyle('.myclass', 'h2');

        $gs  = array('h2, .myclass' => array('color' => $value));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'invalid same style group selector result');
    }

    /**
     * Tests building/removing CSS definition group
     *
     * @return void
     * @group  standard
     */
    public function testGroup()
    {
        $g   = 1;
        $e   = $this->css->createGroup('body, html');
        $this->assertSame($g, $e, 'impossible to create CSS def group');

        $e   = $this->css->unsetGroup($g);
        //$msg = \PEAR::isError($e) ? $e->getMessage() : null;
        //$this->assertFalse(\PEAR::isError($e), $msg);
    }

    /**
     * Tests setting/getting styles for a CSS definition group
     *
     * @return void
     * @group  standard
     */
    public function testGroupStyle()
    {
        $p   = '#ffffff';
        $g   = $this->css->createGroup('body, html');
        $e   = $this->css->setGroupStyle($g, 'color', $p);

        $e   = $this->css->getGroupStyle($g, 'color');
        $this->assertSame($p, $e,
            "color property of group #$g does not match");

        $gs  = array('body, html' => array('color' => $p));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'invalid group selector result');
    }

    /**
     * Tests setting styles duplicated for a CSS definition group
     *
     * @return void
     * @group  standard
     */
    public function testGroupStyleDuplicates()
    {
        $g = $this->css->createGroup('html, #header');
        $r = $this->css->setGroupStyle($g, 'voice-family', '"\"}\""', true);
        $r = $this->css->setGroupStyle($g, 'voice-family', 'inherit', true);

        $gs  = array('html, #header' => array(1 => array('voice-family' => '"\"}\""'),
                                              2 => array('voice-family' => 'inherit'))
                     );
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'invalid group selector result');
    }

    /**
     * Tests add/remove selector to a CSS definition group
     *
     * @return void
     * @group  standard
     */
    public function testGroupSelector()
    {
        $g = $this->css->createGroup('body, html');
        $this->css->setGroupStyle($g, 'margin', '2px');
        $this->css->setGroupStyle($g, 'padding', '0');
        $this->css->setGroupStyle($g, 'border', '0');

        $old_gs  = array('body, html' =>
                       array('margin' => '2px',
                             'padding' => '0',
                             'border' => '0'));
        $cur_def = $this->css->toArray();
        $this->assertSame($old_gs, $cur_def,
            'invalid source group selector result');

        $e   = $this->css->removeGroupSelector($g, 'body');

        $e   = $this->css->addGroupSelector($g, '.large');

        $new_gs  = array('html, .large' =>
                       array('margin' => '2px',
                             'padding' => '0',
                             'border' => '0'));
        $cur_def = $this->css->toArray();
        $this->assertSame($new_gs, $cur_def,
            'invalid target group selector result');
    }

    /**
     * Tests parsing a simple string that contains CSS information.
     *
     * @return void
     * @group  standard
     */
    public function testParseString()
    {
        $strcss = '
html, body {
 margin: 2px;
 padding: 0px;
 border: 0px;
}

p, body {
 margin: 4px;
}
';

        $e   = $this->css->parseString($strcss);

        $gs  = array('html, body' =>
                  array('margin' => '2px',
                        'padding' => '0px',
                        'border' => '0px'),
                    'p, body' =>
                  array('margin' => '4px'));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'string parses does not match');
    }

    /**
     * Tests parsing a simple string that contains invalid CSS information.
     *
     * @return void
     * @group  standard
     */
    public function testParseStringWithInvalidContent()
    {
        $strcss = '
img.thumbs {
 width: {IMG_THUMBS_WIDTH} px;
 height: {IMG_THUMBS_HEIGHT} px;
}
';
        try {
            $e   = $this->css->parseString($strcss);
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        
        $this->assertSame('\HTML\CSS3::parseString() error: Invalid CSS structure (invalid data source) given in parameter $styles', $msg);
    }

    /**
     * Tests parsing a simple string that contains a simple AT Rule
     *
     * @return void
     * @group  standard
     */
    public function testParseStringWithSimpleAtRule()
    {
        $simpleAtRule = '
html { height: 100%; }
@charset "UTF-8";
';
        $this->css->parseString($simpleAtRule);

        $r        = $this->css->toArray();
        $expected = array('@charset' => array('"UTF-8"' => ''),
                          'html' => array('height' => '100%'));
        $this->assertSame($expected, $r);
    }

    /**
     * Tests parsing a simple string that contains a complex AT Rule
     *
     * @return void
     * @group  standard
     */
    public function testParseStringWithComplexAtRule()
    {
        $complexAtRule = '@media screen { color: green; background-color: yellow; }';
        $this->css->parseString($complexAtRule);

        $r        = $this->css->toArray();
        $expected = array('@media' =>
                        array('screen' =>
                            array('' =>
                                array('color' => 'green',
                                      'background-color' => 'yellow'),
                        )));
        $this->assertSame($expected, $r);
    }

    /**
     * Tests parsing a file that contains CSS information.
     *
     * @return void
     * @group  standard
     */
    public function testParseFile()
    {
        // parsing a file contents
        $fn  = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'stylesheet.css';
        $e   = $this->css->parseFile($fn);

        $gs  = array('body' =>
                   array('font' => 'normal 68% verdana,arial,helvetica',
                     'color' => '#000000'),
                   'table tr td, table tr th' =>
                   array('font-size' => '68%'),
                   'table.details tr th' =>
                   array('font-weight' => 'bold',
                     'text-align' => 'left',
                     'background' => '#a6caf0'),
                   'table.details tr' =>
                   array('background' => '#eeeee0'),
                   'p' =>
                   array('line-height' => '1.5em',
                     'margin-top' => '0.5em',
                     'margin-bottom' => '1.0em'),
                   'h1' =>
                   array('margin' => '0px 0px 5px',
                     'font' => '165% verdana,arial,helvetica'),
                   'h2' =>
                   array('margin-top' => '1em',
                     'margin-bottom' => '0.5em',
                     'font' => 'bold 125% verdana,arial,helvetica'),
                   'h3' =>
                   array('margin-bottom' => '0.5em',
                     'font' => 'bold 115% verdana,arial,helvetica'),
                   'h4' =>
                   array('margin-bottom' => '0.5em',
                     'font' => 'bold 100% verdana,arial,helvetica'),
                   'h5' =>
                   array('margin-bottom' => '0.5em',
                     'font' => 'bold 100% verdana,arial,helvetica'),
                   'h6' =>
                   array('margin-bottom' => '0.5em',
                     'font' => 'bold 100% verdana,arial,helvetica'),
                   '.Error' =>
                   array('font-weight' => 'bold',
                     'color' => 'red'),
                   '.Failure, .Unexpected' =>
                   array('background' => '#ff0000',
                     'font-weight' => 'bold',
                     'color' => 'black'),
                   '.Unknown' =>
                   array('background' => '#ffff00',
                     'font-weight' => 'bold',
                     'color' => 'black'),
                   '.Pass, .Expected' =>
                   array('background' => '#00ff00',
                     'font-weight' => 'bold',
                     'color' => 'black'),
                   '.Properties' =>
                   array('text-align' => 'right'),
                   'code.expected' =>
                   array('color' => 'green',
                     'background' => 'none',
                     'font-weight' => 'normal'),
                   'code.actual' =>
                   array('color' => 'red',
                     'background' => 'none',
                     'font-weight' => 'normal'),
                   '.typeinfo' =>
                   array('color' => 'gray'));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'css file parses does not match');
    }

    /**
     * Tests parsing multiple data sources (a simple string and a file),
     * that contains CSS information, at once.
     *
     * @return void
     * @group  standard
     */
    public function testParseData()
    {
        $strcss   = '
body, p { background-color: white; font: 1.2em Arial; }
p, div#black { color: black; }
div{ color: green; }
p { margin-left: 3em; }
';
        $fn       = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'stylesheet.css';
        $css_data = array($fn, $strcss);

        $e   = $this->css->parseData($css_data);

        $gs  = array('body' =>
                   array('font' => 'normal 68% verdana,arial,helvetica',
                     'color' => '#000000'),
                   'table tr td, table tr th' =>
                   array('font-size' => '68%'),
                   'table.details tr th' =>
                   array('font-weight' => 'bold',
                     'text-align' => 'left',
                     'background' => '#a6caf0'),
                   'table.details tr' =>
                   array('background' => '#eeeee0'),
                   'p' =>
                   array('line-height' => '1.5em',
                     'margin-top' => '0.5em',
                     'margin-bottom' => '1.0em',
                     'margin-left' => '3em'),
                   'h1' =>
                   array('margin' => '0px 0px 5px',
                     'font' => '165% verdana,arial,helvetica'),
                   'h2' =>
                   array('margin-top' => '1em',
                     'margin-bottom' => '0.5em',
                     'font' => 'bold 125% verdana,arial,helvetica'),
                   'h3' =>
                   array('margin-bottom' => '0.5em',
                     'font' => 'bold 115% verdana,arial,helvetica'),
                   'h4' =>
                   array('margin-bottom' => '0.5em',
                     'font' => 'bold 100% verdana,arial,helvetica'),
                   'h5' =>
                   array('margin-bottom' => '0.5em',
                     'font' => 'bold 100% verdana,arial,helvetica'),
                   'h6' =>
                   array('margin-bottom' => '0.5em',
                     'font' => 'bold 100% verdana,arial,helvetica'),
                   '.Error' =>
                   array('font-weight' => 'bold',
                     'color' => 'red'),
                   '.Failure, .Unexpected' =>
                   array('background' => '#ff0000',
                     'font-weight' => 'bold',
                     'color' => 'black'),
                   '.Unknown' =>
                   array('background' => '#ffff00',
                     'font-weight' => 'bold',
                     'color' => 'black'),
                   '.Pass, .Expected' =>
                   array('background' => '#00ff00',
                     'font-weight' => 'bold',
                     'color' => 'black'),
                   '.Properties' =>
                   array('text-align' => 'right'),
                   'code.expected' =>
                   array('color' => 'green',
                     'background' => 'none',
                     'font-weight' => 'normal'),
                   'code.actual' =>
                   array('color' => 'red',
                     'background' => 'none',
                     'font-weight' => 'normal'),
                   '.typeinfo' =>
                   array('color' => 'gray'),
                   'body, p' =>
                   array('background-color' => 'white',
                     'font' => '1.2em Arial'),
                   'p, div#black' =>
                   array('color' => 'black'),
                   'div' =>
                   array('color' => 'green'));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'css data sources parses does not match');
    }

    /**
     * Tests data source checking validity with W3C CSS validator service
     *
     * @return void
     * @group  standard
     */
    public function testValidate()
    {
        $strcss   = '
body, p { background-color: white; font: 1.2em Arial; }
p, div#black { color: black; }
div{ color: green; }
p { margin-left: 3em; }
';
        $fn       = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'stylesheet.css';
        $css_data = array($fn, $strcss);
        $messages = array();

        $stub = $this->getMock('HTML_CSS', array('validate'));
        $stub->expects($this->any())
             ->method('validate')
             ->will($this->returnValue(true));

        $e   = $stub->validate($css_data, $messages);
        $this->assertTrue($e, 'CSS data source is invalid');
    }

    /**
     * Tests parsing data source with allow duplicates option activated.
     *
     * Internet Explorer <= 6 does not handle box model in same way as others
     * browsers that are better W3C compliant. For this reason, we need to fix
     * boxes size with a hack such as this one you can find in example that follow.
     * You can notice the duplicate 'voice-family' and 'height' properties.
     *
     * @return void
     * @group  standard
     */
    public function testAllowDuplicates()
    {
        $strcss = '
#header {
  background-color: ivory;
  font-family: "Times New Roman", Times, serif;
  font-size: 5mm;
  text-align: center;
  /* IE 5.5 */
  height:81px;
  border-top:1px solid #000;
  border-right:1px solid #000;
  border-left:1px solid #000;
  voice-family: "\"}\"";
  voice-family: inherit;
  /* IE 6 */
  height: 99px;
}
';
        // set local 'allowduplicates' option
        $e   = $this->css->parseString($strcss, true);

        $gs  = array('#header' =>
                   array(1 => array('background-color' => 'ivory'),
                     2 => array('font-family' => '"Times New Roman", Times, serif'),
                     3 => array('font-size' => '5mm'),
                     4 => array('text-align' => 'center'),
                     5 => array('height' => '81px'),
                     6 => array('border-top' => '1px solid #000'),
                     7 => array('border-right' => '1px solid #000'),
                     8 => array('border-left' => '1px solid #000'),
                     9 => array('voice-family' => '"\\"}\\""'),
                     10 => array('voice-family' => 'inherit'),
                     11 => array('height' => '99px')));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'css source parses does not match');
    }

    /**
     * Tests render to inline html code, array, string or file.
     *
     * @return void
     * @group  standard
     */
    public function testOutput()
    {
        /**
         * Depending of platform (windows, unix, ...) be sure to compare
         * same end of line marker.
         */
        $this->css->setlineEnd(PHP_EOL);

        $strcss  = '{eol}';
        $strcss .= 'ul, body {{eol}';
        $strcss .= ' padding: 1em 2em;{eol}';
        $strcss .= ' color: red;{eol}';
        $strcss .= '}{eol}';
        $strcss  = str_replace('{eol}', $this->css->lineEnd, $strcss);
        $this->css->parseString($strcss);

        // to inline
        $expected = 'padding:1em 2em;color:red;';
        $e        = $this->css->toInline('body');
        $this->assertSame($e, $expected, 'inline output does not match');

        // to array
        $gs  = array('ul, body' =>
                   array('padding' => '1em 2em',
                     'color' => 'red'));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'array output does not match');

        // to string, multi lines
        $this->css->oneline
                   = false;  // PHP5 signature, see __set() for PHP4
        $expNline  = '{eol}';
        $expNline .= 'ul, body {{eol}';
        $expNline .= '{tab}padding: 1em 2em;{eol}';
        $expNline .= '{tab}color: red;{eol}';
        $expNline .= '}{eol}';
        $expNline  = str_replace(array('{tab}','{eol}'),
                         array($this->css->tab, $this->css->lineEnd), $expNline);
        $str       = $this->css->toString();
        $this->assertSame($str, $expNline, 'normal string output does not match');

        // to string, one line
        $this->css->oneline
                  = true;   // PHP5 signature, see __set() for PHP4
        $exp1line = 'ul, body { padding: 1em 2em; color: red; }';
        $str      = $this->css->toString();
        $this->assertSame($str, $exp1line, 'online string output does not match');

        $tmpFile = tempnam(dirname(__FILE__), 'CSS');
        // to file, multi lines
        $this->css->oneline = false;   // PHP5 signature, see __set() for PHP4
        try {
            $e   = $this->css->toFile($tmpFile);
            $msg = null;
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);
        
        $str = file_get_contents($tmpFile);
        $str = str_replace("\r".PHP_EOL, PHP_EOL, $str);
        $this->assertSame($str, $expNline, 'normal file output does not match');

        // to file, one line
        $this->css->oneline = true;    // PHP5 signature, see __set() for PHP4
        try {
            $e   = $this->css->toFile($tmpFile);
            $msg = null;
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);

        $str = file_get_contents($tmpFile);
        $str = str_replace("\r".PHP_EOL, PHP_EOL, $str);
        $this->assertSame($str, $exp1line, 'oneline file output does not match');

        unlink($tmpFile);
    }

    /**
     * Tests searching for selectors and properties
     *
     * @return void
     * @group  standard
     */
    public function testGrepStyle()
    {
        $strcss = '
#PB1 .cellI, #PB1 .cellA {
  width: 10px;
  height: 20px;
  font-family: Courier, Verdana;
  font-size: 8px;
  float: left;
  background-color: transparent;
}

#PB1 .progressBorder {
  width: 122px;
  height: 24px;
  border-width: 1px;
  border-style: solid;
  border-color: navy;
  background-color: #FFFFFF;
}

#PB1 .progressPercentLabel {
  width: 60px;
  text-align: center;
  background-color: transparent;
  font-size: 14px;
  font-family: Verdana, Tahoma, Arial;
  font-weight: normal;
  color: #000000;
}

#PB1 .cellI {
  background-color: #EEEECC;
}

#PB1 .cellA {
  background-color: #3874B4;
}

body {
    background-color: #E0E0E0;
    color: navy;
    font-family: Verdana, Arial;
}
';

        $e   = $this->css->parseString($strcss);

        $gs = array('#PB1 .cellI' =>
                  array('width' => '10px',
                     'height' => '20px',
                     'font-family' => 'Courier, Verdana',
                     'font-size' => '8px',
                     'float' => 'left',
                     'background-color' => '#EEEECC'),
                  '#PB1 .cellA' =>
                  array('width' => '10px',
                     'height' => '20px',
                     'font-family' => 'Courier, Verdana',
                     'font-size' => '8px',
                     'float' => 'left',
                     'background-color' => '#3874B4'),
                  '#PB1 .progressBorder' =>
                  array('width' => '122px',
                     'height' => '24px',
                     'border-width' => '1px',
                     'border-style' => 'solid',
                     'border-color' => 'navy',
                     'background-color' => '#FFFFFF'),
                  '#PB1 .progressPercentLabel' =>
                  array('width' => '60px',
                     'text-align' => 'center',
                     'background-color' => 'transparent',
                     'font-size' => '14px',
                     'font-family' => 'Verdana, Tahoma, Arial',
                     'font-weight' => 'normal',
                     'color' => '#000000'));
        // find all selectors beginning with #PB1
        $style1 = $this->css->grepStyle('/^#PB1/');
        $this->assertSame($gs, $style1, 'search for pattern 1 does not match');

        $gs = array('#PB1 .progressPercentLabel' =>
                  array('width' => '60px',
                      'text-align' => 'center',
                      'background-color' => 'transparent',
                      'font-size' => '14px',
                      'font-family' => 'Verdana, Tahoma, Arial',
                      'font-weight' => 'normal',
                      'color' => '#000000'),
                  'body' =>
                  array('background-color' => '#E0E0E0',
                      'color' => 'navy',
                      'font-family' => 'Verdana, Arial'));
        // find all selectors that set the color property
        $style2 = $this->css->grepStyle('/./', '/^color$/');
        $this->assertSame($gs, $style2, 'search for pattern 2 does not match');
    }

    /**
     * Tests building/removing CSS simple At-Rule
     * "@charset, @import and @namespace"
     *
     * @return void
     * @group  standard
     */
    public function testSimpleAtRule()
    {
        $this->css->setStyle('html', 'height', '100%');

        $e   = $this->css->createAtRule('@charset', '"UTF-8"');

        $e   = $this->css->createAtRule('@import', 'url("foo.css") screen, print');

        $e   = $this->css->createAtRule('@namespace',
                   'foo url("http://www.example.com/")');

        $gs  = array('@charset' =>
                   array('"UTF-8"' => ''),
                    '@import' =>
                   array('url("foo.css") screen, print' => ''),
                    '@namespace' =>
                   array('foo url("http://www.example.com/")' => ''),
                    'html' =>
                   array('height' => '100%'));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'array output does not match');

        $e   = $this->css->unsetAtRule('@CharSet');

        unset($gs['@charset']);
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'array clean does not match');
    }

    /**
     * Tests conditional/informative At-Rules
     * "@media, @page, @font-face"
     *
     * @return void
     * @group  standard
     */
    public function testAtRuleStyle()
    {
        $this->css->setStyle('html', 'height', '100%');

        $e   = $this->css->setAtRuleStyle('@media',
                   'screen', '', 'color', 'green');

        $e   = $this->css->setAtRuleStyle('@media',
                   'screen', '', 'background-color', 'yellow');

        $e   = $this->css->setAtRuleStyle('@media',
                   'print', 'blockquote', 'font-size', '16pt');

        $e   = $this->css->setAtRuleStyle('@page',
                   ':first', '', 'size', '3in 8in');

        $e   = $this->css->setAtRuleStyle('@font-face',
                   '', '', 'font-family', 'dreamy');

        $e   = $this->css->setAtRuleStyle('@font-face',
                   '', '', 'font-weight', 'bold');

        $e   = $this->css->setAtRuleStyle('@font-face',
                   '', '', 'src', 'url(http://www.example.com/font.eot)');

        $gs  = array('@media' => array(
                   'screen' => array(
                     '' => array('color' => 'green',
                                 'background-color' => 'yellow'),
                     ),
                   'print' => array(
                     'blockquote' => array('font-size' => '16pt'),
                     )
                   ),
                   '@page' => array(
                   ':first' => array(
                     '' => array('size' => '3in 8in'),
                     )
                   ),
                   '@font-face' => array(
                   '' => array(
                     '' => array('font-family' => 'dreamy',
                                 'font-weight' => 'bold',
                                 'src' => 'url(http://www.example.com/font.eot)')
                     )
                   ),
                   'html' => array('height' => '100%'));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'array does not match');
    }

    /**
     * Tests parsing CSS string that contains At-Rules
     *
     * @return void
     * @group  standard
     */
    public function testParseAtRuleString()
    {
        $strcss = <<<EOD
@media screen { color: green; background-color: yellow; }
@media    print {
    blockquote { font-size: 16pt; font-weight: bold; }
}
html { height: 100%; }
@page thin:first  { size: 3in 8in }
@font-face {
    font-family: dreamy;
    font-weight: bold;
    src: url(http://www.example.com/font.eot);
}
EOD;

        $e   = $this->css->parseString($strcss);

        $gs  = array('@media' => array(
                   'screen' => array(
                     '' => array('color' => 'green',
                                 'background-color' => 'yellow'),
                     ),
                   'print' => array(
                     'blockquote' => array('font-size' => '16pt',
                                           'font-weight' => 'bold'),
                     )
                   ),
                   '@page' => array(
                   'thin:first' => array(
                     '' => array('size' => '3in 8in'),
                     )
                   ),
                   '@font-face' => array(
                   '' => array(
                     '' => array('font-family' => 'dreamy',
                                 'font-weight' => 'bold',
                                 'src' => 'url(http://www.example.com/font.eot)')
                     )
                   ),
                   'html' => array('height' => '100%'));
        $def = $this->css->toArray();
        $this->assertSame($gs, $def, 'array does not match');
    }

    /**
     * Tests list of supported At-Rules by API 1.5.0
     *
     * @return void
     * @group  standard
     */
    public function testGetAtRulesList()
    {
        $expected = array('@charset', '@font-face',
                          '@import', '@media', '@page', '@namespace');
        $atRules  = $this->css->getAtRulesList();
        sort($atRules);
        sort($expected);
        $this->assertSame($atRules, $expected, 'unexpected At-Rules list');
    }

    /**
     * Tests API version number
     *
     * @return void
     * @group  standard
     */
    public function testApiVersion()
    {
        $expected = '3.0.0';
        if ($expected == '@'.'api_version@') {
            $this->markTestSkipped('Could not be run from CVS repository');
        }
        $actual   = $this->css->apiVersion();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Tests read one or all options
     *
     * @return void
     * @group  standard
     */
    public function testReadOptions()
    {
        $tab = '    ';
        //$eol = strtolower(substr(PHP_OS, 0, 3)) == 'win' ? "\r\n" : "\n";

        $expected = array(
            'charset' => 'iso-8859-1',
            'indent' => $tab,
            'linebreak' => "\n",
            'level' => 0,
            'comment' => null,
            'browser' => null,
            'i18n' => new \I18Nv2_Negotiator('en', 'iso-8859-1'),
            'cache' => false,
            'mime' => 'text/html',
            'oneline' => false,
            'contentdisposition' => false,
            'groupsfirst' => true,
            'allowduplicates' => false,
            'xhtml' => true
        );
        $actual   = $this->css->getOptions();
        // read all default options
        $this->assertEquals($expected, $actual);

        // read an invalid/unknown option
        $actual   = $this->css->getOption('unknown');
        $this->assertEquals(null, $actual);
    }

    /**
     * Tests to parse a string containing selector(s)
     *
     * @return void
     * @group  standard
     */
    public function testParsingSelectors()
    {
        $r = $this->css->parseSelectors('#pb1 blockquote .large', 2);
        $expected = array(array('inheritance' => array(
                                array('element' => '',
                                      'id' => '#pb1', 'class' => '', 'pseudo' => ''),
                                array('element' => 'blockquote',
                                      'id' => '', 'class' => '', 'pseudo' => ''),
                                array('element' => '',
                                      'id' => '', 'class' => '.large', 'pseudo' => '')))
                          );
        $this->assertEquals($expected, $r);
    }

    /**
     * Tests to get value of a valid At rule
     *
     * @return void
     * @group  standard
     */
    public function testGettingValidAtRule()
    {
        $this->css->setAtRuleStyle('@media', 'screen', '', 'background-color', 'yellow');

        $r = $this->css->getAtRuleStyle('@media', 'screen', '', 'background-color');
        $expected = 'yellow';
        $this->assertEquals($expected, $r);
    }

    /**
     * Tests to retrieve undefined At rule
     *
     * @return void
     * @group  standard
     */
    public function testGettingUndefinedAtRule()
    {
        $r = $this->css->getAtRuleStyle('@page', ':first', '', 'size');
        $expected = null;
        $this->assertEquals($expected, $r);
    }

    /**
     * Tests reading the 'cache' option.
     *
     * @return void
     * @group  standard
     */
    public function testReadCacheOption()
    {
        $o = $this->css->getOptions();
        $r = $this->css->getCache();
        $this->assertSame($o['cache'], $r);
    }

    /**
     * Tests reading the 'contentDisposition' option.
     *
     * @return void
     * @group  standard
     */
    public function testReadContentDispositionOption()
    {
        $o = $this->css->getOptions();
        $r = $this->css->getContentDisposition();
        $this->assertSame($o['contentdisposition'], $r);
    }

    /**
     * Tests reading the 'charset' option.
     *
     * @return void
     * @group  standard
     */
    public function testReadCharsetOption()
    {
        $o = $this->css->getOptions();
        $r = $this->css->getCharset();
        $this->assertSame($o['charset'], $r);
    }

    /**
     * Tests to catch exception on invalid parameters, when calling functions
     *
     * @return void
     * @group  standard
     */
    public function testInvalidParametersApiCall()
    {
        // setSingleLineOutput
        try {
            $this->css->setSingleLineOutput('1');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);

        // setOutputGroupsFirst
        try {
            $this->css->setOutputGroupsFirst('1');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);

        // parseSelectors
        try {
            $this->css->parseSelectors(true);
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::parseSelectors() error: string required for parameter $selectors, boolean given', $msg);
        
        try {
            $this->css->parseSelectors('color: green; background-color: yellow;', '4');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::parseSelectors() error: integer required for parameter $outputMode, unicode given', $msg);
        
        try {
            $this->css->parseSelectors('color: green; background-color: yellow;', 4);
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::parseSelectors() error: values 0 | 1 | 2 expected for parameter $outputMode, 4 given', $msg);

        // setXhtmlCompliance
        try {
            $this->css->setXhtmlCompliance('1');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);

        // createAtRule
        try {
            $this->css->createAtRule(true);
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::createAtRule() error: string required for parameter $atKeyword, boolean given', $msg);

        try {
            $this->css->createAtRule('myatrule');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::createAtRule() error: value of (@charset | @import | @namespace) required for parameter $atKeyword, myatrule given', $msg);

        try {
            $this->css->createAtRule('@namespace', true);
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::createAtRule() error: string required for parameter $arguments, boolean given', $msg);

        try {
            $this->css->createAtRule('@charset');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::createAtRule() error: none empty value required for parameter $arguments, \'\' given', $msg);

        // unsetAtRule
        try {
            $this->css->unsetAtRule(true);
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::unsetAtRule() error: string required for parameter $atKeyword, boolean given', $msg);

        try {
            $this->css->unsetAtRule('@myspace');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::unsetAtRule() error: value of (@charset | @font-face | @import | @media | @page | @namespace) required for parameter $atKeyword, @myspace given', $msg);

        try {
            $this->css->unsetAtRule('@charset');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::unsetAtRule() error: unknown @rule for parameter $atKeyword given', $msg);
        
        // setAtRuleStyle
        try {
            $this->css->setAtRuleStyle(1, 'print', 'blockquote', 'font-size', '16pt');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::setAtRuleStyle() error: string required for parameter $atKeyword, integer given', $msg);

        try {
            $this->css->setAtRuleStyle('@namespace', '', '', '', '');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::setAtRuleStyle() error: value of (@media | @page | @font-face) required for parameter $atKeyword, @namespace given', $msg);

        try {
            $this->css->setAtRuleStyle('@media', '', '', '', '');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::setAtRuleStyle() error: not empty value for $atKeyword == @media required for parameter $arguments, \'\' given', $msg);

        try {
            $this->css->setAtRuleStyle('@font-face', '', '', '', '');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::createAtRule() error: none empty value required for parameter $property, \'\' given', $msg);

        try {
            $this->css->setAtRuleStyle('@media', 'print', true, 'font-size', '16pt');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::setAtRuleStyle() error: string required for parameter $selectors, boolean given', $msg);

        try {
            $this->css->setAtRuleStyle('@media', 'print', 'blockquote', 16, '16pt');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::setAtRuleStyle() error: string required for parameter $property, integer given', $msg);

        try {
            $this->css->setAtRuleStyle('@media', 'print', 'blockquote', '', '16pt');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::createAtRule() error: none empty value required for parameter $property, \'\' given', $msg);

        try {
            $this->css->setAtRuleStyle('@media', 'print', 'blockquote', 'font-size', 16);
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::setAtRuleStyle() error: string required for parameter $value, integer given', $msg);

        try {
            $this->css->setAtRuleStyle('@media', 'print', 'blockquote', 'font-size', '');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('\HTML\CSS3::createAtRule() error: none empty value required for parameter $value, \'\' given', $msg);

        // getAtRuleStyle
        $r = $this->css->getAtRuleStyle(1, '', '', '', '');
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->getAtRuleStyle('@myspace', '', '', '', '');
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'error');

        $r = $this->css->getAtRuleStyle('@media', true, 'blockquote', 'font-size');
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->getAtRuleStyle('@media', 'print', true, 'font-size');
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->getAtRuleStyle('@media', 'print', 'blockquote', true);
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // createGroup
        $r = $this->css->createGroup(1);
        $this->assertSame(1, $r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->createGroup('body, html');
        $r = $this->css->createGroup('#main p, #main ul', 1);
        $this->assertSame(1, $r);
        //$this->catchError($r, CSS3_ERROR_INVALID_GROUP, 'error');

        // unsetGroup
        $r = $this->css->unsetGroup(true);
        $this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->unsetGroup(0);
        $this->catchError($r, CSS3_ERROR_NO_GROUP, 'error');

        // setGroupStyle
        $r = $this->css->setGroupStyle(true, null, null);
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->setGroupStyle(1, null, null);
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->setGroupStyle(1, '', null);
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'error');

        $r = $this->css->setGroupStyle(1, 'font-face', null);
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->setGroupStyle(1, 'color', '', '1');
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->setGroupStyle(0, 'background-color', 'yellow');
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_NO_GROUP, 'error');

        // getGroupStyle
        $r = $this->css->getGroupStyle(true, null);
        $this->assertSame(array(), $r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->getGroupStyle(1, null);
        $this->assertSame(array(), $r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->getGroupStyle(0, '');
        $this->assertSame(array(), $r);
        //$this->catchError($r, CSS3_ERROR_NO_GROUP, 'error');

        // addGroupSelector
        $r = $this->css->addGroupSelector(true, null);
        $this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->addGroupSelector(0, null);
        $this->catchError($r, CSS3_ERROR_NO_GROUP, 'error');

        $r = $this->css->addGroupSelector(1, null);
        $this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // removeGroupSelector
        $r = $this->css->removeGroupSelector(true, null);
        $this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->removeGroupSelector(0, null);
        $this->catchError($r, CSS3_ERROR_NO_GROUP, 'error');

        $r = $this->css->removeGroupSelector(1, null);
        $this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // setStyle
        $r = $this->css->setStyle(true, null, null);
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->setStyle('body', null, null);
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->setStyle('html, body', 'background-color', '#0c0c0c');
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'error');

        $r = $this->css->setStyle('body', 'background-color', null);
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->setStyle('body', 'background-color', '#0c0c0c', 1);
        $this->assertSame(1, $r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // getStyle
        $r = $this->css->getStyle(true, null);
        $this->assertSame('', $r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->getStyle('body', null);
        $this->assertSame(array(), $r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->getStyle('input', 'background-color');
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_NO_ELEMENT, 'error');

        $this->css->setStyle('body', 'color', '#fff');
        $r = $this->css->getStyle('body', 'background-color');
        $this->assertSame(array(), $r);
        //$this->catchError($r, CSS3_ERROR_NO_ELEMENT_PROPERTY, 'error');

        // grepStyle
        try {
            $r   = $this->css->grepStyle(1);
            $msg = null;
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);
        $this->assertSame(array(), $r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->grepStyle('/^#PB1/', 1);
        $this->assertSame(array(), $r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // setSameStyle
        $r = $this->css->setSameStyle(null, null);
        $this->assertFalse($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->setSameStyle('body', 1);
        $this->assertTrue($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->setSameStyle('body', 'p');
        $this->assertFalse($r);
        //$this->catchError($r, CSS3_ERROR_NO_ELEMENT, 'error');

        // setCache
        $r = $this->css->setCache(1);
        $this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // setContentDisposition
        $r = $this->css->setContentDisposition(1, null);
        $this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->setContentDisposition(true, null);
        $this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // setCharset
        $r = $this->css->setCharset(8859);
        $this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // parseString
        //$r = $this->css->parseString(intval('iso-8859-1'));
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        //$r = $this->css->parseString("intval('iso-8859-1')", 1);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // parseFile
        try {
            $r   = $this->css->parseFile(1);
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);
        //$this->assertSame('\HTML\CSS3::parseString() error: Invalid CSS structure (invalid data source) given in parameter $styles', $msg);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        try {
            $r   = $this->css->parseFile('none.css');
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertSame('file none.css does not exist', $msg);
        //$this->catchError($r, CSS3_ERROR_NO_FILE, 'error');

        try {
            $r   = $this->css->parseFile('stylesheet.css', 1);
            $msg = null;
        } catch (\HTML\Common3\InvalidArgumentException $e) {
            $msg = $e->getMessage();
        }
        $this->assertNull($msg);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // parseData
        $r = $this->css->parseData('img.thb { width: 80px; }');
        $this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $r = $this->css->parseData(array('img.thb { width: 80px; }'), 1);
        $this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        //$r = $this->css->parseData(array('img.thb { width: 80px; }', true));
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // validate
        $styles   = '';
        $messages = '';
        //$r = $this->css->validate($styles, $messages);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $styles   = array('p, div#black { color: black; }');
        //$r = $this->css->validate($styles, $messages);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        $stub = $this->getMock('HTML_CSS', array('validate'));
        $stub->expects($this->any())
             ->method('validate')
             ->will($this->returnCallback(array(&$this, 'cbMockValidator')));

        $messages = array();
        $styles   = array('php < 5');
        //$r = $stub->validate($styles, $messages);
        //$this->catchError($r, CSS3_ERROR_INVALID_DEPS, 'exception');

        $styles = array('Services_W3C_CSSValidator does not exists');
        //$r      = $stub->validate($styles, $messages);
        //$this->catchError($r, CSS3_ERROR_INVALID_DEPS, 'exception');

        $styles = array('p, div#black { color: black; }', true);
        //$r      = $stub->validate($styles, $messages);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // toInline
        $r = $this->css->toInline(1);
        $this->assertSame(':;', $r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');

        // toFile
        $r = $this->css->toFile(1);
        $this->assertNull($r);
        //$this->catchError($r, CSS3_ERROR_INVALID_INPUT, 'exception');
    }

    /**
     * Stub callback to replace call to the CSS W3C Validator Web Service
     *
     * Simulate PHP version < 5,
     * and class Services_W3C_CSSValidator not available
     *
     * @return mixed
     */
    public function cbMockValidator()
    {
        $args     = func_get_args();
        $styles   = $args[0];
        $messages = $args[1];

        $css1 = 'php < 5';
        $css2 = 'Services_W3C_CSSValidator does not exists';

        foreach ($styles as $i => $source) {
            if (!is_string($source)) {
                return $this->css->raiseError(CSS3_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$styles[' . $i . ']',
                          'was' => gettype($styles[$i]),
                          'expected' => 'string',
                          'paramnum' => 1));
            }
            if ($source == $css1) {
                $php = '4.3.10';
                return $this->css->raiseError(CSS3_ERROR_INVALID_DEPS, 'exception',
                    array('funcname' => __FUNCTION__,
                          'dependency' => 'PHP 5',
                          'currentdep' => "PHP $php"));

            } elseif ($source == $css2) {
                return $this->css->raiseError(CSS3_ERROR_INVALID_DEPS, 'exception',
                    array('funcname' => __FUNCTION__,
                          'dependency' => '\PEAR::Services_W3C_CSSValidator',
                          'currentdep' => 'nothing'));
            }
        }
    }
}

// Call \HTML\CSS3_TestSuite_Standard::main() if file is executed directly.
if (PHPUnit2_MAIN_METHOD == "HTML_CSS3_TestSuite_Standard::main") {
    HTML_CSS3_TestSuite_Standard::main();
}
?>