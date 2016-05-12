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

$sourceDirectory = 'src/Detector/Browser/';
var_dump(realpath('src'), realpath('src/Detector'), realpath($sourceDirectory));
$iterator = new \RecursiveDirectoryIterator($sourceDirectory);

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $fullpath    = $file->getPathname();
    $filecontent = file_get_contents($fullpath);

    //echo 'checking ', $fullpath, PHP_EOL;

    if (false === strpos($filecontent, '\\BrowserDetector\\Version\\VersionFactory::')) {
        continue;
    }

    echo 'processing ', $fullpath, PHP_EOL;

    $filecontent = str_replace('use UaBrowserType;', "use UaBrowserType;\nuse BrowserDetector\\Version\\VersionFactory;", $filecontent);
    $filecontent = str_replace('\\BrowserDetector\\Version\\VersionFactory::', 'VersionFactory::', $filecontent);

    file_put_contents($fullpath, $filecontent);
}