<?php
/**
 * Created by PhpStorm.
 * User: Thomas Müller
 * Date: 03.03.2016
 * Time: 07:22
 */

chdir(__DIR__);

require 'vendor/autoload.php';

ini_set('memory_limit', '-1');

$factoryFile    = 'src\\Detector\\Factory\\PlatformFactory.php';
$factoryContent = file_get_contents($factoryFile);

$classMatches = [];

preg_match_all('/return new Os\\\\([^\(]+)\(\$agent\)\;/', $factoryContent, $classMatches);
$sourceDirectory = 'src\\Detector\\Os\\';

$processedClases = [];

foreach ($classMatches[1] as $index => $classBasename) {
    $classFile = $sourceDirectory . $classBasename . '.php';

    echo 'checking ', $classFile, PHP_EOL;

    if (!file_exists($classFile)) {
        continue;
    }

    if (in_array($classBasename, $processedClases)) {
        continue;
    }

    $processedClases[] = $classBasename;

    $className = '\\BrowserDetector\\Detector\\Os\\' . $classBasename;
    $class = new $className('');
    $factoryContent = str_replace($classMatches[0][$index], '$platformCode = \'' . strtolower($class->getName()) . '\';', $factoryContent);
}
file_put_contents($factoryFile, $factoryContent);