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

$devices = json_decode(file_get_contents(__DIR__ . '/src/Detector/Factory/data/devices.json'));
$sourceDirectory = 'src\\Detector\\Factory\\Device\\';

$iterator = new \RecursiveDirectoryIterator($sourceDirectory);

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $factoryFile    = $file->getPathname();
    echo 'checking Factory ', $factoryFile, PHP_EOL;

    $factoryContent = file_get_contents($factoryFile);

    $classMatches = [];
    $baseName     = '';

    $matchCount = preg_match_all('/return new Device\\\\([^\\(]+)\\(\$useragent\\)\\;/', $factoryContent, $classMatches);

    if (false === $matchCount) {
        echo 'checking Factory ', $factoryFile, ' failed', PHP_EOL;
        continue;
    }

    if (!$matchCount) {
        $classMatches2 = [];
        $baseName      = str_replace('Factory', '', $file->getBasename('.php'));
        //var_dump('/return new ' . $baseName . '\\\\([^\\(]+)\\(\\$useragent\\)\\;/');
        $matchCount2   = preg_match_all('/return new ' . $baseName . '\\\\([^\\(]+)\\(\\$useragent\\)\\;/', $factoryContent, $classMatches2);

        if (false === $matchCount2) {
            echo 'checking Factory ', $factoryFile, ' failed', PHP_EOL;
            continue;
        }

        if (!$matchCount2) {
            echo 'no matches in Factory ', $factoryFile, PHP_EOL;

            continue;
        }

        foreach ($classMatches2[0] as $id => $rule) {
            $classMatches2[1][$id] = 'Device\\Mobile\\' . $baseName . '\\' . $classMatches2[1][$id];
        }

        $classMatches = $classMatches2;
    } else {
        foreach ($classMatches[0] as $id => $rule) {
            $classMatches[1][$id] = 'Device\\' . $classMatches[1][$id];
        }
    }

    $sourceDirectory = 'src\\Detector\\';

    $processedClases = [];

    foreach ($classMatches[1] as $index => $classBasename) {
        $classFile = $sourceDirectory . $classBasename . '.php';

        echo 'checking class ', $classFile, PHP_EOL;

        if (!file_exists($classFile)) {var_dump($classMatches);exit;
            echo 'file ', $classFile, ' not found', PHP_EOL;
            continue;
        }

        if (in_array($classBasename, $processedClases)) {
            echo 'file ', $classFile, ' already done', PHP_EOL;
            continue;
        }

        $processedClases[] = $classBasename;

        $className = '\\BrowserDetector\\Detector\\' . $classBasename;
        /** @var \UaResult\Device\DeviceInterface $class */
        $class = new $className('');

        $longKey   = strtolower($class->getBrand() . ' ' . $class->getDeviceName());
        $deviceKey = strtolower($class->getDeviceName());

        if (isset($devices->$longKey)) {
            $deviceKey = $longKey;
        }

        if (!isset($devices->$deviceKey)) {
            echo 'device key ', $deviceKey, ' not found', PHP_EOL;
            continue;
        }

        $factoryContent = str_replace($classMatches[0][$index], '$deviceCode = \'' . $deviceKey . '\';', $factoryContent);
    }
    file_put_contents($factoryFile, $factoryContent);
}
