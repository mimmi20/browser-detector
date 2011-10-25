--TEST--
22.phpt: thead, tfoot, tbody and addCol
--FILE--
<?php
// $Id$
require_once 'HTML/Table.php';
$table = new HTML_Table();

$thead =& $table->getHeader();
$tfoot =& $table->getFooter();
$tbody =& $table->getBody();

$data[0][] = 'Test';
$data[1][] = 'Test';

foreach($data as $key => $value) {
    $thead->addCol($value);
    $tfoot->addCol($value);
    $tbody->addCol($value);
}

// output
echo $table->toHTML();
?>
--EXPECT--
<table>
    <thead>
        <tr>
            <td>Test</td>
            <td>Test</td>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td>Test</td>
            <td>Test</td>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <td>Test</td>
            <td>Test</td>
        </tr>
    </tbody>
</table>