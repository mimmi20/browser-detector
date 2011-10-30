--TEST--
HTML_Form
--INI--
error_reporting = 2047
--SKIPIF--
--FILE--
<?php

/**
 * Tests for the HTML_Form package
 *
 * @category HTML
 * @package  HTML_Form
 * @version  $Id$
 */

if (!defined('PATH_SEPARATOR')) {
    if (stristr(PHP_OS, 'WIN')) {
        define('PATH_SEPARATOR', ';');
    } else {
        define('PATH_SEPARATOR', ':');
    }
}

/*
 * If the path to your PEAR installation is found in the left hand
 * portion of the if() expression below, that means this file has
 * come from the PEAR installer.  Therefore, let's use the
 * installed version of DB, which should be found via the
 * computer's default include_path.  Add '.' to the include_path
 * to ensure '.' is in there.
 * 
 * If the path has not been substituted in the if() expression,
 * this file has likely come from a CVS checkout or a .tar file.
 * Therefore, we'll assume the tests should use the version of
 * DB that has come from there as well.
 */
if ('@include_path@' != '@'.'include_path'.'@') {
    ini_set('include_path', ini_get('include_path')
            . PATH_SEPARATOR . '.'
    );
} else {
    ini_set('include_path', realpath(dirname(__FILE__) . '/..')
            . PATH_SEPARATOR . '.' . PATH_SEPARATOR
            . ini_get('include_path')
    );
}

require_once 'HTML/Form.php';
$form = new HTML_Form('test.php');


echo "============ TEXT DEFAULTS ============\n";
echo "------------ RETURN\n";
echo $form->returnText('nm');
echo "------------ DISPLAY DIRECT\n";
$form->displayText('nm');
echo "------------ RETURN ROW\n";
echo $form->returnTextRow('nm', 'Ttl');
echo "------------ DISPLAY ROW\n";
$form->displayTextRow('nm', 'Ttl');
echo "------------ DISPLAY ADD\n";
$form->addText('nm', 'Ttl');
$form->display();
$form->fields = array();

echo "============ TEXT MANUAL ============\n";
echo "------------ RETURN\n";
echo $form->returnText('nm', 'v', 5, 9, 'id="i"');
echo "------------ DISPLAY DIRECT\n";
$form->displayText('nm', 'v', 5, 9, 'id="i"');
echo "------------ RETURN ROW\n";
echo $form->returnTextRow('nm', 'Ttl', 'v', 5, 9, 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displayTextRow('nm', 'Ttl', 'v', 5, 9, 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addText('nm', 'Ttl', 'v', 5, 9, 'id="i"',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();


echo "============ PASSWORD DEFAULTS ============\n";
echo "------------ RETURN\n";
echo $form->returnPassword('nm');
echo "------------ DISPLAY DIRECT\n";
$form->displayPassword('nm');
echo "------------ RETURN ROW\n";
echo $form->returnPasswordRow('nm', 'Ttl');
echo "------------ DISPLAY ROW\n";
$form->displayPasswordRow('nm', 'Ttl');
echo "------------ DISPLAY ADD\n";
$form->addPassword('nm', 'Ttl');
$form->display();
$form->fields = array();
echo "------------ RETURN ROW ONE\n";
echo $form->returnPasswordOneRow('nm', 'Ttl');
echo "------------ DISPLAY ROW ONE\n";
$form->displayPasswordOneRow('nm', 'Ttl');
echo "------------ DISPLAY ADD ONE\n";
$form->addPasswordOne('nm', 'Ttl');
$form->display();
$form->fields = array();

echo "============ PASSWORD MANUAL ============\n";
echo "------------ RETURN\n";
echo $form->returnPassword('nm', 'v', 5, 9, 'id="i"');
echo "------------ DISPLAY DIRECT\n";
$form->displayPassword('nm', 'v', 5, 9, 'id="i"');
echo "------------ RETURN ROW\n";
echo $form->returnPasswordRow('nm', 'Ttl', 'v', 5, 9, 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displayPasswordRow('nm', 'Ttl', 'v', 5, 9, 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addPassword('nm', 'Ttl', 'v', 5, 9, 'id="i"',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();


echo "============ CHECKBOX DEFAULTS ============\n";
echo "------------ RETURN\n";
echo $form->returnCheckbox('nm');
echo "------------ DISPLAY DIRECT\n";
$form->displayCheckbox('nm');
echo "------------ RETURN ROW\n";
echo $form->returnCheckboxRow('nm', 'Ttl');
echo "------------ DISPLAY ROW\n";
$form->displayCheckboxRow('nm', 'Ttl');
echo "------------ DISPLAY ADD\n";
$form->addCheckbox('nm', 'Ttl');
$form->display();
$form->fields = array();

echo "============ CHECKBOX MANUAL ============\n";
echo "------------ RETURN\n";
echo $form->returnCheckbox('nm', true, 'id="i"');
echo "------------ DISPLAY DIRECT\n";
$form->displayCheckbox('nm', true, 'id="i"');
echo "------------ RETURN ROW\n";
echo $form->returnCheckboxRow('nm', 'Ttl', true, 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displayCheckboxRow('nm', 'Ttl', true, 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addCheckbox('nm', 'Ttl', true, 'id="i"',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();


echo "============ TEXTAREA DEFAULTS ============\n";
echo "------------ RETURN\n";
echo $form->returnTextarea('nm');
echo "------------ DISPLAY DIRECT\n";
$form->displayTextarea('nm');
echo "------------ RETURN ROW\n";
echo $form->returnTextareaRow('nm', 'Ttl');
echo "------------ DISPLAY ROW\n";
$form->displayTextareaRow('nm', 'Ttl');
echo "------------ DISPLAY ADD\n";
$form->addTextarea('nm', 'Ttl');
$form->display();
$form->fields = array();

echo "============ TEXTAREA MANUAL ============\n";
echo "------------ RETURN\n";
echo $form->returnTextarea('nm', 'v', 5, 6, 9, 'id="i"');
echo "------------ DISPLAY DIRECT\n";
$form->displayTextarea('nm', 'v', 5, 6, 9, 'id="i"');
echo "------------ RETURN ROW\n";
echo $form->returnTextareaRow('nm', 'Ttl', 'v', 5, 6, 9, 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displayTextareaRow('nm', 'Ttl', 'v', 5, 6, 9, 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addTextarea('nm', 'Ttl', 'v', 5, 6, 9, 'id="i"',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();


echo "============ SUBMIT DEFAULTS ============\n";
echo "------------ RETURN\n";
echo $form->returnSubmit('Ttl', 'nm');
echo "------------ DISPLAY DIRECT\n";
$form->displaySubmit('Ttl', 'nm');
echo "------------ RETURN ROW\n";
echo $form->returnSubmitRow('nm', 'Ttl');
echo "------------ DISPLAY ROW\n";
$form->displaySubmitRow('nm', 'Ttl');
echo "------------ DISPLAY ADD\n";
$form->addSubmit('nm', 'Ttl');
$form->display();
$form->fields = array();

echo "============ SUBMIT MANUAL ============\n";
echo "------------ RETURN\n";
echo $form->returnSubmit('Ttl', 'nm', 'id="i"');
echo "------------ DISPLAY DIRECT\n";
$form->displaySubmit('Ttl', 'nm', 'id="i"');
echo "------------ RETURN ROW\n";
echo $form->returnSubmitRow('nm', 'Ttl', 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displaySubmitRow('nm', 'Ttl', 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addSubmit('nm', 'Ttl', 'id="i"',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();


echo "============ RESET DEFAULTS ============\n";
echo "------------ RETURN\n";
echo $form->returnReset('Ttl');
echo "------------ DISPLAY DIRECT\n";
$form->displayReset('Ttl');
echo "------------ RETURN ROW\n";
echo $form->returnResetRow('Ttl');
echo "------------ DISPLAY ROW\n";
$form->displayResetRow('Ttl');
echo "------------ DISPLAY ADD\n";
$form->addReset('Ttl');
$form->display();
$form->fields = array();

echo "============ RESET MANUAL ============\n";
echo "------------ RETURN\n";
echo $form->returnReset('Ttl', 'id="i"');
echo "------------ DISPLAY DIRECT\n";
$form->displayReset('Ttl', 'id="i"');
echo "------------ RETURN ROW\n";
echo $form->returnResetRow('Ttl', 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displayResetRow('Ttl', 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addReset('Ttl', 'id="i"',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();


$entries = array(
    'first',
    'second',
);
echo "============ SELECT DEFAULTS, ENUM ARRAY ============\n";
echo "------------ RETURN\n";
echo $form->returnSelect('nm', $entries);
echo "------------ DISPLAY DIRECT\n";
$form->displaySelect('nm', $entries);
echo "------------ RETURN ROW\n";
echo $form->returnSelectRow('nm', 'Ttl', $entries);
echo "------------ DISPLAY ROW\n";
$form->displaySelectRow('nm', 'Ttl', $entries);
echo "------------ DISPLAY ADD\n";
$form->addSelect('nm', 'Ttl', $entries);
$form->display();
$form->fields = array();

$entries = array(
    'a' => 'first',
    'v' => 'second',
);
echo "============ SELECT DEFAULTS, ASSOC ARRAY ============\n";
echo "------------ RETURN\n";
echo $form->returnSelect('nm', $entries);
echo "------------ DISPLAY DIRECT\n";
$form->displaySelect('nm', $entries);
echo "------------ RETURN ROW\n";
echo $form->returnSelectRow('nm', 'Ttl', $entries);
echo "------------ DISPLAY ROW\n";
$form->displaySelectRow('nm', 'Ttl', $entries);
echo "------------ DISPLAY ADD\n";
$form->addSelect('nm', 'Ttl', $entries);
$form->display();
$form->fields = array();

echo "============ SELECT MANUAL, ASSOC ARRAY ============\n";
echo "------------ RETURN\n";
echo $form->returnSelect('nm', $entries, 'v', 2, 'pick', true, 'id="i"');
echo "------------ DISPLAY DIRECT\n";
$form->displaySelect('nm', $entries, 'v', 2, 'pick', true, 'id="i"');
echo "------------ RETURN ROW\n";
echo $form->returnSelectRow('nm', 'Ttl', $entries, 'v', 2, 'pick', true,
        'id="i"', 'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displaySelectRow('nm', 'Ttl', $entries, 'v', 2, 'pick', true,
        'id="i"', 'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addSelect('nm', 'Ttl', $entries, 'v', 2, 'pick', true, 'id="i"',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();


$entries = array(
    '' => 'empty',
    0  => 'zero',
    1  => 'one',
);
echo "============ SELECT DEFAULTS, ASSOC ARRAY, DEFAULT 0 ============\n";
echo "------------ RETURN\n";
echo $form->returnSelect('nm', $entries, 0);
echo "------------ DISPLAY DIRECT\n";
$form->displaySelect('nm', $entries, 0);
echo "------------ RETURN ROW\n";
echo $form->returnSelectRow('nm', 'Ttl', $entries, 0);
echo "------------ DISPLAY ROW\n";
$form->displaySelectRow('nm', 'Ttl', $entries, 0);
echo "------------ DISPLAY ADD\n";
$form->addSelect('nm', 'Ttl', $entries, 0);
$form->display();
$form->fields = array();

echo "============ SELECT DEFAULTS, ASSOC ARRAY, DEFAULT '' ============\n";
echo "------------ RETURN\n";
echo $form->returnSelect('nm', $entries, '');
echo "------------ DISPLAY DIRECT\n";
$form->displaySelect('nm', $entries, '');
echo "------------ RETURN ROW\n";
echo $form->returnSelectRow('nm', 'Ttl', $entries, '');
echo "------------ DISPLAY ROW\n";
$form->displaySelectRow('nm', 'Ttl', $entries, '');
echo "------------ DISPLAY ADD\n";
$form->addSelect('nm', 'Ttl', $entries, '');
$form->display();
$form->fields = array();


echo "============ RADIO DEFAULTS ============\n";
echo "------------ RETURN\n";
echo $form->returnRadio('nm', 'v');
echo "------------ DISPLAY DIRECT\n";
$form->displayRadio('nm', 'v');
echo "------------ RETURN ROW\n";
echo $form->returnRadioRow('nm', 'Ttl', 'v');
echo "------------ DISPLAY ROW\n";
$form->displayRadioRow('nm', 'Ttl', 'v');
echo "------------ DISPLAY ADD\n";
$form->addRadio('nm', 'Ttl', 'v');
$form->display();
$form->fields = array();

echo "============ RADIO MANUAL ============\n";
echo "------------ RETURN\n";
echo $form->returnRadio('nm', 'v', true, 'id="i"');
echo "------------ DISPLAY DIRECT\n";
$form->displayRadio('nm', 'v', true, 'id="i"');
echo "------------ RETURN ROW\n";
echo $form->returnRadioRow('nm', 'Ttl', 'v', true, 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displayRadioRow('nm', 'Ttl', 'v', true, 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addRadio('nm', 'Ttl', 'v', true, 'id="i"',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();


echo "============ IMAGE DEFAULTS ============\n";
echo "------------ RETURN\n";
echo $form->returnImage('nm', 'gr');
echo "------------ DISPLAY DIRECT\n";
$form->displayImage('nm', 'gr');
echo "------------ RETURN ROW\n";
echo $form->returnImageRow('nm', 'Ttl', 'gr');
echo "------------ DISPLAY ROW\n";
$form->displayImageRow('nm', 'Ttl', 'gr');
echo "------------ DISPLAY ADD\n";
$form->addImage('nm', 'Ttl', 'gr');
$form->display();
$form->fields = array();

echo "============ IMAGE MANUAL ============\n";
echo "------------ RETURN\n";
echo $form->returnImage('nm', 'gr', 'id="i"');
echo "------------ DISPLAY DIRECT\n";
$form->displayImage('nm', 'gr', 'id="i"');
echo "------------ RETURN ROW\n";
echo $form->returnImageRow('nm', 'Ttl', 'gr', 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displayImageRow('nm', 'Ttl', 'gr', 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addImage('nm', 'Ttl', 'gr', 'id="i"',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();


echo "============ HIDDEN DEFAULTS ============\n";
echo "------------ RETURN\n";
echo $form->returnHidden('nm', 'v');
echo "------------ DISPLAY DIRECT\n";
$form->displayHidden('nm', 'v');
echo "------------ DISPLAY ADD\n";
$form->addHidden('nm', 'v');
$form->display();
$form->fields = array();

echo "============ HIDDEN MANUAL ============\n";
echo "------------ RETURN\n";
echo $form->returnHidden('nm', 'v', 'id="i"');
echo "------------ DISPLAY DIRECT\n";
$form->displayHidden('nm', 'v', 'id="i"');
echo "------------ DISPLAY ADD\n";
$form->addHidden('nm', 'v', 'id="i"',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();


echo "============ BLANK DEFAULT ============\n";
echo "------------ RETURN ROW\n";
echo $form->returnBlankRow(1, 'Ttl');
echo "------------ DISPLAY ROW\n";
$form->displayBlankRow(1, 'Ttl');
echo "------------ DISPLAY ADD\n";
$form->addBlank(1, 'Ttl');
$form->display();
$form->fields = array();

echo "============ BLANK MANUAL ============\n";
echo "------------ RETURN ROW\n";
echo $form->returnBlankRow(1, 'Ttl',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displayBlankRow(1, 'Ttl',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addBlank(1, 'Ttl',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();

echo "============ BLANK DEFAULT 2 ============\n";
echo "------------ RETURN ROW\n";
echo $form->returnBlankRow(2);
echo "------------ DISPLAY ROW\n";
$form->displayBlankRow(2);
echo "------------ DISPLAY ADD\n";
$form->addBlank(2, 'Ttl');
$form->display();
$form->fields = array();

echo "============ BLANK MANUAL 2 ============\n";
echo "------------ RETURN ROW\n";
echo $form->returnBlankRow(2, '', 'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displayBlankRow(2, '', 'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addBlank(2, '', 'class="h"', 'class="d"');
$form->display();
$form->fields = array();


echo "============ FILE DEFAULTS ============\n";
echo "------------ RETURN\n";
echo $form->returnFile('nm');
echo "------------ DISPLAY DIRECT\n";
$form->displayFile('nm');
echo "------------ RETURN ROW\n";
echo $form->returnFileRow('nm', 'Ttl');
echo "------------ DISPLAY ROW\n";
$form->displayFileRow('nm', 'Ttl');
echo "------------ DISPLAY ADD\n";
$form->addFile('nm', 'Ttl');
$form->display();
$form->fields = array();

echo "============ FILE MANUAL ============\n";
echo "------------ RETURN\n";
echo $form->returnFile('nm', 9, 5, 'ac', 'id="i"');
echo "------------ DISPLAY DIRECT\n";
$form->displayFile('nm', 9, 5, 'ac', 'id="i"');
echo "------------ RETURN ROW\n";
echo $form->returnFileRow('nm', 'Ttl', 9, 5, 'ac', 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ROW\n";
$form->displayFileRow('nm', 'Ttl', 9, 5, 'ac', 'id="i"',
        'class="h"', 'class="d"');
echo "------------ DISPLAY ADD\n";
$form->addFile('nm', 'Ttl', 9, 5, 'ac', 'id="i"',
        'class="h"', 'class="d"');
$form->display();
$form->fields = array();


echo "============ MULTIPLE FILES DEFAULTS ============\n";
echo "------------ RETURN\n";
echo $form->returnMultipleFiles();

echo "============ MULTIPLE FILES MANUAL ============\n";
echo "------------ RETURN\n";
echo $form->returnMultipleFiles('nm', 9, 2, 5, 'ac', 'id="i"');


echo "============ FORM MANUAL ============\n";
$tmp = new HTML_Form('test.php', 'post', 'nm', 'tgt', 'enc', 'id="i"');
$tmp->addText('nm', 'Ttl');
$tmp->display('class="tbl"', 'A Caption For You', 'class="cap"');

?>
--GET--
--POST--
--EXPECT--
============ TEXT DEFAULTS ============
------------ RETURN
<input type="text" name="nm" size="20" value="" />
------------ DISPLAY DIRECT
<input type="text" name="nm" size="20" value="" />
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="text" name="nm" size="20" value="" />
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="text" name="nm" size="20" value="" />
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="text" name="nm" size="20" value="" />
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ TEXT MANUAL ============
------------ RETURN
<input type="text" name="nm" size="5" value="v" maxlength="9" id="i"/>
------------ DISPLAY DIRECT
<input type="text" name="nm" size="5" value="v" maxlength="9" id="i"/>
------------ RETURN ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="text" name="nm" size="5" value="v" maxlength="9" id="i"/>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="text" name="nm" size="5" value="v" maxlength="9" id="i"/>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="text" name="nm" size="5" value="v" maxlength="9" id="i"/>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ PASSWORD DEFAULTS ============
------------ RETURN
<input type="password" name="nm" size="8" value="" />
------------ DISPLAY DIRECT
<input type="password" name="nm" size="8" value="" />
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="password" name="nm" size="8" value="" />
   repeat: <input type="password" name="nm2" size="8" value="" />
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="password" name="nm" size="8" value="" />
   repeat: <input type="password" name="nm2" size="8" value="" />
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="password" name="nm" size="8" value="" />
   repeat: <input type="password" name="nm2" size="8" value="" />
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

------------ RETURN ROW ONE
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="password" name="nm" size="8" value="" />
  </td>
 </tr>
------------ DISPLAY ROW ONE
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="password" name="nm" size="8" value="" />
  </td>
 </tr>
------------ DISPLAY ADD ONE
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="password" name="nm" size="8" value="" />
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ PASSWORD MANUAL ============
------------ RETURN
<input type="password" name="nm" size="5" value="v" maxlength="9" id="i"/>
------------ DISPLAY DIRECT
<input type="password" name="nm" size="5" value="v" maxlength="9" id="i"/>
------------ RETURN ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="password" name="nm" size="5" value="v" maxlength="9" id="i"/>
   repeat: <input type="password" name="nm2" size="5" value="v" maxlength="9" id="i"/>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="password" name="nm" size="5" value="v" maxlength="9" id="i"/>
   repeat: <input type="password" name="nm2" size="5" value="v" maxlength="9" id="i"/>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="password" name="nm" size="5" value="v" maxlength="9" id="i"/>
   repeat: <input type="password" name="nm2" size="5" value="v" maxlength="9" id="i"/>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ CHECKBOX DEFAULTS ============
------------ RETURN
<input type="checkbox" name="nm" />
------------ DISPLAY DIRECT
<input type="checkbox" name="nm" />
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="checkbox" name="nm" />
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="checkbox" name="nm" />
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="checkbox" name="nm" />
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ CHECKBOX MANUAL ============
------------ RETURN
<input type="checkbox" name="nm" checked="checked" id="i"/>
------------ DISPLAY DIRECT
<input type="checkbox" name="nm" checked="checked" id="i"/>
------------ RETURN ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="checkbox" name="nm" checked="checked" id="i"/>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="checkbox" name="nm" checked="checked" id="i"/>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="checkbox" name="nm" checked="checked" id="i"/>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ TEXTAREA DEFAULTS ============
------------ RETURN
<textarea name="nm" cols="40" rows="5" ></textarea>
------------ DISPLAY DIRECT
<textarea name="nm" cols="40" rows="5" ></textarea>
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <textarea name="nm" cols="40" rows="5" ></textarea>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <textarea name="nm" cols="40" rows="5" ></textarea>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <textarea name="nm" cols="40" rows="5" ></textarea>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ TEXTAREA MANUAL ============
------------ RETURN
<textarea name="nm" cols="5" rows="6" maxlength="9" id="i">v</textarea>
------------ DISPLAY DIRECT
<textarea name="nm" cols="5" rows="6" maxlength="9" id="i">v</textarea>
------------ RETURN ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <textarea name="nm" cols="5" rows="6" maxlength="9" id="i">v</textarea>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <textarea name="nm" cols="5" rows="6" maxlength="9" id="i">v</textarea>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <textarea name="nm" cols="5" rows="6" maxlength="9" id="i">v</textarea>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ SUBMIT DEFAULTS ============
------------ RETURN
<input type="submit" name="nm" value="Ttl" />
------------ DISPLAY DIRECT
<input type="submit" name="nm" value="Ttl" />
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">&nbsp;</th>
  <td >
   <input type="submit" name="nm" value="Ttl" />
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">&nbsp;</th>
  <td >
   <input type="submit" name="nm" value="Ttl" />
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">&nbsp;</th>
  <td >
   <input type="submit" name="nm" value="Ttl" />
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ SUBMIT MANUAL ============
------------ RETURN
<input type="submit" name="nm" value="Ttl" id="i"/>
------------ DISPLAY DIRECT
<input type="submit" name="nm" value="Ttl" id="i"/>
------------ RETURN ROW
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">
   <input type="submit" name="nm" value="Ttl" id="i"/>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">
   <input type="submit" name="nm" value="Ttl" id="i"/>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">
   <input type="submit" name="nm" value="Ttl" id="i"/>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ RESET DEFAULTS ============
------------ RETURN
<input type="reset" value="Ttl" />
------------ DISPLAY DIRECT
<input type="reset" value="Ttl" />
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">&nbsp;</th>
  <td >
   <input type="reset" value="Ttl" />
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">&nbsp;</th>
  <td >
   <input type="reset" value="Ttl" />
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">&nbsp;</th>
  <td >
   <input type="reset" value="Ttl" />
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="" />
</form>

============ RESET MANUAL ============
------------ RETURN
<input type="reset" value="Ttl" id="i"/>
------------ DISPLAY DIRECT
<input type="reset" value="Ttl" id="i"/>
------------ RETURN ROW
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">
   <input type="reset" value="Ttl" id="i"/>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">
   <input type="reset" value="Ttl" id="i"/>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">
   <input type="reset" value="Ttl" id="i"/>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="" />
</form>

============ SELECT DEFAULTS, ENUM ARRAY ============
------------ RETURN
   <select name="nm" size="1" >
    <option value="0">first</option>
    <option value="1">second</option>
   </select>
------------ DISPLAY DIRECT
   <select name="nm" size="1" >
    <option value="0">first</option>
    <option value="1">second</option>
   </select>
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option value="0">first</option>
    <option value="1">second</option>
   </select>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option value="0">first</option>
    <option value="1">second</option>
   </select>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option value="0">first</option>
    <option value="1">second</option>
   </select>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ SELECT DEFAULTS, ASSOC ARRAY ============
------------ RETURN
   <select name="nm" size="1" >
    <option value="a">first</option>
    <option value="v">second</option>
   </select>
------------ DISPLAY DIRECT
   <select name="nm" size="1" >
    <option value="a">first</option>
    <option value="v">second</option>
   </select>
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option value="a">first</option>
    <option value="v">second</option>
   </select>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option value="a">first</option>
    <option value="v">second</option>
   </select>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option value="a">first</option>
    <option value="v">second</option>
   </select>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ SELECT MANUAL, ASSOC ARRAY ============
------------ RETURN
   <select name="nm[]" size="2" multiple="multiple" id="i">
    <option value="">pick</option>
    <option value="a">first</option>
    <option selected="selected" value="v">second</option>
   </select>
------------ DISPLAY DIRECT
   <select name="nm[]" size="2" multiple="multiple" id="i">
    <option value="">pick</option>
    <option value="a">first</option>
    <option selected="selected" value="v">second</option>
   </select>
------------ RETURN ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <select name="nm[]" size="2" multiple="multiple" id="i">
    <option value="">pick</option>
    <option value="a">first</option>
    <option selected="selected" value="v">second</option>
   </select>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <select name="nm[]" size="2" multiple="multiple" id="i">
    <option value="">pick</option>
    <option value="a">first</option>
    <option selected="selected" value="v">second</option>
   </select>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <select name="nm[]" size="2" multiple="multiple" id="i">
    <option value="">pick</option>
    <option value="a">first</option>
    <option selected="selected" value="v">second</option>
   </select>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ SELECT DEFAULTS, ASSOC ARRAY, DEFAULT 0 ============
------------ RETURN
   <select name="nm" size="1" >
    <option value="">empty</option>
    <option selected="selected" value="0">zero</option>
    <option value="1">one</option>
   </select>
------------ DISPLAY DIRECT
   <select name="nm" size="1" >
    <option value="">empty</option>
    <option selected="selected" value="0">zero</option>
    <option value="1">one</option>
   </select>
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option value="">empty</option>
    <option selected="selected" value="0">zero</option>
    <option value="1">one</option>
   </select>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option value="">empty</option>
    <option selected="selected" value="0">zero</option>
    <option value="1">one</option>
   </select>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option value="">empty</option>
    <option selected="selected" value="0">zero</option>
    <option value="1">one</option>
   </select>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ SELECT DEFAULTS, ASSOC ARRAY, DEFAULT '' ============
------------ RETURN
   <select name="nm" size="1" >
    <option selected="selected" value="">empty</option>
    <option value="0">zero</option>
    <option value="1">one</option>
   </select>
------------ DISPLAY DIRECT
   <select name="nm" size="1" >
    <option selected="selected" value="">empty</option>
    <option value="0">zero</option>
    <option value="1">one</option>
   </select>
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option selected="selected" value="">empty</option>
    <option value="0">zero</option>
    <option value="1">one</option>
   </select>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option selected="selected" value="">empty</option>
    <option value="0">zero</option>
    <option value="1">one</option>
   </select>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <select name="nm" size="1" >
    <option selected="selected" value="">empty</option>
    <option value="0">zero</option>
    <option value="1">one</option>
   </select>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ RADIO DEFAULTS ============
------------ RETURN
<input type="radio" name="nm" value="v" />
------------ DISPLAY DIRECT
<input type="radio" name="nm" value="v" />
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="radio" name="nm" value="v" />
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="radio" name="nm" value="v" />
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="radio" name="nm" value="v" />
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ RADIO MANUAL ============
------------ RETURN
<input type="radio" name="nm" value="v" checked="checked" id="i"/>
------------ DISPLAY DIRECT
<input type="radio" name="nm" value="v" checked="checked" id="i"/>
------------ RETURN ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="radio" name="nm" value="v" checked="checked" id="i"/>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="radio" name="nm" value="v" checked="checked" id="i"/>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="radio" name="nm" value="v" checked="checked" id="i"/>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ IMAGE DEFAULTS ============
------------ RETURN
<input type="image" name="nm" src="gr" />
------------ DISPLAY DIRECT
<input type="image" name="nm" src="gr" />
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="image" name="nm" src="gr" />
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="image" name="nm" src="gr" />
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="image" name="nm" src="gr" />
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ IMAGE MANUAL ============
------------ RETURN
<input type="image" name="nm" src="gr" id="i"/>
------------ DISPLAY DIRECT
<input type="image" name="nm" src="gr" id="i"/>
------------ RETURN ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="image" name="nm" src="gr" id="i"/>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="image" name="nm" src="gr" id="i"/>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="image" name="nm" src="gr" id="i"/>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ HIDDEN DEFAULTS ============
------------ RETURN
<input type="hidden" name="nm" value="v" />
------------ DISPLAY DIRECT
<input type="hidden" name="nm" value="v" />
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
</table>
<input type="hidden" name="nm" value="v" />
<input type="hidden" name="_fields" value="nm" />
</form>

============ HIDDEN MANUAL ============
------------ RETURN
<input type="hidden" name="nm" value="v" id="i"/>
------------ DISPLAY DIRECT
<input type="hidden" name="nm" value="v" id="i"/>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
</table>
<input type="hidden" name="nm" value="v" id="i"/>
<input type="hidden" name="_fields" value="nm" />
</form>

============ BLANK DEFAULT ============
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >&nbsp;</td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >&nbsp;</td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >&nbsp;</td>
 </tr>
</table>
<input type="hidden" name="_fields" value="" />
</form>

============ BLANK MANUAL ============
------------ RETURN ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">&nbsp;</td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">&nbsp;</td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th class="h">Ttl</th>
  <td class="d">&nbsp;</td>
 </tr>
</table>
<input type="hidden" name="_fields" value="" />
</form>

============ BLANK DEFAULT 2 ============
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">&nbsp;</th>
  <td >&nbsp;</td>
 </tr>
 <tr>
  <th align="right" valign="top">&nbsp;</th>
  <td >&nbsp;</td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">&nbsp;</th>
  <td >&nbsp;</td>
 </tr>
 <tr>
  <th align="right" valign="top">&nbsp;</th>
  <td >&nbsp;</td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >&nbsp;</td>
 </tr>
</table>
<input type="hidden" name="_fields" value="" />
</form>

============ BLANK MANUAL 2 ============
------------ RETURN ROW
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">&nbsp;</td>
 </tr>
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">&nbsp;</td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">&nbsp;</td>
 </tr>
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">&nbsp;</td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" >
<table >
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">&nbsp;</td>
 </tr>
 <tr>
  <th class="h">&nbsp;</th>
  <td class="d">&nbsp;</td>
 </tr>
</table>
<input type="hidden" name="_fields" value="" />
</form>

============ FILE DEFAULTS ============
------------ RETURN
   <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
   <input type="file" name="nm" size="20" />
------------ DISPLAY DIRECT
   <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
   <input type="file" name="nm" size="20" />
------------ RETURN ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
   <input type="file" name="nm" size="20" />
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
   <input type="file" name="nm" size="20" />
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" enctype="multipart/form-data" >
<table >
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
   <input type="file" name="nm" size="20" />
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ FILE MANUAL ============
------------ RETURN
   <input type="hidden" name="MAX_FILE_SIZE" value="9" />
   <input type="file" name="nm" size="5" accept="ac" id="i"/>
------------ DISPLAY DIRECT
   <input type="hidden" name="MAX_FILE_SIZE" value="9" />
   <input type="file" name="nm" size="5" accept="ac" id="i"/>
------------ RETURN ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="hidden" name="MAX_FILE_SIZE" value="9" />
   <input type="file" name="nm" size="5" accept="ac" id="i"/>
  </td>
 </tr>
------------ DISPLAY ROW
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="hidden" name="MAX_FILE_SIZE" value="9" />
   <input type="file" name="nm" size="5" accept="ac" id="i"/>
  </td>
 </tr>
------------ DISPLAY ADD
<form action="test.php" method="get" enctype="multipart/form-data" >
<table >
 <tr>
  <th class="h">Ttl</th>
  <td class="d">
   <input type="hidden" name="MAX_FILE_SIZE" value="9" />
   <input type="file" name="nm" size="5" accept="ac" id="i"/>
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>

============ MULTIPLE FILES DEFAULTS ============
------------ RETURN
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
<input type="file" name="userfile[]" size="20" /><br />
<input type="file" name="userfile[]" size="20" /><br />
<input type="file" name="userfile[]" size="20" /><br />
============ MULTIPLE FILES MANUAL ============
------------ RETURN
<input type="hidden" name="MAX_FILE_SIZE" value="9" />
<input type="file" name="nm" size="5" accept="ac" id="i"/><br />
<input type="file" name="nm" size="5" accept="ac" id="i"/><br />
============ FORM MANUAL ============
<form action="test.php" method="post" name="nm" target="tgt" enctype="enc" id="i">
<table class="tbl">
 <caption class="cap">
  A Caption For You
 </caption>
 <tr>
  <th align="right" valign="top">Ttl</th>
  <td >
   <input type="text" name="nm" size="20" value="" />
  </td>
 </tr>
</table>
<input type="hidden" name="_fields" value="nm" />
</form>
