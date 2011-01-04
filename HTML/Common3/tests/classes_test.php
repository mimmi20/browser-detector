<?php
declare(ENCODING = 'iso-8859-1');
namespace App;

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL | E_STRICT);
//echo 0;
//include HTML-Class
require_once 'HTML/Common3/Root/Html.php';
//echo 0;
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL | E_STRICT);

//$html = new \HTML\Common3\Root\Html(array('doctype'=>'HTML 4.01 Transitional'));
//$html = new \HTML\Common3\Root\Html(array('doctype'=>'HTML 4.01 Frameset'));
//$html = new \HTML\Common3\Root\Html(array('doctype'=>'HTML 4.01'));
//$html = new \HTML\Common3\Root\Html(array('doctype'=>'HTML 5.0'));
//$html = new \HTML\Common3\Root\Html();// default is 'XHTML 1.0 strict'
//$html = new \HTML\Common3\Root\Html(array('doctype'=>'XHTML 1.0 Transitional'));//$html = new \HTML\Common3\Root\Html(array('doctype'=>'XHTML 1.0 Frameset'));
$html = new \HTML\Common3\Root\Html(array('doctype'=>'XHTML 1.1'));
//$html = new \HTML\Common3\Root\Html(array('doctype'=>'XHTML 2.0'));

//echo 1;

//set the Page Title
$title = $html->addTitle('Test Version 30');
//var_dump($title->getValue());
//var_dump($title->isEnabled());

//echo 2;

//set the Site Language
$html->setLang('de');
$html->setAddingToDtd(false);

//echo 3;

//set the Level for the Site
$html->changeLevel(0);

//echo 4;

//set an ID to the Body
$html->body->setID('top');

//echo 5;
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL | E_STRICT);
//create test-Site
test($html->head);

//echo 6;

test($html->body);

//echo 7;

$form = $html->body->addElement('form');
test($form);

$table = $html->body->addElement('table');test($table);//echo 8;

//create an output file
$txt = $html->toFile('./test.html');

//echo 9;

/*
$txt2 = var_export($html->IDs, TRUE);

$file = fopen('./test.tmp','wb');
fwrite($file, $txt2);
fclose($file);
/**/

//show the output in the browser
//$txt = $html->display();

//echo 10;

echo $html->toHtml(0, false, false, true);
//var_dump($txt);

//echo 11;

//echo $txt;


function test(&$object, $step = 0)
{    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL | E_STRICT);    
    //set limits for recursive site creation
    $step2           = $step + 1;
    $step3           = 3;
    $step4           = 3;
    //set the HTML-Elements which should expanded
    $expand_name     = array('a', 'meta', 'div', 'form', 'table', 'blockquote', 'noscript');
    //get all possible child elements for the actual object
    $posBodyElements = $object->getPosElements();    //var_dump($object->getElementName());
    //var_dump($posBodyElements);
    if (($step2 < $step3) || in_array($object->getElementName(), $expand_name)) {
        foreach ($posBodyElements as $elementName) {
            //var_dump('1xx'.$elementName);
            
            //create child elements            //try{
                $element = $object->addElement($elementName);            //} catch(Exception $e) {            //}            //var_dump('1yy'.$elementName);            if (is_object($element)) {
                //var_dump($element->getElementName());
                if ($elementName == 'if') {
                    $element->setValid(false);
                }
                
                //get all possible attributes for the child element
                $posElementAttribs = $element->getPosAttributes();
                //if ($elementName == 'meta') {
                //var_dump($elementName);
                //var_dump($posElementAttribs);
                //}
                //try{
                    $element->setValue('TEST' . $element->getIndentLevel() . '-' . memory_get_usage(true));
                //} catch(HTML_Common3_Exception $e) {                //    var_dump($e->getMessage());
                //}
                
                if ($step2 < $step4) {
                    //set the attributes to the child element                    
                    foreach ($posElementAttribs as $ElementAttrib) {
                        if (substr($ElementAttrib, 0, 2) != 'on' && $ElementAttrib != 'id') {                            $value = $elementName . '_TEST' . $element->getIndentLevel() . '-' . memory_get_usage(true);                            //if ($elementName == 'meta') {                            //var_dump('$elementName::'.$value);                            //}
                            $element->setAttribute($ElementAttrib, $value);
                        }
                    }
                }
                
                //go to the next level
                if ($step2 < ($step4 + 1)) {
                    test($element, $step2);
                //} elseif (in_array($object->getElementName(), $expand_name) && $step2 < $step4 + 1) {
                    //test($element, $step2);
                }
                
                if ($step2 == 1) {
                    $element = $object->addElement('hr');
                }
            }
        }
    } elseif (isset($posBodyElements[0])) {
        $elementName = $posBodyElements[0];
        //var_dump('2xx'.$elementName);        
        //try{
            $element = $object->addElement($elementName);
        //} catch(Exception $e) {        //    var_dump($e->getMessage());
        //}
        //var_dump('2yy'.$elementName);
        if (is_object($element)) {
            //var_dump($element->getElementName());
            
            if ($elementName == 'if') {
                $element->setValid(false);
            }
            
            //var_dump(3);
            $posElementAttribs = $element->getPosAttributes();
            //if ($elementName == 'meta') {
            //var_dump($elementName);
            //var_dump($posElementAttribs);
            //}
            //try{
                $element->setValue('TEST' . $element->getIndentLevel());
            //} catch(HTML_Common3_Exception $e) {            //    var_dump($e->getMessage());
            //}
            //var_dump(4);
            if ($step2 < $step4) {
                foreach ($posElementAttribs as $ElementAttrib) {
                    if (substr($ElementAttrib, 0, 2) != 'on' && $ElementAttrib != 'id') {
                        $element->setAttribute($ElementAttrib, $elementName . '_TEST' . $element->getIndentLevel() . '-' . memory_get_usage(true));
                    }
                }
            }
            //var_dump(5);
            if ($step2 < ($step4 + 1)) {                //var_dump('7'.$object->getElementName());
                test($element, $step2);
                //var_dump('7'.$object->getElementName());
            //} elseif (in_array($object->getElementName(), $expand_name) && $step2 < $step4 + 1) {
                //test($element, $step2);
            }
            
            if ($step2 == 1) {
                $element = $object->addElement('hr');
            }            //var_dump('6'.$object->getElementName());
        }
    //} else {        //throw new Exception('Fehler');    }    //var_dump('8'.$object->getElementName());
}
?>