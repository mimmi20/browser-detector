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

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $filename = $file->getFilename();

    if ('AbstractDevice.php' === $filename || 'HiPhone.php' === $filename) {
        continue;
    }

    $fullpath    = $file->getPathname();
    $pathMatches = [];

    if (preg_match('/Detector\\\\Device\\\\(Desktop|Tv)\\\\([^\\.]+)/', $fullpath, $pathMatches)) {
        $template = 'data/templates/general-tv-device.php.tmp';
    } elseif (preg_match('/Detector\\\\Device\\\\(Desktop|Mobile|Tv)\\\\([^\\\\]+)\\\\([^\\.]+)/', $fullpath, $pathMatches) && $pathMatches[1] === 'Mobile') {
        $template = 'data/templates/general-sub-device.php.tmp';
    } elseif (preg_match('/Detector\\\\Device\\\\(Mobile)\\\\([^\\.]+)/', $fullpath, $pathMatches)) {
        $template = 'data/templates/general-device.php.tmp';
    } else {
        $template = 'data/templates/general-device.php.tmp';
    }

    $filecontent     = file_get_contents($fullpath);
    $templateContent = file_get_contents($template);
    $matches         = [];

    if (!preg_match('/class (.*) extends AbstractDevice/', $filecontent, $matches)
        && !preg_match('/class (.*)\\n    extends AbstractDevice/', $filecontent, $matches)
    ) {
        echo 'class name not found in file ', $fullpath, PHP_EOL;
        exit;
    }

    echo 'processing ', $fullpath, PHP_EOL;

    $templateContent = str_replace(
        ['###ClassName###', '###Namespace###'],
        [$matches[1], $pathMatches[1]],
        $templateContent
    );

    if (isset($pathMatches[2])) {
        $templateContent = str_replace(
            ['###Parent###'],
            [$pathMatches[2]],
            $templateContent
        );
    }

    if (preg_match('/\\\'pointing_method\\\'\s+ => \\\'(\w+)\\\'/', $filecontent, $matches)) {
        $pointing = '\'' . $matches[1] . '\'';
    } else {
        $pointing = 'null';
    }

    if (preg_match('/\\\'resolution_width\\\'\s+ => ([0-9nul]+)/', $filecontent, $matches)) {
        $width = $matches[1];
    } else {
        $width = 'null';
    }

    if (preg_match('/\\\'resolution_height\\\'\s+ => ([0-9nul]+)/', $filecontent, $matches)) {
        $height = $matches[1];
    } else {
        $height = 'null';
    }

    if (preg_match('/\\\'dual_orientation\\\'\s+ => (true|false|null)/', $filecontent, $matches)) {
        $dual = $matches[1];
    } else {
        $dual = 'null';
    }

    if (preg_match('/\\\'colors\\\'\s+ => ([0-9]+)/', $filecontent, $matches)) {
        $colors = $matches[1];
    } else {
        $colors = 'null';
    }

    if (preg_match('/\\\'sms_enabled\\\'\s+ => (true|false|null)/', $filecontent, $matches)) {
        $sms = $matches[1];
    } else {
        $sms = 'null';
    }

    if (preg_match('/\\\'nfc_support\\\'\s+ => (true|false|null)/', $filecontent, $matches)) {
        $nfc = $matches[1];
    } else {
        $nfc = 'null';
    }

    if (preg_match('/\\\'has_qwerty_keyboard\\\'\s+ => (true|false|null)/', $filecontent, $matches)) {
        $qwerty = $matches[1];
    } else {
        $qwerty = 'null';
    }

    if (preg_match('/getDeviceType\\(\\)\\n    {\\n        return new ([^\\(]+)/', $filecontent, $matches)) {
        $type = $matches[1];
    } else {
        $type = 'Unknown';
    }

    if (preg_match('/\\\'code_name\\\'\s+ => \\\'([^\\\\\']+)\\\'/', $filecontent, $matches)) {
        $codename = $matches[1];
    } else {
        $codename = 'unknown';
    }

    if (preg_match('/\\\'marketing_name\\\'\s+ => \\\'([^\\\\\']+)\\\'/', $filecontent, $matches)) {
        $marketing = $matches[1];
    } else {
        $marketing = 'unknown';
    }

    if (preg_match('/getManufacturer\\(\\)\\n    {\\n        return new Company\\(new Company\\\\([^\\(]+)/', $filecontent, $matches)) {
        $manufacturer = $matches[1];
    } else {
        $manufacturer = 'Unknown';
    }

    if (preg_match('/getBrand\\(\\)\\n    {\\n        return new Company\\(new Company\\\\([^\\(]+)/', $filecontent, $matches)) {
        $brand = $matches[1];
    } else {
        $brand = 'Unknown';
    }

    if (preg_match('/getBrand\\(\\)\\n    {\\n        return new Company\\(new Company\\\\([^\\(]+)/', $filecontent, $matches)) {
        $brand = $matches[1];
    } else {
        $brand = 'Unknown';
    }

    if (preg_match('/detectOs\\(\\)\\n    {\\n        return new ([^\\(]+)/', $filecontent, $matches)) {
        $os = $matches[1];
    } else {
        $os = 'Unknown';
    }

    if (preg_match('/getWeight\\(\\)\\n    {\\n        return ([\\d]+)/', $filecontent, $matches)) {
        $wight = $matches[1];
    } else {
        $wight = '0';
    }

    if (preg_match('/public function canHandle\\(\\)\\n    \\{(.*)\\n    \\}/', $filecontent, $matches)) {
        $check = $matches[1];
    } else {
        $check = 'return false;';
    }

    $templateContent = str_replace(
        ['###pointing###', '###width###', '###Height###', '###dual###', '###colors###', '###sms###', '###nfc###', '###querty###', '###type###', '###codename###', '###marketingname###', '###Manu###', '###Brand###', '###OS###', '###wight###', '###check###'],
        [$pointing, $width, $height, $dual, $colors, $sms, $nfc, $qwerty, $type, $codename, $marketing, $manufacturer, $brand, $os, $wight, $check],
        $templateContent
    );

    file_put_contents($fullpath, $templateContent);

    if (false !== strpos($templateContent, '#')) {
        echo 'placeholders found in file ', $fullpath, PHP_EOL;
        exit;
    }
}