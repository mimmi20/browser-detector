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

    $filename = $file->getFilename();

    if ('AbstractBrowser.php' === $filename || 'A6Indexer.php' === $filename) {
        continue;
    }

    $fullpath    = $file->getPathname();
    $pathMatches = [];

    $template = 'data/templates/general-browser.php.tmp';

    $filecontent     = file_get_contents($fullpath);
    $templateContent = file_get_contents($template);
    $matches         = [];

    if (!preg_match('/class (.*) extends AbstractBrowser/', $filecontent, $matches)
        && !preg_match('/class (.*)\\n    extends AbstractBrowser/', $filecontent, $matches)
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

    if (preg_match('/\\\'pdf_support\\\'\s+ => (true|false|null)/', $filecontent, $matches)) {
        $pdf = $matches[1];
    } else {
        $pdf = 'false';
    }

    if (preg_match('/\\\'rss_support\\\'\s+ => (true|false|null)/', $filecontent, $matches)) {
        $rss = $matches[1];
    } else {
        $rss = 'null';
    }

    if (preg_match('/\\\'can_skip_aligned_link_row\\\'\s+ => (true|false|null)/', $filecontent, $matches)) {
        $skipalign = $matches[1];
    } else {
        $skipalign = 'null';
    }

    if (preg_match('/\\\'device_claims_web_support\\\'\s+ => (true|false|null)/', $filecontent, $matches)) {
        $websupport = $matches[1];
    } else {
        $websupport = 'null';
    }

    if (preg_match('/\\\'empty_option_value_support\\\'\s+ => (true|false|null)/', $filecontent, $matches)) {
        $emptyoptions = $matches[1];
    } else {
        $emptyoptions = 'null';
    }

    if (preg_match('/\\\'basic_authentication_support\\\'\s+=> (true|false|null)/', $filecontent, $matches)) {
        $basic = $matches[1];
    } else {
        $basic = 'null';
    }

    if (preg_match('/\\\'post_method_support\\\'\s+ => (true|false|null)/', $filecontent, $matches)) {
        $post = $matches[1];
    } else {
        $post = 'null';
    }

    if (preg_match('/getBrowserType\\(\\)\\n    {\\n        return new ([^\\(]+)/', $filecontent, $matches)) {
        $type = $matches[1];
    } else {
        $type = 'Unknown';
    }

    if (preg_match('/getName\\(\\)\\n    {\\n        return \\\'([^\\\\\']+)\\\'/', $filecontent, $matches)) {
        $name = $matches[1];
    } else {
        $name = 'unknown';
    }

    if (preg_match('/getManufacturer\\(\\)\\n    {\\n        return new Company\\(new Company\\\\([^\\(]+)/', $filecontent, $matches)) {
        $manufacturer = $matches[1];
    } else {
        $manufacturer = 'Unknown';
    }

    if (preg_match('/getEngine\\(\\)\\n    {\\n        return new ([^\\(]+)/', $filecontent, $matches)) {
        $engine = $matches[1];
    } else {
        $engine = 'UnknownEngine';
    }

    if (preg_match('/public function detectVersion/', $filecontent)) {
        $pos1 = strpos($filecontent, 'public function detectVersion');
        $pos2 = strpos($filecontent, '{', $pos1);
        $pos3 = strpos($filecontent, "\n    }", $pos2);
        $check = trim(substr($filecontent, $pos2 + 1, $pos3 - $pos2));

        $check = str_replace(
            ['return Version::detectVersion($this->useragent, $searches);', '$detector = new Version();'],
            ['return Version::detectVersion($this->useragent, $searches);', ''],
            $check
        );
    } else {
        $check = 'return null;';
    }

    $templateContent = str_replace(
        ['###pdf###', '###rss###', '###skipalign###', '###websupport###', '###emptyoptions###', '###basic###', '###post###', '###type###', '###name###', '###Manu###', '###engine###', '###detectVersion###'],
        [$pdf, $rss, $skipalign, $websupport, $emptyoptions, $basic, $post, $type, $name, $manufacturer, $engine, $check],
        $templateContent
    );

    file_put_contents($fullpath, $templateContent);

    if (false !== strpos($templateContent, '#')) {
        echo 'placeholders found in file ', $fullpath, PHP_EOL;
        exit;
    }
}