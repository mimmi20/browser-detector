--TEST--
20.phpt: addRow with indexed columns (row 0, col 3; row 1, col 2)
--FILE--
<?php
// $Id: 20.phpt 102 2011-10-25 21:18:56Z  $
require_once 'HTML/Table.php';
$table = new HTML_Table();

$data[0][3] = 'Test';
$data[1][2] = 'Test';

foreach($data as $key => $value) {
    $table->addRow($value);
}

// output
echo $table->toHTML();
?>
--EXPECT--
<table>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Test</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Test</td>
        <td>&nbsp;</td>
    </tr>
</table>