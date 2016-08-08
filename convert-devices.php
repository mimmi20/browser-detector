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

$factoryFile    = 'src\\Detector\\Factory\\Device\\TvFactory.php';
$factoryContent = file_get_contents($factoryFile);

$classMatches = [];

preg_match_all('/return new ([^\(]+)\(\$useragent, \[\]\)\;/', $factoryContent, $classMatches);
$sourceDirectory = 'src\\Detector\\Device\\Tv\\';

$processedClases = [];

foreach ($classMatches[1] as $index => $classBasename) {
    $classFile = $sourceDirectory . $classBasename . '.php';

    echo 'processing ', $classFile, PHP_EOL;

    if (!file_exists($classFile)) {
        str_replace($classMatches[0][$index], $classMatches[0][$index] . ' // file not found', $factoryContent);
        file_put_contents($factoryFile, $factoryContent);

        continue;
    }

    if (in_array($classBasename, $processedClases)) {
        continue;
    }

    $filecontent = file_get_contents($classFile);
    $pointMatches  = [];

    if (preg_match('/\\\'pointingMethod\\\'\s+=> \\\'(\w+)\\\'/', $filecontent, $pointMatches)) {
        $pointing = '\'' . $pointMatches[1] . '\'';
    } else {
        $pointing = 'null';
    }

    $widthMatches = [];

    if (preg_match('/\\\'resolutionWidth\\\'\s+=> ([0-9nul]+)/', $filecontent, $widthMatches)) {
        $width = $widthMatches[1];
    } else {
        $width = 'null';
    }

    $heightMatches = [];

    if (preg_match('/\\\'resolutionHeight\\\'\s+=> ([0-9nul]+)/', $filecontent, $heightMatches)) {
        $height = $heightMatches[1];
    } else {
        $height = 'null';
    }

    $dualMatches = [];

    if (preg_match('/\\\'dualOrientation\\\'\s+=> (true|false|null)/', $filecontent, $dualMatches)) {
        $dual = $dualMatches[1];
    } else {
        $dual = 'null';
    }

    $colorMatches = [];

    if (preg_match('/\\\'colors\\\'\s+=> ([0-9]+)/', $filecontent, $colorMatches)) {
        $colors = $colorMatches[1];
    } else {
        $colors = 'null';
    }

    $smsMatches = [];

    if (preg_match('/\\\'smsSupport\\\'\s+=> (true|false|null)/', $filecontent, $smsMatches)) {
        $sms = $smsMatches[1];
    } else {
        $sms = 'null';
    }

    $nfcMatches = [];

    if (preg_match('/\\\'nfcSupport\\\'\s+=> (true|false|null)/', $filecontent, $nfcMatches)) {
        $nfc = $nfcMatches[1];
    } else {
        $nfc = 'null';
    }

    $quertyMatches = [];

    if (preg_match('/\\\'hasQwertyKeyboard\\\'\s+=> (true|false|null)/', $filecontent, $quertyMatches)) {
        $qwerty = $quertyMatches[1];
    } else {
        $qwerty = 'null';
    }

    $typeMatches = [];

    if (preg_match('/\\\'type\\\'\s+=> new UaDeviceType\\\\([^\\(]+)/', $filecontent, $quertyMatches)) {
        $type = $quertyMatches[1];
    } else {
        $type = 'new UaDeviceType\Unknown';
    }

    $codeMatches = [];

    if (preg_match('/\\\'deviceName\\\'\s+=> \\\'([^\\\\\']+)\\\'/', $filecontent, $codeMatches)) {
        $codename = $codeMatches[1];
    } else {
        $codename = 'unknown';
    }

    $marketingMatches = [];

    if (preg_match('/\\\'marketingName\\\'\s+=> \\\'([^\\\\\']+)\\\'/', $filecontent, $marketingMatches)) {
        $marketing = $marketingMatches[1];
    } else {
        $marketing = 'unknown';
    }

    $manuMatches = [];

    if (preg_match('/\\\'manufacturer\\\'\s+=> \\(new Company\\\\([^\\(]+)/', $filecontent, $marketingMatches)) {
        $manufacturer = $marketingMatches[1];
    } else {
        $manufacturer = 'Unknown';
    }

    $brandMatches = [];

    if (preg_match('/\\\'brand\\\'\s+=> \\(new Company\\\\([^\\(]+)/', $filecontent, $marketingMatches)) {
        $brand = $marketingMatches[1];
    } else {
        $brand = 'Unknown';
    }

    $osMatches = [];

    if (preg_match('/detectOs\\(\\)\\n    {\\n        return (new [^\\;]+)/', $filecontent, $osMatches)) {
        $os = $osMatches[1];
    } else {
        $os = 'null';
    }

    $delete         = true;
    $rewrite        = true;

    if ($rewrite) {
        $newCall = 'return new \UaResult\Device\Device($useragent, \'' . $codename . '\', null, CompanyFactory::get(\'' . $manufacturer . '\')->getName(), new UaDeviceType\\' . $type . '(), CompanyFactory::get(\'' . $brand . '\')->getName(), \'' . $marketing . '\', ' . $pointing . ', ' . $width . ', ' . $height . ', ' . $dual . ', ' . $colors . ', ' . $sms . ', ' . $nfc . ', ' . $qwerty . ', ' . $os . ');';

        $factoryContent = str_replace($classMatches[0][$index], $newCall, $factoryContent);
        file_put_contents($factoryFile, $factoryContent);

        $processedClases[] = $classBasename;
    } else {
        $delete = false;
    }

    if ($delete) {
        echo 'removing ', $classFile, PHP_EOL;

        unlink($classFile);
    }
}

exit;
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

    if (preg_match('/\\\'pointing_method\\\'\s+=> \\\'(\w+)\\\'/', $filecontent, $matches)) {
        $pointing = '\'' . $matches[1] . '\'';
    } else {
        $pointing = 'null';
    }

    if (preg_match('/\\\'resolution_width\\\'\s+=> ([0-9nul]+)/', $filecontent, $matches)) {
        $width = $matches[1];
    } else {
        $width = 'null';
    }

    if (preg_match('/\\\'resolution_height\\\'\s+=> ([0-9nul]+)/', $filecontent, $matches)) {
        $height = $matches[1];
    } else {
        $height = 'null';
    }

    if (preg_match('/\\\'dual_orientation\\\'\s+=> (true|false|null)/', $filecontent, $matches)) {
        $dual = $matches[1];
    } else {
        $dual = 'null';
    }

    if (preg_match('/\\\'colors\\\'\s+=> ([0-9]+)/', $filecontent, $matches)) {
        $colors = $matches[1];
    } else {
        $colors = 'null';
    }

    if (preg_match('/\\\'sms_enabled\\\'\s+=> (true|false|null)/', $filecontent, $matches)) {
        $sms = $matches[1];
    } else {
        $sms = 'null';
    }

    if (preg_match('/\\\'nfc_support\\\'\s+=> (true|false|null)/', $filecontent, $matches)) {
        $nfc = $matches[1];
    } else {
        $nfc = 'null';
    }

    if (preg_match('/\\\'has_qwerty_keyboard\\\'\s+=> (true|false|null)/', $filecontent, $matches)) {
        $qwerty = $matches[1];
    } else {
        $qwerty = 'null';
    }

    if (preg_match('/getDeviceType\\(\\)\\n    {\\n        return new ([^\\(]+)/', $filecontent, $matches)) {
        $type = $matches[1];
    } else {
        $type = 'Unknown';
    }

    if (preg_match('/\\\'code_name\\\'\s+=> \\\'([^\\\\\']+)\\\'/', $filecontent, $matches)) {
        $codename = $matches[1];
    } else {
        $codename = 'unknown';
    }

    if (preg_match('/\\\'marketing_name\\\'\s+=> \\\'([^\\\\\']+)\\\'/', $filecontent, $matches)) {
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
        $os = 'UnknownOs';
    }
}