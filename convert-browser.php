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

$factoryFile    = 'src\\Detector\\Factory\\BrowserFactory.php';
$factoryContent = file_get_contents($factoryFile);

$classMatches = [];

preg_match_all('/return new Browser\\\\([^\(]+)\(\$useragent, \[\]\)\;/', $factoryContent, $classMatches);
$sourceDirectory = 'src\\Detector\\Browser\\';

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
}

$iterator = new \RecursiveDirectoryIterator($sourceDirectory);

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $filename = $file->getFilename();

    $skip = [
        'AbstractBrowser.php',
    ];
    
    if (in_array($filename, $skip)) {
        continue;
    }

    $fullpath    = $file->getPathname();
    $pathMatches = [];

    $filecontent = file_get_contents($fullpath);
    $matches     = [];

    if (!preg_match('/class (.*) extends AbstractBrowser/', $filecontent, $matches)
        && !preg_match('/class (.*)\\n    extends AbstractBrowser/', $filecontent, $matches)
    ) {
        echo 'class name not found in file ', $fullpath, PHP_EOL;
        continue;
    }

    $classBasename = $file->getBasename('.php');

    if (in_array($classBasename, $processedClases)) {
        continue;
    }

    echo 'processing ', $fullpath, PHP_EOL;

    $endpos = strpos($factoryContent, "        }\n\n        return new Browser\\UnknownBrowser(\$useragent");

    if (false !== $endpos) {
        $newCall = 'return new Browser\\' . $classBasename . '($useragent, []);';

        $factoryContent = substr_replace($factoryContent, ' elseif (preg_match(\'/' . $classBasename . '/\', $useragent)) {' . "\n" . '            ' . $newCall . "\n" . '        }', $endpos + 9, 0);
        file_put_contents($factoryFile, $factoryContent);

        $processedClases[] = $classBasename;
    }
}