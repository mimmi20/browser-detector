<?php

/*
* This example shows how you can set row and col attributes
* with HTML_Table.
*/
// $Id: Table_example12.php 86 2011-10-13 19:17:16Z tmu $

require_once 'HTML/Common3/Root/Table.php';

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL | E_STRICT);

$table =& new HTML_Common3_Root_Table('width = "400"');

$data[0][] = 'i am';
$data[0][] = 'i think';
$data[0][] = 'therefore';
$data[0][] = 'therefore';

$data[1][] = 'i think';
$data[1][] = 'i am';
$data[1][] = 'therefore';
$data[1][] = 'therefore';

$data[2][] = 'i am';
$data[2][] = 'therefore';
$data[2][] = 'i think';
$data[2][] = 'i think';

foreach($data as $key => $value) {
    $table->addRow($data[$key], array(array('style' => 'background-color:blue;text-align:center;'), 
                                                           array('style' => 'background-color:green;'), 
                                                           array('style' => 'background-color:red;')));
}

foreach($data as $key => $value) {
    $table->addRow($data[$key], array('style = "background-color:blue;"','style = "background-color:green;"','style = "background-color:red;"'));
}

foreach($data as $key => $value) {
    $table->addRow($data[$key], 'style = "background-color:yellow;text-align:right;"', 'TD', true);//OK
}

foreach($data as $key => $value) {
    $table->addRow($data[$key], array('style' => 'background-color:pink;text-align:center;'));//OK
}

$table->setColAttributes(1, 'style = "background-color:purple;"');//OK
$table->updateColAttributes(2, array('style = "background-color:blue;"','style = "background-color:green;"','style = "background-color:red;"'));

echo '<pre>';
var_dump($table->getCellAttributes(2, 2));//OK
var_dump($table->getRowAttributes(8));//OK
echo '</pre>';
echo $table->toHTML();
?>