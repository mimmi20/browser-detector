<?PHP
/**
 * example for XML_Parser_Simple
 *
 * $Id: test_simple1.php 11 2010-10-10 19:17:21Z tmu $
 *
 * @author      Stephan Schmidt <schst@php-tools.net>
 * @package     XML_Parser
 * @subpackage  Examples
 */
 
/**
 * require the parser
 */
require_once 'HTML/Common3/parser.php';
 
class myParser extends Common3_Parser
{
    function myParser()
    {
        $this->Common3_Parser();
    }
 
   /**
    * handle the element
    *
    * The element will be handled, once it's closed
    *
    * @access   private
    * @param    string      name of the element
    * @param    array       attributes of the element
    * @param    string      character data of the element
    */
    function handleElement($name, $attribs, $data)
    {
        parent::handleElement($name, $attribs, $data);
    }
}
 
$p =& new myParser();
 
$result = $p->setInputFile('test.html');
$result = $p->parse();

$result = $p->getElements();

var_dump($result);
?>