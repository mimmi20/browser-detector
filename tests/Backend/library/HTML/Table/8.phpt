--TEST--
8.phpt: testing taboffset
--FILE--
<?php
// $Id$
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