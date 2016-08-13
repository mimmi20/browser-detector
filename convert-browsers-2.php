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

$sourceDirectory = 'src\\Detector\\Browser\\';

$iterator = new \RecursiveDirectoryIterator($sourceDirectory);

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $fullpath    = $file->getPathname();
    $filecontent = file_get_contents($fullpath);

    if (false === strpos($filecontent, 'private function detectVersion')) {
        continue;
    }

    echo 'processing ', $fullpath, PHP_EOL;

    $delete         = false;
    $rename         = false;
    $rewrite        = false;
    $versionMatches = [];
    $version        = 'new Version(0)';

    $pos1 = mb_strpos($filecontent, 'private function detectVersion');
    //var_dump($pos1);
    $pos2 = mb_strrpos($filecontent, '}', -1 * (mb_strlen($filecontent) - $pos1));
    //var_dump($pos2);
    $pos3 = mb_strpos($filecontent, "\n    }", $pos2 + 1) + 5;
    $check = mb_substr($filecontent, $pos2 + 1, $pos3 - $pos2);
    //var_dump($check);
    file_put_contents($fullpath, str_replace($check, '', $filecontent));
    //exit;
    continue;

    $countNewlines = substr_count($check, "\n");

    if (0 === $countNewlines && preg_match('/return (new Version[^\\;]+)/', $check, $versionMatches)) {
        $version = $versionMatches[1];
        $delete  = true;
        $rewrite = true;
    } elseif (0 === $countNewlines && preg_match('/return (VersionFactory::detectVersion[^\\;]+)/', $check, $versionMatches)) {
        $version = str_replace('$this->useragent', '$useragent', $versionMatches[1]);
        $delete  = true;
        $rewrite = true;
    } elseif (2 === $countNewlines) {
        $serachMatches = [];

        if (preg_match('/return (VersionFactory::detectVersion\(\$this\-\>useragent, \$searches\))/', $check, $versionMatches)
            && preg_match('/\$searches = ([^\\;]+)/', $check, $serachMatches)
        ) {

            $version = str_replace(['$this->useragent', '$searches'], ['$useragent', $serachMatches[1]], $versionMatches[1]);
            $delete  = true;
            $rewrite = true;
        }
    } elseif (2 <= $countNewlines && !preg_match('/VersionFactory::set/', $check)) {
        $serachMatches = [];

        if (preg_match('/return (VersionFactory::detectVersion\(\$this\-\>useragent, \$searches\))/', $check, $versionMatches)
            && preg_match('/\$searches = ([^\\;]+)/', $check, $serachMatches)
        ) {

            $version = str_replace(['$this->useragent', '$searches'], ['$useragent', str_replace(["\r\n", "\n"], '', $serachMatches[1])], $versionMatches[1]);
            $delete  = true;
            $rewrite = true;
        }
    } else {
        var_dump($countNewlines, $check);
    }

    file_put_contents($fullpath, str_replace('$this->detectVersion()', $version, $filecontent));

    if (false !== strpos($filecontent, '#')) {
        echo 'placeholders found in file ', $fullpath, PHP_EOL;
        exit;
    }
    //exit;
}