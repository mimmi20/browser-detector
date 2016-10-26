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
$browsers = [];

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $fullpath    = $file->getPathname();
    $pathMatches = [];

    $filecontent      = file_get_contents($fullpath);
    $marketingMatches = [];

    if (!preg_match('/\\$this\\-\\>manufacturer                = CompanyFactory::get\\(\\\'([^\\\']+)/', $filecontent, $marketingMatches)) {
        continue;
    }

    $browserName = '\\BrowserDetector\\Detector\\Browser\\' . $file->getBasename('.php');
    /** @var \BrowserDetector\Detector\Browser\AbstractBrowser $browser */
    $browser     = new $browserName('');

    echo 'processing ', $fullpath, PHP_EOL;

    /*
    $marketingMatches = [];

    if (preg_match('/\\$this\\-\\>manufacturer                = CompanyFactory::get\\(\\\'([^\\\']+)/', $filecontent, $marketingMatches)) {
        $manufacturer = $marketingMatches[1];
    } else {
        $manufacturer = 'Unknown';
    }

    $templateContent = str_replace(
        'CompanyFactory::get(\'' . $manufacturer . '\')->getName()',
        'CompanyFactory::get(\'' . $manufacturer . '\')->getName();' . "\n" . '        $this->brand                       = CompanyFactory::get(\'' . $manufacturer . '\')->getBrandName()',
        $filecontent
    );

    file_put_contents($fullpath, $templateContent);

    if (false !== strpos($templateContent, '#')) {
        echo 'placeholders found in file ', $fullpath, PHP_EOL;
        exit;
    }
    /**/
    //exit;
    $browsers[strtolower($browser->getName())] = [
        'name' => $browser->getName(),
        'manufacturer' => $browser->getManufacturer(),
        'brand' => $browser->getBrand(),
        'pdfSupport' => $browser->getPdfSupport(),
        'rssSupport' => $browser->getRssSupport(),
        'canSkipAlignedLinkRow' => $browser->getCanSkipAlignedLinkRow(),
        'claimsWebSupport' => $browser->getClaimsWebSupport(),
        'supportsEmptyOptionValues' => $browser->getSupportsEmptyOptionValues(),
        'supportsBasicAuthentication' => $browser->getSupportsBasicAuthentication(),
        'supportsPostMethod' => $browser->getSupportsPostMethod(),
        'type' => str_replace('UaBrowserType\\', '', get_class($browser->getType())),
        'version' => null,
        'engine' => null,
    ];

    if (preg_match('/VersionFactory::detectVersion\\(\\$useragent\, ([^\\)]+)/', $filecontent, $colorMatches)) {
        $browsers[strtolower($browser->getName())]['version'] = ['class' => 'VersionFactory', 'search' => json_decode(str_replace(['\'', '\\'], ['"', '\\\\'], $colorMatches[1]))];
    } elseif (preg_match('/Version\\\\([a-zA-Z0-9]+)/', $filecontent, $colorMatches) && !in_array($colorMatches[1], ['VersionFactory', 'Version'])) {
        $browsers[strtolower($browser->getName())]['version'] = ['class' => '\\BrowserDetector\\Detector\\Version\\' . $colorMatches[1], 'search' => null];
    } else {
        $browsers[strtolower($browser->getName())]['version'] = ['class' => null, 'search' => null];
    }

    if ($browser instanceof \BrowserDetector\Matcher\Browser\BrowserHasSpecificEngineInterface) {
        var_dump(2, strtolower($browser->getEngine()->getName()));
        $browsers[strtolower($browser->getName())]['engine'] = strtolower($browser->getEngine()->getName());
    } else {
        var_dump(1);
        $browsers[strtolower($browser->getName())]['engine'] = 'unknown';
    }
}

file_put_contents('src\\Detector\\Factory\\data\\browsers.json', json_encode($browsers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));