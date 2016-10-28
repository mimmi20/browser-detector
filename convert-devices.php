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

$sourceDirectory = 'src\\Detector\\Device\\';

$iterator = new \RecursiveDirectoryIterator($sourceDirectory);

$devices = [];

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $filename = $file->getFilename();

    if ('AbstractDevice.php' === $filename) {
        continue;
    }

    $fullpath    = $file->getPathname();
    $filecontent = file_get_contents($fullpath);


    if (!preg_match('/namespace ([^;]+);/', $filecontent, $matches)) {
        echo 'namespace not found in file ', $fullpath, PHP_EOL;
        continue;
    }

    $namespace   = $matches[1];
    $pathMatches = [];

    $deviceName = '\\' . $namespace . '\\' . $file->getBasename('.php');
    /** @var \UaResult\Device\Device $device */
    $device     = new $deviceName('');

    $codename = strtolower($device->getDeviceName());

    if (isset($devices[$codename])) {
        $codename = strtolower($device->getBrand() . ' ' . $device->getDeviceName());
    }

    if (isset($devices[$codename])) {
        echo 'duplicate codename found in file ', $fullpath, PHP_EOL;
        continue;
    }

    $devices[$codename] = [
        'codename' => $device->getDeviceName(),
        'marketingName' => $device->getMarketingName(),
        'manufacturer' => $device->getManufacturer(),
        'brand' => $device->getBrand(),
        'version' => null,
        'platform' => null,
        'type' => str_replace('UaDeviceType\\', '', get_class($device->getType())),
        'pointingMethod' => $device->getPointingMethod(),
        'resolutionWidth' => (int) $device->getResolutionWidth(),
        'resolutionHeight' => (int) $device->getResolutionHeight(),
        'dualOrientation' => (bool) $device->getDualOrientation(),
        'colors' => (int) $device->getColors(),
        'smsSupport' => (bool) $device->getSmsSupport(),
        'nfcSupport' => (bool) $device->getNfcSupport(),
        'hasQwertyKeyboard' => (bool) $device->getHasQwertyKeyboard(),
    ];

    if ($device instanceof \BrowserDetector\Matcher\Device\DeviceHasSpecificPlatformInterface) {
        //var_dump(2, strtolower($device->detectOs()->getName()));
        $os = $device->detectOs();
        if (null !== $os) {
            $devices[$codename]['platform'] = strtolower($os->getName());
        }
    }
}

file_put_contents('src\\Detector\\Factory\\data\\devices.json', json_encode($devices, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
