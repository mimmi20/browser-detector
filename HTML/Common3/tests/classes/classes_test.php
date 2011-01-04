<?php
ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL | E_STRICT);

//include HTML-Classes
include_once 'HTML/Common3/Root/Html.php';
include_once 'HTML/Table.php';
include_once 'HTML/Common3/Root/Table.php';
define('HTML_JAVASCRIPT_NL', "");
include_once 'HTML/Javascript.php';
include_once 'HTML/Common3/Root/Script.php';
include_once 'HTML/QuickForm.php';
include_once 'HTML/QuickForm2.php';
include_once 'HTML/Common3/Root/Form.php';

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL | E_STRICT);

//$html = new HTML_Common3_Root_Html(array('doctype'=>'XHTML 1.0 Frameset'));

$html = new HTML_Common3_Root_Html(array(
            'doctype'            => 'XHTML 1.1',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd'
));
/**/
//$html = new HTML_Common3_Root_Html(array('doctype'=>'HTML 4.01 Transitional'));
//$html = new HTML_Common3_Root_Html(array('doctype'=>'HTML 4.01'));
//$html = new HTML_Common3_Root_Html();// default is 'XHTML 1.0 strict'
//echo $html->toHtml(0, false, false);
//set the Page Title
$title = $html->addTitle('Test Version 30');

//set the Site Language
$html->setLang('de');
$html->setAddToDtd(false);

//set the Level for the Site
$html->changeLevel(0);

//set an ID to the Body
$html->body->setID('top');

//create test-Site
//test($html->head);
//test($html->body);

//***********************************************************************************
/*
$table1 = new HTML_Table();
$div1   = $html->body->addElement('div');
$t1     = $div1->addElement($table1);
$t1->setAutoFill('-1-');
$t1->setAutoGrow(true);
$t1->setCaption('Tabelle1');
$t1->addRow(array('1a','x1a'), 'style="border:1px solid #00f;color:#f00;"', 'td', true);
$t1->setColCount(7);
$t1->setRowCount(7);
$t1->addBody(array('style'=>'border:1px solid #f00;'));
$t1->addRow(array('1b','x1b'), 'style="border:1px solid #00f;color:#f00;"', 'td', false, 1);
$t1->getHeader()->addRow(array('1z','x1z'), 'style="border:1px solid #00f;color:#f00;"', 'td', false);
$t1->getFooter()->addRow(array('1y','x1y'), 'style="border:1px solid #00f;color:#f00;"', 'td', false);
$t1->getBody(1)->addRow(array('1c','x1c'), 'style="border:1px solid #0ff;color:#f00;"', 'td', false);
$t1->setColGroup(array('z1', 'z1', 'z1'));
$t1->setRowType(1, 'th', 1);
$t1->setColType(1, 'td');
$t1->altRowAttributes(1, 'style="border:1px solid #0ff;color:#f00;background-color:#ac0;"', 'style="border:1px doted #4af;color:#f44;background-color:#f11;"', true, 1, 0);
$t1->setCellAttributes(2, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;"', 0);
$t1->updateCellAttributes(3, 3, 'style="border:2px solid #acf;color:#fca;background-color:#aaa;"', 0);
//var_dump($t1->getCellAttributes(2, 2, 0));
$t1->setCellContents(2, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;"', 'th', 0);
//var_dump($t1->getCellContents(3, 3, 0)); //returns NULL
$t1->setHeaderContents(4, 4, array('alles', 'wird', 'gut'), 'style="border:1px doted #4af;color:#f44;background-color:#444;"', 0);
$t1->setRowAttributes(5, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;"', true, 0);
$t1->updateRowAttributes(1, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;"', false, 1);
$t1->addCol(array('alles', 'wird', 'noch', 'besser'), array('style="border:1px solid #0ff;color:#f00;background-color:#ccc;"', 'style="border:1px doted #4af;color:#f44;background-color:#444;"'), 'td', 1);
$t1->setColAttributes(5, 'style="border:1px dotted #0ff;color:#ff0;background-color:#000;"', 0);
$t1->updateColAttributes(1, 'style="border:1px dashed #0ff;color:#fbb;background-color:#afa;"', 1);
//$t1->setAllAttributes('style="text-align:center;"', 1);
//$t1->updateAllAttributes('style="text-align:right;"', 0);
$t1->setCellAttributes(4, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;" colspan="2"', 0);
$t1->setCellContents(4, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;" colspan="2"', 'th', 0);
$t1->setCellAttributes(5, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;" rowspan="2"', 0);
$t1->setCellContents(5, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;" rowspan="2"', 'td', 0);
$t1->setCellAttributes(5, 2, 'style="border:1px solid #0ff;color:#ccc;background-color:#a00;" rowspan="3" colspan="3"', 1);
$t1->setCellContents(5, 2, 'style="border:1px solid #0ff;color:#ccc;background-color:#a00;" rowspan="3" colspan="3"', 'td', 1);
/**/
//***********************************************************************************
/*
$table2 = new HTML_Common3_Root_Table();
$div2   = $html->body->addElement('div');
$t2     = $div2->addElement($table2);
$t2->setAutoFill('-2-');
$t2->setAutoGrow(true);
$t2->setCaption('Tabelle2');
$t2->addRow(array('2a','x2a'), 'style="border:1px solid #00f;color:#f00;"', 'td', true);
//var_dump('----- $t2->setColCount(7); -----');
$t2->setColCount(7);
//var_dump('----- $t2->setColCount(7); -----');
$t2->setRowCount(7);
$t2->addBody(array('style'=>'border:1px solid #f00;'));
$t2->addRow(array('2b','x2b'), 'style="border:1px solid #00f;color:#f00;"', 'td', false, 1);
$t2->getHeader()->addRow(array('2z','x2z'), 'style="border:1px solid #00f;color:#f00;"', 'td', false);
$t2->getFooter()->addRow(array('2y','x2y'),'style="border:1px solid #00f;color:#f00;"', 'td', false);
$t2->getBody(1)->addRow(array('2c','x2c'), 'style="border:1px solid #0ff;color:#f00;"', 'td', false);
$t2->setColGroup(array('z2', 'z2', 'z2'));
$t2->setRowType(1, 'th', 1);
$t2->setColType(1, 'td');
$t2->altRowAttributes(1, 'style="border:1px solid #0ff;color:#f00;background-color:#ac0;"', 'style="border:1px doted #4af;color:#f44;background-color:#f11;"', true, 1, 0);
$t2->altColAttributes(3, 'style="border:1px groove #0ff;color:#f00;background-color:#aff;"', 'style="border:5px inset #4af;color:#bbb;background-color:#eee;"', 1);
$t2->setCellAttributes(2, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;"', 0);
$t2->updateCellAttributes(3, 3, 'style="border:2px solid #acf;color:#fca;background-color:#aaa;"', 0);
//var_dump($t2->getCellAttributes(2, 2, 0));
$t2->setCellContents(2, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;"', 'th', 0);
//var_dump($t2->getCellContents(3, 3, 0));
$t2->setHeaderContents(4, 4, array('alles', 'wird', 'gut'), 'style="border:1px doted #4af;color:#f44;background-color:#444;"', 0);
$t2->setRowAttributes(5, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;"', true, 0);
$t2->updateRowAttributes(1, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;"', false, 1);
$t2->addCol(array('alles', 'wird', 'noch', 'besser'), array('style="border:1px solid #0ff;color:#f00;background-color:#ccc;"', 'style="border:1px doted #4af;color:#f44;background-color:#444;"'), 'td', 1);
//var_dump($t2->getColCount());
//var_dump($t2->getBody(1)->getColCount());
$t2->setColAttributes(5, 'style="border:1px dotted #0ff;color:#ff0;background-color:#000;"', 0);
$t2->updateColAttributes(1, 'style="border:1px dashed #0ff;color:#fbb;background-color:#afa;"', 1);
//$t2->setAllAttributes('style="text-align:center;"', 1);
//$t2->updateAllAttributes('style="text-align:right;"', 0);
//ini_set('display_errors', 1);
$t2->setCellAttributes(4, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;" colspan="2"', 0);
$t2->setCellContents(4, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;" colspan="2"', 'th', 0);
$t2->setCellContents(4, 3, 'x', 'th', 0);
$t2->setCellAttributes(5, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;" rowspan="2"', 0);
$t2->setCellContents(5, 2, 'style="border:1px solid #0ff;color:#f00;background-color:#ccc;" rowspan="2"', 'td', 0);
$t2->setCellAttributes(5, 2, 'style="border:1px solid #0ff;color:#ccc;background-color:#a00;" rowspan="3" colspan="3"', 1);
$t2->setCellContents(5, 2, 'style="border:1px solid #0ff;color:#ccc;background-color:#a00;" rowspan="3" colspan="3"', 'td', 1);
/**/
//***********************************************************************************
/*
$s1  = new HTML_Javascript();
$l1  = $html->body->addElement('zero');
$l1->setValue($s1->startScript(), HTML_REPLACE, false);
$l1  = $html->body->addElement('zero');
$l1->setValue($s1->write('abx', true), HTML_REPLACE, false);
$l1  = $html->body->addElement('zero');
$l1->setValue($s1->write('cdy', false), HTML_REPLACE, false);
$l1  = $html->body->addElement('zero');
$l1->setValue($s1->writeLine('Hello', false), HTML_REPLACE, false);
$l1  = $html->body->addElement('zero');
$l1->setValue($s1->alert('Hello', false), HTML_REPLACE, false);
$l1  = $html->body->addElement('zero');
$l1->setValue($s1->confirm('Hello', 'x', false), HTML_REPLACE, false);
$l1  = $html->body->addElement('zero');
$l1->setValue($s1->prompt('Hello', 'x', 'nix', false), HTML_REPLACE, false);
$l1  = $html->body->addElement('zero');
$l1->setValue($s1->popup('x', 'zwei', 'Hello', 200, 300, false, 100, 100), HTML_REPLACE, false);
$l1  = $html->body->addElement('zero');
$l1->setValue($s1->popupWrite('x', 'zwei', 'Hello', 200, 300, false, 100, 100), HTML_REPLACE, false);
$l1  = $html->body->addElement('zero');
$l1->setValue($s1->endScript(), HTML_REPLACE, false);
/**/
//***********************************************************************************
/*
$s2 = new HTML_Common3_Root_Script();
$sc2 = $html->head->addElement($s2); //'script');
//var_dump($sc2);
//$sc2->startScript();
$sc2->defineJSVar('abx', 'Hallo', true);
$sc2->defineJSVar('Hi', 'Hallo', false);
$sc2->defineJSVar('drei', 'http://www.geld.de', false);
$sc2->defineJSVar('abz', 1, true);
$sc2->defineJSVar('aba', 1.2, true);
$sc2->defineJSVar('aba', array('HaHa', 'HiHi', 'HöHö'), true);
$sc2->defineJSVar('a', '100px', true);
$sc2->defineJSVar('b', '200px', true);
$sc2->defineJSVar('c', 'yes', true);
$sc2->defineJSVar('d', 'no', true);
$sc2->defineJSVar('abb', array('a'=>'HaHa', 'b'=>'HiHi', 'c'=>'HöHö'), false);
//$sc2->defineJSVar('abb', array('a'=>'HaHa', 'b'=>'HiHi', 'c'=>array('HöHö')), false); //raises an Exception
$sc2->JSwriteln('abx', true);
$sc2->JSwrite('<script>alert("Hallo");</script>', false);
//$sc2->JSwriteln('abx', true);
//$sc2->JSwriteln('cdy', false);
//$sc2->JSwriteLine('Hi', false);
$sc2->alert('Hi', false);
$sc2->alert('Hi', true);
$sc2->confirm('Hi', 'x', false);
$sc2->prompt('Hi', 'x', 'nix', false);
$sc2->popup('x', 'drei', 'Hi', 'a', 'b', true, 'c', 'd', true, true);
$sc2->popupWrite('x', 'drei', 'Hi', 200, 300, false, 200, 200, true, false);
//$sc2->endScript();
//var_dump($sc2->count());
//$c = $sc2->getChildren();
//var_dump($c[0]->getValue());
//var_dump($sc2);
//$sc2->toFile('../test.js');
/**/
//***********************************************************************************
/*
$form1 = new HTML_QuickForm();
$div3  = $html->body->addElement('div');
$f2    = $div3->addElement($form1);
// Elements will be displayed in the order they are declared
$form1->addElement('header', '', 'Normal Elements');
// Classic form elements
$form1->addElement('hidden', 'ihidTest', 'hiddenField');
$form1->addElement('text', 'itxtTest', 'Test Text:');
$form1->addElement('textarea', 'itxaTest', 'Test TextArea:', array('rows' => 3, 'cols' => 20));
$form1->addElement('password', 'ipwdTest', 'Test Password:');
$form1->addElement('checkbox', 'ichkTest', 'Test CheckBox:', 'Check the box');
$form1->addElement('radio', 'iradTest', 'Test Radio Buttons:', 'Check the radio button #1', 1);
$form1->addElement('radio', 'iradTest', '(Not a group)', 'Check the radio button #2', 2);
$form1->addElement('button', 'ibtnTest', 'Test Button', array('onclick' => "alert('This is a test');"));
$form1->addElement('reset', 'iresTest', 'Test Reset');
$form1->addElement('submit', 'isubTest', 'Test Submit');
$form1->addElement('image', 'iimgTest', 'http://pear.php.net/gifs/pear-icon.gif');
$select1 = $form1->addElement('select', 'iselTest', 'Test Select:', array('A'=>'A', 'B'=>'B','C'=>'C','D'=>'D'));
$select1->setSize(5);
$select1->setMultiple(true);

$form1->addElement('header', '', 'Custom Elements');
// Date elements
/*
$form1->addElement('date', 'dateTest1', 'Date1:', array('format'=>'dmY', 'minYear'=>2010, 'maxYear'=>2001));
$form1->addElement('date', 'dateTest2', 'Date2:', array('format'=>'d-F-Y H:i', 'language'=>'de', 'optionIncrement' => array('i' => 5)));
$form1->addElement('date', 'dateTest3', 'Today is:', array('format'=>'l d M Y'));

$main[0] = "Pop";
$main[1] = "Rock";
$main[2] = "Classical";

$secondary[0][0] = "Belle & Sebastian";
$secondary[0][1] = "Elliot Smith";
$secondary[0][2] = "Beck";
$secondary[1][3] = "Noir Desir";
$secondary[1][4] = "Violent Femmes";
$secondary[2][5] = "Wagner";
$secondary[2][6] = "Mozart";
$secondary[2][7] = "Beethoven";

$opts[] = $main;
$opts[] = $secondary;

$hs =& $form1->addElement('hierselect', 'ihsTest', 'Hierarchical select:', array('style' => 'width: 20em;'), '<br />');
$hs->setOptions($opts);

$form1->addElement('advcheckbox', 'iadvChk', array('Advanced checkbox:', 'Unlike standard checkbox, this element <b>has</b> a value<br />when it is not checked.'), 'Check the box', null, array('off', 'on'));

$form1->addElement('autocomplete', 'iautoComp', array('Your favourite fruit:', 'This is autocomplete element.<br />Start typing and see how it suggests possible completions.'), array('Pear', 'Orange', 'Apple'), array('size' => 30));
*/

//$form1->addElement('header', '', 'Grouped Elements');


/**/
//***********************************************************************************
/*
$form2 = new HTML_QuickForm2(null);
$div4  = $html->body->addElement('div');
$f2    = $div4->addElement($form2);
/**/
//***********************************************************************************

$form3 = new HTML_Common3_Root_Form(array('name'=>'Root_Form_Test'));//var_dump($form3);
$div5  = $html->body->addElement('div');
$f3    = $div5->addElement($form3);var_dump($f3);
// Elements will be displayed in the order they are declared
$form3->addElement('header', null, HTML_APPEND, '', 'Normal Elements');
// Classic form elements
$form3->addElement('hidden', null, HTML_APPEND, 'ihidTest', 'hiddenField');
$form3->addElement('text', null, HTML_APPEND, 'itxtTest', 'Test Text:');
$form3->addElement('textarea', array('id' => 'itxaTest', 'rows' => 3, 'cols' => 20), HTML_APPEND, 'itxaTest', 'Test TextArea:');
$form3->addElement('password', null, HTML_APPEND, 'ipwdTest', 'Test Password:');
$form3->addElement('checkbox', null, HTML_APPEND, 'ichkTest', 'Test CheckBox:', 'Check the box');
//$form3->addElement('radio', null, HTML_APPEND, 'iradTest', 'Test Radio Buttons:', 'Check the radio button #1', 1);
//$form3->addElement('radio', null, HTML_APPEND, 'iradTest', '(Not a group)', 'Check the radio button #2', 2);
$form3->addElement('button', array('onclick' => "alert('This is a test');"), HTML_APPEND, 'ibtnTest', 'Test Button');
$form3->addElement('reset', null, HTML_APPEND, 'iresTest', 'Test Reset');
$form3->addElement('submit', null, HTML_APPEND, 'isubTest', 'Test Submit');
$form3->addElement('image', array('src' => 'http://pear.php.net/gifs/pear-icon.gif'), HTML_APPEND, 'iimgTest');
$select3 = $form3->addElement('select', null, HTML_APPEND, 'iselTest', 'Test Select:', array('A'=>'A', 'B'=>'B','C'=>'C','D'=>'D'));
//$select->setSize(5);
//$select->setMultiple(true);

$form3->addElement('header', null, HTML_APPEND, '', 'Custom Elements');
// Date elements
/*
$form3->addElement('date', null, HTML_APPEND, 'dateTest1', 'Date1:', array('format'=>'dmY', 'minYear'=>2010, 'maxYear'=>2001));
$form3->addElement('date', null, HTML_APPEND, 'dateTest2', 'Date2:', array('format'=>'d-F-Y H:i', 'language'=>'de', 'optionIncrement' => array('i' => 5)));
$form3->addElement('date', null, HTML_APPEND, 'dateTest3', 'Today is:', array('format'=>'l d M Y'));

$main[0] = "Pop";
$main[1] = "Rock";
$main[2] = "Classical";

$secondary[0][0] = "Belle & Sebastian";
$secondary[0][1] = "Elliot Smith";
$secondary[0][2] = "Beck";
$secondary[1][3] = "Noir Desir";
$secondary[1][4] = "Violent Femmes";
$secondary[2][5] = "Wagner";
$secondary[2][6] = "Mozart";
$secondary[2][7] = "Beethoven";

$opts[] = $main;
$opts[] = $secondary;

$hs =& $form3->addElement('hierselect', array('style' => 'width: 20em;'), HTML_APPEND, 'ihsTest', 'Hierarchical select:', '<br />');
$hs->setOptions($opts);

$form3->addElement('advcheckbox', null, HTML_APPEND, 'iadvChk', array('Advanced checkbox:', 'Unlike standard checkbox, this element <b>has</b> a value<br />when it is not checked.'), 'Check the box', null, array('off', 'on'));

$form3->addElement('autocomplete', null, HTML_APPEND, 'iautoComp', array('Your favourite fruit:', 'This is autocomplete element.<br />Start typing and see how it suggests possible completions.'), array('Pear', 'Orange', 'Apple'), array('size' => 30));

*/
$form3->addElement('header', null, HTML_APPEND, '', null, 'Grouped Elements');



/**/
//$form4 = $html->body->addElement('form');
//test($form4);

//create an output file
//$txt = $html->toFile('./test.html');
/*
$txt2 = var_export($html->IDs, TRUE);

$file = fopen('./test.tmp','wb');
fwrite($file, $txt2);
fclose($file);
/**/


//show the output in the browser
//$txt = $html->display();
//var_dump('------- $html->toHtml(0, false, true) -------');
echo $html->toHtml(0, true, true);
////var_dump($txt);

//echo $txt;


function test(&$object, $step = 0)
{
    //set limits for recursive site creation
    $step2           = $step + 1;
    $step3           = 2;
    $step4           = 2;
    //set the HTML-Elements which should expanded
    $expand_name     = array('a');//, 'abbr', 'acronym', 'address', 'b', 'bdo', 'button', 'cite', 'code', 'del', 'dfn', 'div', 'em', 'i', 'ins', 'kbd', 'label', 'map', 'q', 'samp', 'script', 'small', 'span', 'strong', 'sub', 'sup', 'tt', 'var');
    //get all possible child elements for the actual object
    $posBodyElements = $object->getPosElements();
    
    if (($step2 < $step3) || in_array($object->getElementName(), $expand_name)) {
        foreach ($posBodyElements as $elementName) {
            //create child elements                        test2(&$object, $elementName, $step, $step2, $step4, $expand_name);
        }
    } elseif (isset($posBodyElements[0])) {        $elementName = $posBodyElements[0];
                test2(&$object, $elementName, $step, $step2, $step4, $expand_name);
    }
}

function test2(&$object, $elementName = '', $step = 0, $step2 = 1, $step4 = 1, $expand_name = array('a')) {
    //create child elements
    $element = $object->addElement($elementName);
    if ($elementName == 'if') {
        //$element->setValid(false);
    }
    
    if (is_object($element)) {
        //get all possible attributes for the child element
        $posElementAttribs = $element->getPosAttributes();
        
        try{
            $element->setValue('TEST' . $element->getIndentLevel());
        } catch(HTML_Common3_Exception $e) {
        }
        
        if ($step2 < $step4) {
            //set the attributes to the child element
            foreach ($posElementAttribs as $ElementAttrib) {
                if (substr($ElementAttrib, 0, 2) != 'on' && $ElementAttrib != 'id') {
                    $element->setAttribute($ElementAttrib, $elementName . '_TEST' . $element->getIndentLevel());
                }
            }
        }
        
        //go to the next level
        if ($step2 < ($step4 + 1)) {
            test($element, $step2);
        } elseif (in_array($object->getElementName(), $expand_name) && $step2 < $step4 + 1) {
            //test($element, $step2);
        }
        
        if ($step2 == 1) {
            $element = $object->addElement('hr');
        }
    }    
    $element = $object->addElement('html');
    $element = $object->addElement('head');
    $element = $object->addElement('title');
    $element = $object->addElement('body');
}
/**/
?>