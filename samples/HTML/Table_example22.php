<?php

/*
* This example will output html websafe colors in a table
* using HTML_Table.
*/
// $Id: Table_example22.php 86 2011-10-13 19:17:16Z tmu $

require_once 'HTML/Common3/Root/Table.php';

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL | E_Strict);

$table =& new HTML_Common3_Root_Table('width = "100%"');
$table->setCaption('256 colors table');
$i = $j = 0;
for ($R = 0; $R <= 255; $R += 51) {
    for ($G = 0; $G <= 255; $G += 51) {
        for($B = 0; $B <= 255; $B += 51) {
            $table->setCellAttributes($i, $j, 'style="background-color:#'.sprintf('%02X%02X%02X', $R, $G, $B).';"');
            $j++;
        }
    }
    $i++;
    $j = 0;
}
echo $table->toHtml();
?>