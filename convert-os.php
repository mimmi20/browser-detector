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

$sourceDirectory = 'src\\Detector\\Os\\';

$iterator = new \RecursiveDirectoryIterator($sourceDirectory);

$platforms = [];

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $filename = $file->getFilename();

    $skip = [
        'AbstractOs.php',
    ];

    if (in_array($filename, $skip)) {
        continue;
    }

    $fullpath    = $file->getPathname();
    $pathMatches = [];

    $filecontent      = file_get_contents($fullpath);
    $marketingMatches = [];

    $fullpath    = $file->getPathname();
    $pathMatches = [];

    $filecontent      = file_get_contents($fullpath);
    $marketingMatches = [];

    //if (!preg_match('/\\$this\\-\\>name         = \\\'([^\\\']+)/', $filecontent, $marketingMatches)) {
    //    continue;
    //}

    $osName = '\\BrowserDetector\\Detector\\Os\\' . $file->getBasename('.php');
    /** @var \UaResult\Os\Os $os */
    $os     = new $osName('');

    echo 'processing ', $fullpath, PHP_EOL;

    /*
    $marketingMatches = [];

    if (preg_match('/\\$this\\-\\>name         = \\\'([^\\\']+)/', $filecontent, $marketingMatches)) {
        $manufacturer = $marketingMatches[1];
    } else {
        $manufacturer = 'Unknown';
    }

    $templateContent = str_replace(
        '$this->name         = \'' . $manufacturer . '\'',
        '$this->name         = \'' . $manufacturer . '\';' . "\n" . '        $this->marketingName = \'' . $manufacturer . '\'',
        $filecontent
    );

    file_put_contents($fullpath, $templateContent);

    if (false !== strpos($templateContent, '#')) {
        echo 'placeholders found in file ', $fullpath, PHP_EOL;
        exit;
    }
    //exit;
    /**/
    $platforms[strtolower($os->getName())] = [
        'name' => $os->getName(),
        'marketingName' => $os->getMarketingName(),
        'manufacturer' => $os->getManufacturer(),
        'brand' => $os->getBrand(),
        'version' => null,
    ];



    if (preg_match('/VersionFactory::detectVersion\\(\\$useragent\, ([^\\)]+)/', $filecontent, $colorMatches)) {
        $platforms[strtolower($os->getName())]['version'] = ['class' => 'VersionFactory', 'search' => json_decode(str_replace(['\'', '\\'], ['"', '\\\\'], $colorMatches[1]))];
    } elseif (preg_match('/Version\\\\([a-zA-Z0-9]+)/', $filecontent, $colorMatches) && !in_array($colorMatches[1], ['VersionFactory', 'Version'])) {
        $platforms[strtolower($os->getName())]['version'] = ['class' => '\\BrowserDetector\\Detector\\Version\\' . $colorMatches[1], 'search' => null];
    } else {
        $platforms[strtolower($os->getName())]['version'] = ['class' => null, 'search' => null];
    }
}

file_put_contents('src\\Detector\\Factory\\data\\platforms.json', json_encode($platforms, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));