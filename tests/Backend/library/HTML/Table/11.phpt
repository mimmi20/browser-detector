--TEST--
11.phpt: 2 row 1 column, setAutoFill / getAutoFill
--FILE--
<?php
// $Id: 11.phpt 102 2011-10-25 21:18:56Z  $
require_once 'HTML/Table.php';
$table = new HTML_Table();

$table->setAutoFill('N/A');

$data[0][] = 'Test';
$data[1][] = '';

foreach($data as $key => $value) {
    $table->addRow($value);
}

echo $table->getAutoFill() . "\n";

// output
echo $table->toHTML();
?>
--EXPECT--
N/A
<table>
    <tr>
        <td>Test</td>
    </tr>
    <tr>
        <td>N/A</td>
    </tr>
</table>