--TEST--
1.phpt: addRow 1 row 1 column with no extra options
--FILE--
<?php
// $Id: 1.phpt 102 2011-10-25 21:18:56Z  $
require_once 'HTML/Table.php';
$table = new HTML_Table();

$data[0][] = 'Test';

foreach($data as $key => $value) {
    $table->addRow($value);
}

// output
echo $table->toHTML();
?>
--EXPECT--
<table>
    <tr>
        <td>Test</td>
    </tr>
</table>