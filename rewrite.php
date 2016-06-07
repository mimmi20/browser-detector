<?php
chdir(__DIR__);

require 'vendor/autoload.php';

ini_set('memory_limit', '-1');

$checks          = [];
$data            = [];
$sourceDirectory = 'tests/issues/';

$iterator = new \DirectoryIterator($sourceDirectory);
$files = scandir($sourceDirectory, SCANDIR_SORT_ASCENDING);

foreach ($files as $filename) {
    $file = new \SplFileInfo($sourceDirectory . DIRECTORY_SEPARATOR . $filename);

    echo 'checking file ', $file->getBasename(), ' ...', PHP_EOL;

    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    echo 'reading file ', $file->getBasename(), ' ...', PHP_EOL;

    $tests = require_once $file->getPathname();

    $outputDetector  = "<?php\n\nreturn [\n";

    foreach ($tests as $key => $test) {
        if (isset($data[$key])) {
            // Test data is duplicated for key
            echo 'Test data is duplicated for key "' . $key . '"', PHP_EOL;
            unset($tests[$key]);
            continue;
        }

        if (isset($checks[$test['ua']])) {
            // UA was added more than once
            echo 'UA "' . $test['ua'] . '" added more than once, now for key "' . $key . '", before for key "'
                . $checks[$test['ua']] . '"', PHP_EOL;
            unset($tests[$key]);
            continue;
        }

        $data[$key]          = $test;
        $checks[$test['ua']] = $key;

        $outputDetector .= "    '$key' => [
        'ua'         => '" . str_replace("'", "\\'", $test['ua']) . "',
        'properties' => [
            'Browser_Name'            => '" . str_replace("'", "\\'", $test['properties']['Browser_Name']) . "',
            'Browser_Type'            => '" . str_replace("'", "\\'", $test['properties']['Browser_Type']) . "',
            'Browser_Bits'            => " . str_replace("'", "\\'", $test['properties']['Browser_Bits']) . ",
            'Browser_Maker'           => '" . str_replace("'", "\\'", $test['properties']['Browser_Maker']) . "',
            'Browser_Modus'           => '" . str_replace("'", "\\'", $test['properties']['Browser_Modus']) . "',
            'Browser_Version'         => '" . str_replace("'", "\\'", $test['properties']['Browser_Version']) . "',
            'Platform_Name'           => '" . str_replace("'", "\\'", $test['properties']['Platform_Name']) . "',
            'Platform_Version'        => '" . str_replace("'", "\\'", $test['properties']['Platform_Version']) . "',
            'Platform_Bits'           => " . str_replace("'", "\\'", $test['properties']['Platform_Bits']) . ",
            'Platform_Maker'          => '" . str_replace("'", "\\'", $test['properties']['Platform_Maker']) . "',
            'Device_Name'             => '" . str_replace("'", "\\'", $test['properties']['Device_Name']) . "',
            'Device_Maker'            => '" . str_replace("'", "\\'", $test['properties']['Device_Maker']) . "',
            'Device_Type'             => '" . str_replace("'", "\\'", $test['properties']['Device_Type']) . "',
            'Device_Pointing_Method'  => '" . str_replace("'", "\\'", $test['properties']['Device_Pointing_Method']) . "',
            'Device_Code_Name'        => '" . str_replace("'", "\\'", $test['properties']['Device_Code_Name']) . "',
            'Device_Brand_Name'       => '" . str_replace("'", "\\'", $test['properties']['Device_Brand_Name']) . "',
            'RenderingEngine_Name'    => '" . str_replace("'", "\\'", $test['properties']['RenderingEngine_Name']) . "',
            'RenderingEngine_Version' => '" . str_replace("'", "\\'", $test['properties']['RenderingEngine_Version']) . "',
            'RenderingEngine_Maker'   => '" . str_replace("'", "\\'", $test['properties']['RenderingEngine_Maker']) . "',
        ],
    ],\n";

    }

    $outputDetector .= "];\n";

    file_put_contents($file->getPathname(), $outputDetector);
}