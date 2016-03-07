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

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $filename = $file->getFilename();

    if ('AbstractOs.php' === $filename || 'Aix.php' === $filename) {
        continue;
    }

    $fullpath    = $file->getPathname();

    $template = 'data/templates/general-os.php.tmp';

    $filecontent     = file_get_contents($fullpath);
    $templateContent = file_get_contents($template);
    $matches         = [];

    if (!preg_match('/class (.*) extends AbstractOs/', $filecontent, $matches)
        && !preg_match('/class (.*)\\n    extends AbstractOs/', $filecontent, $matches)
    ) {
        echo 'class name not found in file ', $fullpath, PHP_EOL;
        exit;
    }

    echo 'processing ', $fullpath, PHP_EOL;

    $templateContent = str_replace(
        ['###ClassName###'],
        [$matches[1]],
        $templateContent
    );

    if (preg_match('/\\\'name\\\'\s+ => \\\'([^\\\\\']+)\\\'/', $filecontent, $matches)) {
        $codename = $matches[1];
    } else {
        $codename = 'unknown';
    }

    if (preg_match('/getManufacturer\\(\\)\\n    {\\n        return new Company\\(new Company\\\\([^\\(]+)/', $filecontent, $matches)) {
        $manufacturer = $matches[1];
    } else {
        $manufacturer = 'Unknown';
    }

    if (preg_match('/private function detectVersion/', $filecontent)) {
        $pos1 = strpos($filecontent, 'private function detectVersion');
        $pos2 = strpos($filecontent, '{', $pos1);
        $pos3 = strpos($filecontent, "\n    }", $pos2);
        $check = trim(substr($filecontent, $pos2 + 1, $pos3 - $pos2));
    } else {
        $check = 'return null;';
    }

    $templateContent = str_replace(
        ['###codename###', '###Manu###', '###detectVersion###'],
        [$codename, $manufacturer, $check],
        $templateContent
    );

    file_put_contents($fullpath, $templateContent);

    if (false !== strpos($templateContent, '#')) {
        echo 'placeholders found in file ', $fullpath, PHP_EOL;
        exit;
    }
}