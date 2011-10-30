--TEST--
23.phpt: thead, tbody and addRow (tfoot not in output)
--FILE--
<?php
// $Id$
require_once 'HTML/Table.php';
$table = new HTML_Table();

$thead =& $table->getHeader();
$tbody =& $table->getBody();

$data[0][] = 'Test';
$data[1][] = 'Test';

foreach($data as $key => $value) {
    $thead->addRow($value);
    $tbody->addRow($value);
}

// output
echo $table->toHTML();
?>
--EXPECT--
<table>
    <thead>
        <tr>
            <td>Test</td>
        </tr>
        <tr>
            <td>Test</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Test</td>
        </tr>
        <tr>
            <td>Test</td>
        </tr>
    </tbody>
</table>