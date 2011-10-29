--TEST--
8.phpt: testing taboffset
--FILE--
<?php
// $Id: 8.phpt 102 2011-10-25 21:18:56Z  $
require_once 'HTML/Table.php';
$table = new HTML_Table('', 1);

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