--TEST--
19.phpt: addCol 2 cell 2 column with no extra options
--FILE--
<?php
// $Id: 19.phpt 102 2011-10-25 21:18:56Z  $
require_once 'HTML/Table.php';
$table = new HTML_Table();

$data[0][] = 'Test';
$data[0][] = 'Test';
$data[1][] = 'Test';
$data[1][] = 'Test';

foreach($data as $key => $value) {
    $table->addCol($value);
}

// output
echo $table->toHTML();
?>
--EXPECT--
<table>
    <tr>
        <td>Test</td>
        <td>Test</td>
    </tr>
    <tr>
        <td>Test</td>
        <td>Test</td>
    </tr>
</table>