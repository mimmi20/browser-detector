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

$sourceDirectory = 'src/Detector/Company/';

$iterator = new \RecursiveDirectoryIterator($sourceDirectory);

$companies = [];

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $filename = $file->getFilename();

    $skip = [];
    
    if (in_array($filename, $skip)) {
        continue;
    }

    $className = '\\BrowserDetector\\Detector\\Company\\' . $file->getBasename('.php');
    $class     = new $className();

    $name = $file->getBasename('.php');

    $companies[$name] = [
        'name'      => $class->name,
        'brandname' => $class->brandname,
    ];
}

file_put_contents('data/companies.json', json_encode($companies, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT));